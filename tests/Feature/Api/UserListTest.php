<?php

use App\Models\User;

it('returns 200 with empty data when no users exist', function () {
    $this->getJson('/api/users')
        ->assertOk()
        ->assertJsonCount(0, 'data');
});

it('returns paginated list of users with correct structure', function () {
    User::factory()->count(5)->create();

    $this->getJson('/api/users')
        ->assertOk()
        ->assertJsonStructure([
            'data' => [
                '*' => ['id', 'name', 'email', 'created_at'],
            ],
            'links' => ['first', 'last', 'prev', 'next'],
            'meta' => ['current_page', 'from', 'last_page', 'per_page', 'to', 'total'],
        ]);
});

it('returns correct user fields and masks sensitive data', function () {
    $user = User::factory()->create();

    $response = $this->getJson('/api/users');

    $response->assertOk()
        ->assertJsonFragment(['id' => $user->id, 'name' => $user->name, 'email' => $user->email])
        ->assertJsonMissing(['password'])
        ->assertJsonMissing(['remember_token']);
});

it('paginates at 10 items per page', function () {
    User::factory()->count(15)->create();

    $this->getJson('/api/users')
        ->assertOk()
        ->assertJsonCount(10, 'data')
        ->assertJsonPath('meta.per_page', 10)
        ->assertJsonPath('meta.total', 15)
        ->assertJsonPath('meta.last_page', 2);
});

it('returns second page with remaining users', function () {
    User::factory()->count(15)->create();

    $this->getJson('/api/users?page=2')
        ->assertOk()
        ->assertJsonCount(5, 'data')
        ->assertJsonPath('meta.current_page', 2);
});

it('is publicly accessible without authentication', function () {
    $this->getJson('/api/users')->assertOk();
});

it('returns users ordered by most recently created first', function () {
    $old = User::factory()->create(['created_at' => now()->subDays(2)]);
    $new = User::factory()->create(['created_at' => now()]);

    $data = $this->getJson('/api/users')->json('data');

    expect($data[0]['id'])->toBe($new->id)
        ->and($data[1]['id'])->toBe($old->id);
});
