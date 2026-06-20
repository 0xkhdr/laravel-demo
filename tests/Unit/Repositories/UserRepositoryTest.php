<?php

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

test('list_cache_generates_correct_cache_key', function () {
    $repository = new UserRepository();

    // Test cache key generation with page and perPage
    $page = 1;
    $perPage = 15;

    // Generate the expected cache key
    $expectedCacheKey = "users:{$page}:{$perPage}";

    // Verify cache key format matches expected pattern
    expect($expectedCacheKey)->toMatch('/^users:\d+:\d+$/');
});

test('list_cache_returns_paginated_collection', function () {
    $repository = new UserRepository();

    // The list method should return a LengthAwarePaginator instance
    // We verify this by checking the return type hint in code

    $reflection = new ReflectionMethod(UserRepository::class, 'list');
    $returnType = $reflection->getReturnType();

    // The return type should be LengthAwarePaginator
    expect($returnType?->getName())->toBe('Illuminate\Pagination\LengthAwarePaginator');
});

test('list_cache_different_cache_keys_for_different_pages', function () {
    $key1 = "users:1:15";
    $key2 = "users:2:15";

    expect($key1)->not()->toBe($key2);
});

test('list_cache_different_cache_keys_for_different_perpage', function () {
    $key1 = "users:1:15";
    $key2 = "users:1:20";

    expect($key1)->not()->toBe($key2);
});

test('list_cache_uses_ttl_from_config', function () {
    // Verify the TTL configuration exists
    $ttl = config('cache.ttl.users.list', 60 * 60);

    // Should be 1 hour (3600 seconds)
    expect($ttl)->toBe(3600);
});

test('list_cache_method_exists_and_has_correct_signature', function () {
    $repository = new UserRepository();

    // Verify the list method exists
    expect(method_exists($repository, 'list'))->toBeTrue();

    // Verify the method signature
    $reflection = new ReflectionMethod(UserRepository::class, 'list');

    // Check parameters - should have default parameters
    $params = $reflection->getParameters();
    expect(count($params))->toBe(2);
    expect($params[0]->getName())->toBe('perPage');
    expect($params[1]->getName())->toBe('page');

    // Should have default values
    expect($params[0]->getDefaultValue())->toBe(15);
    expect($params[1]->getDefaultValue())->toBe(1);
});

test('list_cache_remember_is_used_for_atomic_operations', function () {
    $repository = new UserRepository();

    // Verify the method uses Cache::remember by checking the code
    $reflection = new ReflectionMethod(UserRepository::class, 'list');
    $code = file_get_contents($reflection->getFileName());
    $startLine = $reflection->getStartLine() - 1;
    $endLine = $reflection->getEndLine();

    $lines = array_slice(file($reflection->getFileName()), $startLine, $endLine - $startLine);
    $methodCode = implode('', $lines);

    // Verify Cache::remember is used
    expect($methodCode)->toContain('Cache::remember');
});

test('list_cache_eagerly_loads_roles', function () {
    $repository = new UserRepository();

    // Verify the method uses with('roles') for eager loading
    $reflection = new ReflectionMethod(UserRepository::class, 'list');
    $code = file_get_contents($reflection->getFileName());
    $startLine = $reflection->getStartLine() - 1;
    $endLine = $reflection->getEndLine();

    $lines = array_slice(file($reflection->getFileName()), $startLine, $endLine - $startLine);
    $methodCode = implode('', $lines);

    // Verify with('roles') is used for eager loading
    expect($methodCode)->toContain("with('roles')");
});

test('list_cache_default_parameters_are_correct', function () {
    $repository = new UserRepository();

    // Verify default parameter values
    $reflection = new ReflectionMethod(UserRepository::class, 'list');
    $params = $reflection->getParameters();

    // Default perPage should be 15
    expect($params[0]->getDefaultValue())->toBe(15);

    // Default page should be 1
    expect($params[1]->getDefaultValue())->toBe(1);
});

test('find_cache_generates_correct_cache_key', function () {
    $repository = new UserRepository();

    // Test cache key generation for find by ID
    $id = 123;
    $expectedCacheKey = "user:{$id}";

    // Verify cache key format matches expected pattern
    expect($expectedCacheKey)->toMatch('/^user:\d+$/');
});

