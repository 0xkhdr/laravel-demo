# Cache Metrics Monitoring

This document describes the cache metrics and monitoring features added to the application.

## Overview

The cache metrics system tracks cache performance including hits, misses, invalidations, and time savings. It provides:

1. **CacheMetricsService** - Core service for recording and retrieving metrics
2. **ShowCacheMetricsCommand** - Artisan command to display cache statistics
3. **CacheMetricsMiddleware** - HTTP middleware to track request-level cache metrics
4. **Database logging** - Optional persistence of metrics to database

## Components

### CacheMetricsService

Located at `app/Services/CacheMetricsService.php`

Core service that handles all cache metrics tracking. It stores metrics in Redis for real-time analysis and optionally logs to database for historical data.

**Key Methods:**

- `recordHit(string $key, int $durationMs)` - Record a cache hit with duration
- `recordMiss(string $key, int $durationMs)` - Record a cache miss with duration
- `recordInvalidation(string $pattern)` - Record cache invalidation event
- `getMetrics(string $period = 'today')` - Get aggregated metrics for a period
- `getHitRate()` - Get overall cache hit rate percentage
- `getSavings()` - Calculate total time saved by caching
- `getTopCachedItems(int $limit = 10)` - Get most-hit cache keys
- `getInvalidationFrequency()` - Get pattern-based invalidation frequency
- `reset()` - Clear all metrics

### ShowCacheMetricsCommand

Located at `app/Console/Commands/ShowCacheMetricsCommand.php`

Artisan command that displays formatted cache metrics in the console.

**Usage:**

```bash
# Show metrics for today
php artisan cache:metrics

# Show metrics for a different period
php artisan cache:metrics --period=7days
php artisan cache:metrics --period=30days
```

**Output sections:**

1. **Request Statistics** - Total requests, hits, misses, hit rate
2. **Performance Metrics** - Average query/cache access times
3. **Time Savings** - Total milliseconds saved by caching
4. **Invalidation Statistics** - Count of cache invalidations
5. **Top Cached Items** - Most frequently hit cache keys
6. **Invalidation Frequency** - Most commonly invalidated patterns

### CacheMetricsMiddleware

Located at `app/Http/Middleware/CacheMetricsMiddleware.php`

Middleware that automatically tracks cache metrics for HTTP requests.

**Features:**

- Tracks request duration and cache status
- Determines cache hit/miss from response headers
- Supports X-Cache and X-Cache-Metrics headers
- Can attach metrics headers to responses (optional)

**Setup:**

Register in your middleware stack in `bootstrap/app.php`:

```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->append(\App\Http\Middleware\CacheMetricsMiddleware::class);
})
```

**Configuration:**

Add to `config/cache.php`:

```php
'metrics' => [
    'attach_headers' => false, // Set true to add X-Cache-* headers to responses
],
```

### Database Storage

Cache metrics can be persisted to database via the `cache_metrics` table.

**Migration:**

Located at `database/migrations/2026_06_20_200000_create_cache_metrics_table.php`

Run migrations:

```bash
php artisan migrate
```

**Table schema:**

```sql
CREATE TABLE cache_metrics (
    id BIGINT PRIMARY KEY,
    type ENUM('hit', 'miss', 'invalidation') NOT NULL,
    cache_key VARCHAR(255) NOT NULL,
    duration_ms INT DEFAULT 0,
    created_at TIMESTAMP,
    INDEX (type, created_at),
    INDEX (cache_key, type)
);
```

## Integration Examples

### Recording Metrics in Repository

```php
use App\Services\CacheMetricsService;

class PostRepository
{
    public function __construct(
        protected CacheMetricsService $metrics
    ) {}

    public function find(int $id): ?Post
    {
        $cacheKey = "post:{$id}";
        
        $start = microtime(true);
        $post = Cache::get($cacheKey);
        
        if ($post) {
            $duration = (int) round((microtime(true) - $start) * 1000);
            $this->metrics->recordHit($cacheKey, $duration);
        } else {
            $start = microtime(true);
            $post = Post::find($id);
            $duration = (int) round((microtime(true) - $start) * 1000);
            $this->metrics->recordMiss($cacheKey, $duration);
            
            Cache::put($cacheKey, $post, 3600);
        }
        
        return $post;
    }
}
```

### Recording Invalidations

