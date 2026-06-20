# Requirements — Caching Strategy

## Introduction
Redis-based caching layer for hot queries and computed data. Cache Posts, Comments, Tags, and frequently-accessed lists. Invalidate intelligently on mutations to keep cache fresh without stale data. Improves response times and reduces database load.

## Requirement 1 — Cache Post Queries
**User story:** As API user, I want POST list endpoints cached, so that repeated reads are fast.

**Acceptance criteria:**
1. WHEN GET /api/v1/posts with same query params within 5 minutes THE SYSTEM SHALL return cached result
2. IF cache TTL expires THEN THE SYSTEM SHALL refresh from database
3. THE SYSTEM SHALL cache with key posts:{status}:{page}:{per_page}:{filters_hash}
4. THE SYSTEM SHALL return cached response with X-Cache: HIT header

## Requirement 2 — Invalidate Post Cache on Mutations
**User story:** As content creator, I want cache invalidated when I update/delete posts, so that readers see fresh data.

**Acceptance criteria:**
1. WHEN POST /api/v1/posts created THE SYSTEM SHALL flush posts:* cache
2. WHEN PUT /api/v1/posts/{id} updated THE SYSTEM SHALL flush posts:* + single post cache
3. WHEN DELETE /api/v1/posts/{id} deleted THE SYSTEM SHALL flush posts:* + single post cache
4. THE SYSTEM SHALL emit PostCreated/PostUpdated events → listeners flush cache

## Requirement 3 — Cache Individual Post
**User story:** As API client, I want single post GET cached, so that multiple requests for same post are fast.

**Acceptance criteria:**
1. WHEN GET /api/v1/posts/{id} first called THE SYSTEM SHALL cache for 1 hour
2. IF cache hit THEN THE SYSTEM SHALL return < 50ms
3. THE SYSTEM SHALL include post relationships (author, tags, comment count) in cache
4. WHERE post.status = 'draft' THEN THE SYSTEM SHALL skip caching (private data)

## Requirement 4 — Cache Count Aggregations
**User story:** As portfolio demo, I want comment counts cached, so that list endpoints don't count repeatedly.

**Acceptance criteria:**
1. THE SYSTEM SHALL cache comment_count per post with 30-min TTL
2. WHEN comment created/deleted THE SYSTEM SHALL invalidate post comment count cache
3. THE SYSTEM SHALL use cached count in Post.count_comments accessor
4. EXCEPT when comment pagination requested THEN THE SYSTEM SHALL query fresh

## Requirement 5 — Cache Configuration
**User story:** As DevOps engineer, I want cache layer configurable, so that TTL can be tuned per environment.

**Acceptance criteria:**
1. THE SYSTEM SHALL read cache driver from .env (Redis default)
2. THE SYSTEM SHALL read TTL from config/cache.php per resource type
3. THE SYSTEM SHALL allow disabling cache via CACHE_DISABLED=true in testing
4. THE SYSTEM SHALL log cache operations (hit/miss) to debug channel

<!--
EARS patterns (each criterion must match one):
  Ubiquitous       THE SYSTEM SHALL <response>
  Event-driven     WHEN <trigger> THE SYSTEM SHALL <response>
  State-driven     WHILE <state> THE SYSTEM SHALL <response>
  Optional-feature WHERE <feature> THE SYSTEM SHALL <response>
  Unwanted         IF <condition> THEN THE SYSTEM SHALL <response>
Add more requirements as ## Requirement 2, 3, ...
-->
