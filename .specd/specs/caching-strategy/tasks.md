# Tasks — Caching Strategy

<!--
Add tasks below grouped by wave. Each task is a checkbox item followed by a metadata block:

## Wave 1
- [ ] T1 — short imperative title
  - why: the reason this task exists (tie to a requirement)
  - role: investigator | builder | reviewer | verifier
  - files: path/a.ts, path/b.ts
  - contract: exactly what to do and what NOT to do
  - acceptance: observable criteria that make this done
  - verify: shell command (or N/A only for read-only roles)
  - depends: T-ids, or —
  - requirements: 1, 2

Rules: seven mandatory keys (why, role, files, contract, acceptance, verify, depends);
a task's deps must live in an earlier-or-equal wave; the DAG must be acyclic.
Do NOT hand-edit checkboxes — flip them with `specd task`.
-->

## Wave 1 — Configuration Foundation

- [ ] T1 — Create cache configuration
  - why: Define TTL per resource (Req 5). config/cache.php extended with custom 'ttl' array.
  - role: builder
  - files: config/cache.php
  - contract: Add 'ttl' key with: posts.list => 5*60, posts.single => 60*60, comments.count => 30*60. Keep existing Laravel cache config (driver, stores). Merge with existing file — do NOT overwrite.
  - acceptance: config/cache.php loads without error, config('cache.ttl.posts.list') returns 300
  - verify: php artisan tinker -e "echo config('cache.ttl.posts.list');"
  - depends: —
  - requirements: 5

- [ ] T2 — Create PostRepository class
  - why: Abstract cache layer from controllers (Design: Repository pattern). Central place for post queries with caching.
  - role: builder
  - files: app/Repositories/PostRepository.php
  - contract: Class with methods: list(filters, page, perPage), find(id), flush(pattern). Methods return Post collections or single Post. Use Cache facade. Do NOT implement cache logic yet — scaffolding only.
  - acceptance: Class exists, methods exist (stubs only), can instantiate, follows Laravel conventions
  - verify: php artisan tinker -e "\$repo = app(\App\Repositories\PostRepository::class); echo \$repo ? 'OK' : 'FAIL';"
  - depends: —
  - requirements: 1

## Wave 2 — Cache Layer Implementation

- [ ] T3 — Implement PostRepository::list() with caching
  - why: Cache post listings with 5-min TTL (Req 1).
  - role: builder
  - files: app/Repositories/PostRepository.php
  - contract: list(array filters, int page, int perPage): Collection. Generate cache key: md5(json filters) → cache key posts:{filters_hash}:{page}:{perPage}. Check Cache::get(key), if hit return. If miss, query Post::published()->filter(filters)->paginate(perPage), store in cache with TTL from config, return. Use Cache::remember() for atomic get/store.
  - acceptance: First call queries DB, second call (same params, within TTL) returns cached result, different params = different cache key
  - verify: php artisan test tests/Unit/Repositories/PostRepositoryTest.php -k "list_cache"
  - depends: T1, T2
  - requirements: 1

- [ ] T4 — Implement PostRepository::find() with caching
  - why: Cache single post queries with 1-hour TTL (Req 3).
  - role: builder
  - files: app/Repositories/PostRepository.php
  - contract: find(int id): ?Post. Generate cache key post:{id}. Skip caching if post.status = 'draft' (private). Use Cache::remember() with 1-hour TTL. Load relationships (author, tags, comments_count). Return null if not found.
  - acceptance: First call queries DB, second call returns cached result, draft posts bypass cache, relationships eager-loaded
  - verify: php artisan test tests/Unit/Repositories/PostRepositoryTest.php -k "find_cache"
  - depends: T1, T2
  - requirements: 3

- [ ] T5 — Implement PostRepository::flush(pattern)
  - why: Invalidate cache by key pattern (Req 2).
  - role: builder
  - files: app/Repositories/PostRepository.php
  - contract: flush(string pattern): void. Use Cache::forget(pattern) or Redis pattern matching. Support wildcards: 'posts:*', 'post:42:*'. Log flush operations to debug channel.
  - acceptance: flush('posts:*') removes all post list caches, flush('post:42:*') removes single post cache, no errors
  - verify: php artisan test tests/Unit/Repositories/PostRepositoryTest.php -k "flush"
  - depends: T3, T4
  - requirements: 2

## Wave 3 — Event-Driven Invalidation

- [ ] T6 — Create cache invalidation listeners
  - why: Invalidate cache on post/comment mutations (Req 2, 4).
  - role: builder
  - files: app/Listeners/InvalidatePostCache.php, app/Listeners/InvalidateCommentCountCache.php
  - contract: InvalidatePostCache: listen to PostCreated, PostUpdated, PostDeleted events. Call \$repository->flush('posts:*') + flush('post:' . \$post->id). InvalidateCommentCountCache: listen to CommentCreated, CommentDeleted. Call flush('post.' . \$post->id . '.comments_count'). Inject PostRepository via constructor.
  - acceptance: Listeners exist, can instantiate, handle() method exists and flushes correctly
  - verify: php artisan test tests/Unit/Listeners/InvalidateCacheTest.php
  - depends: T5
  - requirements: 2, 4

