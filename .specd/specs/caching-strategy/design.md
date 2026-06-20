# Design — Caching Strategy

## Overview
Redis-backed cache using Laravel's Cache facade. Cache hot queries (Posts, Comments), invalidate via events, use cache busting keys for granular control. No cache stampedes (use locks). Configurable per resource type. Disabled in tests (use CACHE_DISABLED=true).

## Architecture
```
Request
  ↓ GET /api/v1/posts
  ↓
Controller calls PostRepository::list()
  ↓
Repository checks cache (key: posts:{status}:{page}:{hash})
  ↓ Cache hit
  ↓ Return cached result (fast, < 50ms)
  ↓
  ↓ Cache miss
  ↓ Query database
  ↓ Transform → store in cache (5 min TTL)
  ↓ Return result
  ↓
Model mutations (create/update/delete)
  ↓ Emit PostCreated/PostUpdated/PostDeleted event
  ↓
Event listeners flush cache
  ↓ Cache::forget('posts:*') or specific keys
  ↓ Subsequent requests rebuild cache
```

Single-post cache (1 hour) separate from list cache (5 min). Comment counts cached at 30 min.

## Components and interfaces

### Component 1: Cache Repository Pattern (PostRepository)
- **Responsibility**: Abstract cache layer from controllers
- **Methods**:
  - `list(filters, page, perPage): Collection` — returns cached list or queries DB
  - `find(id): Post` — returns cached single post or queries DB
  - `flush(pattern): void` — forget keys matching pattern
- **Contract**: Always return fresh (cache misses within TTL)
- **Input**: filter conditions, pagination params
- **Output**: Collection or single Post with relationships eager-loaded

### Component 2: Cache Keys
```php
// List cache (5 min TTL)
posts:{status}:{page}:{per_page}:{filter_hash}
  Example: posts:published:1:15:abc123def456

// Single post cache (1 hour TTL)
post:{id}
  Example: post:42

// Comment count cache (30 min TTL)
post.{id}.comments_count
  Example: post.42.comments_count
```

Filter hash = md5(json_encode(filters)) to encode complex filters as single key segment.

### Component 3: Event Listeners (Cache Invalidation)
- **PostCreated listener**: Cache::tags(['posts'])->flush() or Cache::forget('posts:*')
- **PostUpdated listener**: Cache::forget("post:{id}*") + Cache::forget('posts:*')
- **PostDeleted listener**: Cache::forget("post:{id}*") + Cache::forget('posts:*')
- **CommentCreated listener**: Cache::forget("post.{post_id}.comments_count")
- **CommentDeleted listener**: Cache::forget("post.{post_id}.comments_count")

Use events, not direct calls in Model — decoupled.

### Component 4: Cache Busting Strategy
- **Tag-based** (if using Redis Tags):
  ```php
  Cache::tags(['posts', 'published'])->put('posts:published:1:15:...', $data, 5min)
  Cache::tags(['posts'])->flush() // flush all posts
  ```
- **Pattern-based** (fallback, no tags):
  ```php
  Cache::forget('posts:*') // Redis pattern matching
  ```

Prefer tags for safety; pattern matching works with Redis driver.

### Component 5: Configuration
```php
// config/cache.php
'ttl' => [
    'posts.list' => 5 * 60,           // 5 minutes
    'posts.single' => 60 * 60,        // 1 hour
    'comments.count' => 30 * 60,      // 30 minutes
],

// .env
CACHE_DRIVER=redis    // Production
CACHE_DISABLED=true   // Testing
REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379
```

## Data models

No new database tables. Cache stored in Redis in-memory. Invalidation driven by events referencing Post/Comment/Tag models.

Cache entry format (in Redis):
```json
// posts:published:1:15:abc123 → (Serialized Collection of Posts)
{
  "data": [
    {
      "id": 1,
      "title": "...",
      "author": {"id": 1, "name": "..."},
      "tags": [...],
      "comments_count": 5
    }
  ]
}
```

## Error handling

| Scenario | Behavior |
|----------|----------|
| Redis unavailable (CACHE_DISABLED=true in tests) | Skip cache, query DB directly |
| Cache key miss | Query database, store in cache |
| Cache corruption/invalid JSON | Delete key, query fresh |
| Flush fails | Log error, continue (non-blocking) |
| Concurrent writes (race condition) | Use Cache::lock() to serialize |

On cache errors, fallback to database query (graceful degradation, no error to client).

## Verification strategy

**Unit tests** (tests/Unit/Cache/)
- PostRepository::list() with cache hit → returns cached data
- PostRepository::list() with cache miss → queries DB, stores cache
- Cache key generation → consistent hash for same filters
- InvalidatePosts listener → flushes correct keys

**Feature tests** (tests/Feature/Posts/)
- First GET /api/v1/posts → X-Cache: MISS header
- Second GET /api/v1/posts (same params) → X-Cache: HIT header
- POST /api/v1/posts (create) → flushes cache → next GET rebuilds
- PUT /api/v1/posts/{id} → flushes single post cache
- DELETE /api/v1/posts/{id} → flushes post + list cache

**Integration**
- Full cycle: GET (miss) → create post → GET (miss/rebuild) → GET (hit)
- Comment count: add comment → count cache invalidated → get post → fresh count

## Risks and open questions

- **Risk**: Cache stampede (thundering herd) if all cache expires at once — mitigate with staggered TTLs or locks
- **Decision**: Tag-based or pattern-based invalidation? (Recommend tags for clarity, but pattern works with Redis)
- **Question**: Cache relationships (author, tags) eagerly? (Current: yes, embedded in cache)
- **Testing**: CACHE_DISABLED=true means tests always hit DB (slower but cleaner assertions)