```php
use App\Services\CacheMetricsService;

class PostObserver
{
    public function __construct(
        protected CacheMetricsService $metrics
    ) {}

    public function updated(Post $post): void
    {
        // Record the invalidation pattern
        $this->metrics->recordInvalidation("post:{$post->id}:*");
        
        // Clear cache
        Cache::forget("post:{$post->id}");
    }
}
```

## Performance Considerations

### Redis vs Database Storage

- **Redis**: Real-time metrics, fast retrieval, volatile (lost on restart)
- **Database**: Persistent storage, slower but useful for historical analysis

The service records hits/misses in Redis immediately and optionally logs to database asynchronously.

### Storage Limits

- Invalidation logs: Limited to last 1000 entries (30-day TTL)
- Per-key metrics: Stored with 30-day TTL in Redis
- Database records: Grows indefinitely (consider archiving old records)

### No Performance Degradation

The middleware and metrics recording add minimal overhead:

- Middleware: ~0.1-0.5ms per request
- recordHit/recordMiss: ~1-2ms (local operations)
- recordInvalidation: ~1-2ms

## Testing

Full test coverage is provided:

### Unit Tests
```bash
php artisan test tests/Unit/Services/CacheMetricsServiceTest.php
```

Tests cover:
- Hit/miss recording and counting
- Hit rate calculation
- Time savings computation
- Metrics aggregation
- Reset functionality

### Feature Tests - Command
```bash
php artisan test tests/Feature/Commands/ShowCacheMetricsCommandTest.php
```

Tests cover:
- Command execution
- Output formatting
- Period parameter handling

### Feature Tests - Middleware
```bash
php artisan test tests/Feature/Middleware/CacheMetricsMiddlewareTest.php
```

Tests cover:
- Request tracking
- Cache status detection
- Header attachment
- Duration measurement

### Run All Tests
```bash
php artisan test tests/Unit/Services/CacheMetricsServiceTest.php \
                   tests/Feature/Commands/ShowCacheMetricsCommandTest.php \
                   tests/Feature/Middleware/CacheMetricsMiddlewareTest.php
```

## Troubleshooting

### Metrics Not Recording

1. Check that CacheMetricsService is registered in service container
2. Verify middleware is registered in request pipeline
3. Check cache driver is configured (Redis recommended)

### Top Items Not Showing

- ArrayStore driver doesn't support key enumeration
- Use Redis driver for complete functionality
- Top items will show empty with array driver

### Database Logging Failing

- Ensure cache_metrics table exists: `php artisan migrate`
- Check database connection is configured
- Metrics still work if database logging fails (graceful degradation)

## API Reference

### CacheMetricsService Methods

#### recordHit
```php
public function recordHit(string $key, int $durationMs): void
```
Records a cache hit with access duration.

#### recordMiss
```php
public function recordMiss(string $key, int $durationMs): void
```
Records a cache miss with query duration.

#### recordInvalidation
```php
public function recordInvalidation(string $pattern): void
```
Records a cache invalidation event by pattern.

#### getMetrics
```php
public function getMetrics(string $period = 'today'): array
```
Returns aggregated metrics including:
- `hits` - Total cache hits
- `misses` - Total cache misses
- `total_requests` - Sum of hits + misses
- `hit_rate` - Percentage (0-100)
- `invalidations` - Total invalidation events
- `avg_query_time_ms` - Average miss duration
- `avg_cache_time_ms` - Average hit duration
- `total_query_time_ms` - Sum of all miss durations
- `total_cache_time_ms` - Sum of all hit durations
- `total_time_saved_ms` - Calculated time savings

#### getHitRate
```php
public function getHitRate(): float
```
Returns hit rate as percentage (0-100).

#### getSavings
```php
public function getSavings(): float
```
Returns total time saved (milliseconds) by caching.

Calculation: `(avg_query_time - avg_cache_time) * number_of_hits`

#### getTopCachedItems
```php
public function getTopCachedItems(int $limit = 10): array
```
Returns array of most-hit cache keys.

**Note**: Requires Redis driver for full functionality.

#### getInvalidationFrequency
```php
public function getInvalidationFrequency(): array
```
Returns frequency count of invalidation patterns.

#### reset
```php
public function reset(): void
```
Clears all metrics.

## Future Enhancements

Potential improvements for future versions:

1. Real-time dashboard via WebSockets
2. Grafana/Prometheus integration
3. Alerting on low hit rates
4. Per-user cache metrics
5. Cache warm-up analysis
6. Query optimization recommendations