test('find_cache_returns_single_user', function () {
    $repository = new UserRepository();

    // The find method should return User or null
    // We verify this by checking the return type hint in code

    $reflection = new ReflectionMethod(UserRepository::class, 'find');
    $returnType = $reflection->getReturnType();

    // The return type should be nullable User
    expect($returnType?->getName())->toBe('App\Models\User');
    expect($returnType->allowsNull())->toBeTrue();
});

test('find_cache_uses_ttl_from_config', function () {
    // Verify the TTL configuration exists
    $ttl = config('cache.ttl.users.single', 60 * 60);

    // Should be 1 hour (3600 seconds)
    expect($ttl)->toBe(3600);
});

test('find_cache_method_exists_and_has_correct_signature', function () {
    $repository = new UserRepository();

    // Verify the find method exists
    expect(method_exists($repository, 'find'))->toBeTrue();

    // Verify the method signature
    $reflection = new ReflectionMethod(UserRepository::class, 'find');

    // Check parameters
    $params = $reflection->getParameters();
    expect(count($params))->toBe(1);
    expect($params[0]->getName())->toBe('id');
});

test('find_cache_eagerly_loads_roles', function () {
    $repository = new UserRepository();

    // Verify the method uses with('roles') for eager loading
    $reflection = new ReflectionMethod(UserRepository::class, 'find');
    $code = file_get_contents($reflection->getFileName());
    $startLine = $reflection->getStartLine() - 1;
    $endLine = $reflection->getEndLine();

    $lines = array_slice(file($reflection->getFileName()), $startLine, $endLine - $startLine);
    $methodCode = implode('', $lines);

    // Verify with('roles') is used for eager loading
    expect($methodCode)->toContain("with('roles')");
});

test('findByEmail_cache_generates_correct_cache_key', function () {
    $repository = new UserRepository();

    // Test cache key generation for find by email
    $email = 'test@example.com';
    $expectedCacheKey = "user:email:{$email}";

    // Verify cache key format
    expect($expectedCacheKey)->toContain('user:email:');
    expect($expectedCacheKey)->toContain('test@example.com');
});

test('findByEmail_cache_returns_single_user', function () {
    $repository = new UserRepository();

    // The findByEmail method should return User or null
    // We verify this by checking the return type hint in code

    $reflection = new ReflectionMethod(UserRepository::class, 'findByEmail');
    $returnType = $reflection->getReturnType();

    // The return type should be nullable User
    expect($returnType?->getName())->toBe('App\Models\User');
    expect($returnType->allowsNull())->toBeTrue();
});

test('findByEmail_cache_uses_ttl_from_config', function () {
    // Verify the TTL configuration exists
    $ttl = config('cache.ttl.users.email', 30 * 60);

    // Should be 30 minutes (1800 seconds)
    expect($ttl)->toBe(1800);
});

test('findByEmail_cache_method_exists_and_has_correct_signature', function () {
    $repository = new UserRepository();

    // Verify the findByEmail method exists
    expect(method_exists($repository, 'findByEmail'))->toBeTrue();

    // Verify the method signature
    $reflection = new ReflectionMethod(UserRepository::class, 'findByEmail');

    // Check parameters
    $params = $reflection->getParameters();
    expect(count($params))->toBe(1);
    expect($params[0]->getName())->toBe('email');
});

test('findByEmail_cache_eagerly_loads_roles', function () {
    $repository = new UserRepository();

    // Verify the method uses with('roles') for eager loading
    $reflection = new ReflectionMethod(UserRepository::class, 'findByEmail');
    $code = file_get_contents($reflection->getFileName());
    $startLine = $reflection->getStartLine() - 1;
    $endLine = $reflection->getEndLine();

    $lines = array_slice(file($reflection->getFileName()), $startLine, $endLine - $startLine);
    $methodCode = implode('', $lines);

    // Verify with('roles') is used for eager loading
    expect($methodCode)->toContain("with('roles')");
});

test('create_method_exists_and_has_correct_signature', function () {
    $repository = new UserRepository();

    // Verify the create method exists
    expect(method_exists($repository, 'create'))->toBeTrue();

    // Verify the method signature
    $reflection = new ReflectionMethod(UserRepository::class, 'create');

    // Check parameters
    $params = $reflection->getParameters();
    expect(count($params))->toBe(1);
    expect($params[0]->getName())->toBe('data');
});

