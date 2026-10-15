<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('super admin cannot manage their own account', function () {
    $admin = User::factory()->create(['role' => 'super_admin']);

    $this->actingAs($admin);

    $this->get(route('admin.users.edit', $admin->id))
        ->assertForbidden();

    $this->put(route('admin.users.update-role', $admin->id), [
        'role' => 'qa',
    ])->assertForbidden();

    $this->delete(route('admin.users.destroy', $admin->id))
        ->assertForbidden();

    $this->assertDatabaseHas('users', [
        'id' => $admin->id,
        'role' => 'super_admin',
    ]);
});
test('super admin can open another users edit page', function () {
    $admin = User::factory()->create(['role' => 'super_admin']);
    $other = User::factory()->create(['role' => 'user']);

    $this->actingAs($admin)
        ->get(route('admin.users.edit', $other->id))
        ->assertOk();
});