- [ ] T7 — Register listeners in EventServiceProvider
  - why: Wire events to listeners (Req 2, 4).
  - role: builder
  - files: app/Providers/EventServiceProvider.php
  - contract: In $listen, add: PostCreated => [InvalidatePostCache::class], PostUpdated => [InvalidatePostCache::class], PostDeleted => [InvalidatePostCache::class], CommentCreated => [InvalidateCommentCountCache::class], CommentDeleted => [InvalidateCommentCountCache::class]. Do NOT modify other event mappings.
  - acceptance: Event listeners registered, no syntax errors, can artisan event:list
  - verify: php artisan event:list | grep -E "PostCreated|CommentCreated"
  - depends: T6
  - requirements: 2, 4

## Wave 4 — Controller Integration

- [ ] T8 — Update Post controllers to use PostRepository
  - why: Replace raw queries with caching layer (Req 1, 3).
  - role: builder
  - files: app/Http/Controllers/PostController.php (index, show methods)
  - contract: Inject PostRepository into controller. Replace Model::all() with \$repo->list(). Replace Model::find() with \$repo->find(). Keep controller thin — only validation, authorization, response formatting. Do NOT add cache logic to controller.
  - acceptance: Controllers use PostRepository, index/show methods return cached results, no direct Model queries
  - verify: php artisan test tests/Feature/Posts/PostControllerTest.php
  - depends: T3, T4
  - requirements: 1, 3

- [ ] T9 — Add X-Cache headers to responses
  - why: Expose cache hits/misses to client (Req 1).
  - role: builder
  - files: app/Http/Middleware/CacheHeaderMiddleware.php (or add to PostController)
  - contract: In PostRepository or middleware, track if cache hit/miss. Return response with header X-Cache: HIT or X-Cache: MISS. Add optional X-Cache-TTL: {seconds} header. Middleware approach preferred for consistency across all controllers.
  - acceptance: GET /api/v1/posts returns X-Cache header, first call = MISS, second call = HIT (same params), different params = new key
  - verify: php artisan test tests/Feature/Posts/CacheHeaderTest.php
  - depends: T8
  - requirements: 1

## Wave 5 — Tests

- [ ] T10 — Write unit tests for PostRepository
  - why: Verify caching logic (Req 1, 3, 4).
  - role: builder
  - files: tests/Unit/Repositories/PostRepositoryTest.php
  - contract: Use Pest. Test: list() cache hit/miss, find() cache hit/miss, flush() removes cache, draft posts skip cache, relationships eager-loaded. Mock Cache facade for speed.
  - acceptance: 12+ assertions, all pass, coverage > 90%
  - verify: php artisan test tests/Unit/Repositories/PostRepositoryTest.php
  - depends: T3, T4, T5
  - requirements: 1, 3, 4

- [ ] T11 — Write feature tests for cache hits/misses
  - why: Verify HTTP-level caching (Req 1, 3).
  - role: builder
  - files: tests/Feature/Posts/CacheHitMissTest.php
  - contract: Use Pest with RefreshDatabase. Test: GET /api/v1/posts returns X-Cache: MISS, second call returns X-Cache: HIT, create post flushes cache, next call rebuilds (MISS).
  - acceptance: 8+ assertions, cache invalidation works end-to-end
  - verify: php artisan test tests/Feature/Posts/CacheHitMissTest.php
  - depends: T8, T9
  - requirements: 1, 2, 3

- [ ] T12 — Write integration tests for invalidation
  - why: Verify event-driven cache invalidation (Req 2, 4).
  - role: builder
  - files: tests/Feature/Posts/CacheInvalidationTest.php
  - contract: Use Pest. Test: Cache post → create post → cache flushed → next get rebuilds. Cache post → update post → cache flushed. Cache comment count → create comment → count cache invalidated. Verify state consistency.
  - acceptance: 6+ assertions, all invalidation scenarios pass
  - verify: php artisan test tests/Feature/Posts/CacheInvalidationTest.php
  - depends: T6, T7, T11
  - requirements: 2, 4

## Wave 6 — Verification

- [ ] T13 — Run full cache test suite
  - why: Verify all caching features work together.
  - role: verifier
  - files: N/A
  - contract: Run `php artisan test tests/Unit/Repositories/ tests/Feature/Posts/`. All tests pass, no skips.
  - acceptance: Exit code 0, all tests pass
  - verify: php artisan test tests/Unit/Repositories/ tests/Feature/Posts/
  - depends: T10, T11, T12
  - requirements: 1, 2, 3, 4, 5