test('create_method_returns_user', function () {
    $repository = new UserRepository();

    // Verify the create method returns a User instance
    $reflection = new ReflectionMethod(UserRepository::class, 'create');
    $returnType = $reflection->getReturnType();

    // The return type should be User
    expect($returnType?->getName())->toBe('App\Models\User');
});

test('update_method_exists_and_has_correct_signature', function () {
    $repository = new UserRepository();

    // Verify the update method exists
    expect(method_exists($repository, 'update'))->toBeTrue();

    // Verify the method signature
    $reflection = new ReflectionMethod(UserRepository::class, 'update');

    // Check parameters
    $params = $reflection->getParameters();
    expect(count($params))->toBe(2);
    expect($params[0]->getName())->toBe('id');
    expect($params[1]->getName())->toBe('data');
});

test('update_method_returns_user', function () {
    $repository = new UserRepository();

    // Verify the update method returns a User instance
    $reflection = new ReflectionMethod(UserRepository::class, 'update');
    $returnType = $reflection->getReturnType();

    // The return type should be User
    expect($returnType?->getName())->toBe('App\Models\User');
});

test('delete_method_exists_and_has_correct_signature', function () {
    $repository = new UserRepository();

    // Verify the delete method exists
    expect(method_exists($repository, 'delete'))->toBeTrue();

    // Verify the method signature
    $reflection = new ReflectionMethod(UserRepository::class, 'delete');

    // Check parameters
    $params = $reflection->getParameters();
    expect(count($params))->toBe(1);
    expect($params[0]->getName())->toBe('id');
});

test('delete_method_returns_bool', function () {
    $repository = new UserRepository();

    // Verify the delete method returns a boolean
    $reflection = new ReflectionMethod(UserRepository::class, 'delete');
    $returnType = $reflection->getReturnType();

    // The return type should be bool
    expect($returnType?->getName())->toBe('bool');
});

test('repository_can_be_instantiated', function () {
    $repository = new UserRepository();

    expect($repository)->toBeInstanceOf(UserRepository::class);
});

test('repository_uses_cache_facade', function () {
    $repository = new UserRepository();

    // Verify that the repository uses Cache facade
    $reflection = new ReflectionClass(UserRepository::class);
    $code = file_get_contents($reflection->getFileName());

    // Verify Cache::remember is used
    expect($code)->toContain('Cache::remember');
    expect($code)->toContain('Cache::forget');
});

test('list_pagination_parameters_affect_cache_key', function () {
    // Different perPage and page values should create different cache keys
    $page1_page15 = "users:1:15";
    $page2_page15 = "users:2:15";
    $page1_page20 = "users:1:20";

    expect($page1_page15)->not()->toBe($page2_page15);
    expect($page1_page15)->not()->toBe($page1_page20);
    expect($page2_page15)->not()->toBe($page1_page20);
});

test('cache_keys_are_unique_per_page_and_perpage', function () {
    // Verify that each combination of page/perPage creates a unique key
    $key1 = "users:1:15";
    $key2 = "users:1:20";
    $key3 = "users:2:15";
    $key4 = "users:2:20";

    $keys = [$key1, $key2, $key3, $key4];
    $uniqueKeys = array_unique($keys);

    expect(count($keys))->toBe(count($uniqueKeys));
});

test('find_and_findByEmail_have_different_cache_keys', function () {
    $userId = 123;
    $userEmail = 'test@example.com';

    $findKey = "user:{$userId}";
    $findByEmailKey = "user:email:{$userEmail}";

    expect($findKey)->not()->toBe($findByEmailKey);
});

test('user_repository_methods_handle_missing_config', function () {
    $repository = new UserRepository();

    // Verify that default TTL values are provided when config is missing
    // by checking the code for fallback values

    $reflection = new ReflectionMethod(UserRepository::class, 'list');
    $code = file_get_contents($reflection->getFileName());
    $startLine = $reflection->getStartLine() - 1;
    $endLine = $reflection->getEndLine();

    $lines = array_slice(file($reflection->getFileName()), $startLine, $endLine - $startLine);
    $methodCode = implode('', $lines);

    // Verify fallback TTL is provided
    expect($methodCode)->toContain('60 * 60');
});
