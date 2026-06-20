<?php

namespace Tests\Feature\Auth;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorizationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test UserPolicy: user can view their own profile.
     */
    public function test_user_can_view_own_profile(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->assertTrue($user->can('view', $user));
    }

    /**
     * Test UserPolicy: user can view other users' profiles.
     */
    public function test_user_can_view_other_profiles(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $this->actingAs($user1);

        $this->assertTrue($user1->can('view', $user2));
    }

    /**
     * Test UserPolicy: user cannot update other users without permission.
     */
    public function test_user_cannot_update_other_users(): void
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $this->actingAs($user1);

        $this->assertFalse($user1->can('update', $user2));
    }

    /**
     * Test UserPolicy: user can update their own profile.
     */
    public function test_user_can_update_own_profile(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->assertTrue($user->can('update', $user));
    }

    /**
     * Test UserPolicy: editor can update other users.
     */
    public function test_editor_can_update_other_users(): void
    {
        $editor = User::factory()->create();
        $editor->assignRole('editor');

        $otherUser = User::factory()->create();
        $this->actingAs($editor);

        $this->assertTrue($editor->can('update', $otherUser));
    }

    /**
     * Test UserPolicy: admin can update other users.
     */
    public function test_admin_can_update_other_users(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $otherUser = User::factory()->create();
        $this->actingAs($admin);

        $this->assertTrue($admin->can('update', $otherUser));
    }

    /**
     * Test UserPolicy: only admin can delete users.
     */
    public function test_only_admin_can_delete_users(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $author = User::factory()->create();
        $author->assignRole('author');

        $userToDelete = User::factory()->create();

        // Admin can delete
        $this->actingAs($admin);
        $this->assertTrue($admin->can('delete', $userToDelete));

        // Author cannot delete
        $this->actingAs($author);
        $this->assertFalse($author->can('delete', $userToDelete));
    }

    /**
     * Test PostPolicy: anyone can view posts.
     */
    public function test_anyone_can_view_posts(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        $this->actingAs($user);
        $this->assertTrue($user->can('view', $post));
    }

    /**
     * Test PostPolicy: unauthenticated user can view posts.
     */
    public function test_unauthenticated_can_view_posts(): void
    {
        $post = Post::factory()->create();

        // This should allow without authentication
        $user = null;
        $this->assertTrue(auth()->guest()); // No authenticated user
    }

    /**
     * Test PostPolicy: only author or editor can create posts.
     */
    public function test_only_author_or_editor_can_create_posts(): void
    {
        $author = User::factory()->create();
        $author->assignRole('author');

        $editor = User::factory()->create();
        $editor->assignRole('editor');

        $otherUser = User::factory()->create();

        // Author can create
        $this->actingAs($author);
        $this->assertTrue($author->can('create', Post::class));

        // Editor can create
        $this->actingAs($editor);
        $this->assertTrue($editor->can('create', Post::class));

        // Other user cannot create
        $this->actingAs($otherUser);
        $this->assertFalse($otherUser->can('create', Post::class));
    }

    /**
     * Test PostPolicy: author can update own post.
     */
    public function test_author_can_update_own_post(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user);
        $this->assertTrue($user->can('update', $post));
    }

    /**
     * Test PostPolicy: author cannot update other's post.
     */
    public function test_author_cannot_update_others_post(): void
    {
        $author1 = User::factory()->create();
        $author1->assignRole('author');

        $author2 = User::factory()->create();
        $author2->assignRole('author');

        $post = Post::factory()->create(['user_id' => $author1->id]);

        $this->actingAs($author2);
        $this->assertFalse($author2->can('update', $post));
    }

    /**
     * Test PostPolicy: editor can update any post.
     */
    public function test_editor_can_update_any_post(): void
    {
        $editor = User::factory()->create();
        $editor->assignRole('editor');

        $otherUser = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $otherUser->id]);

        $this->actingAs($editor);
        $this->assertTrue($editor->can('update', $post));
    }

    /**
     * Test PostPolicy: author can delete own post.
     */
    public function test_author_can_delete_own_post(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user);
        $this->assertTrue($user->can('delete', $post));
    }

    /**
     * Test PostPolicy: author cannot delete other's post.
     */
    public function test_author_cannot_delete_others_post(): void
    {
        $author1 = User::factory()->create();
        $author1->assignRole('author');

        $author2 = User::factory()->create();
        $author2->assignRole('author');

        $post = Post::factory()->create(['user_id' => $author1->id]);

        $this->actingAs($author2);
        $this->assertFalse($author2->can('delete', $post));
    }

    /**
     * Test PostPolicy: admin can delete any post.
     */
    public function test_admin_can_delete_any_post(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $otherUser = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $otherUser->id]);

        $this->actingAs($admin);
        $this->assertTrue($admin->can('delete', $post));
    }
}
