<?php

namespace Tests\Feature\API\v1\Channel;


use App\Models\Channel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Laravel\Sanctum\Sanctum;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ChannelTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function registerRolesAndPermissions()
    {
        $roleInDatabase = Role::where('name', config('permission.default_roles')[0]);
        if ($roleInDatabase->count() < 1) {
            foreach (config('permission.default_roles') as $role) {
                Role::create([
                    'name' => $role
                ]);
            }
        }

        $permissionInDatabase = Permission::where('name', config('permission.default_permissions')[0]);
        if ($permissionInDatabase->count() < 1) {
            foreach (config('permission.default_permissions') as $permission) {
                Permission::create([
                    'name' => $permission
                ]);
            }
        }
    }

    public function test_all_channel_list_should_be_accessible()
    {

        $response = $this->get(route('channel.all'));

        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_create_new_channel()
    {
        $this->registerRolesAndPermissions();
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $user->givePermissionTo('channel management');
        $response = $this->postJson(route('channel.create'), [
            'name' => $this->faker->name,
            'slug' => $this->faker->slug,
        ]);
        $response->assertStatus(201);
    }

    public function test_create_channel_should_be_validated()
    {
        $this->registerRolesAndPermissions();
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $user->givePermissionTo('channel management');
        $response = $this->postJson(route('channel.create'), []);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_channel_update_should_be_validated()
    {
        $this->registerRolesAndPermissions();
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $user->givePermissionTo('channel management');
        $channel = Channel::factory()->create();
        $response = $this->putJson(route('channel.update', $channel), []);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_channel_update()
    {
        $this->registerRolesAndPermissions();
        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $user->givePermissionTo('channel management');
        $channel = Channel::factory()->create();
        $response = $this->json('PUT', route('channel.update', $channel->id), [
            'name' => $channel->name,
            'slug' => $channel->slug,
        ]);

        $updatedChannel = Channel::find($channel->id);

        $this->assertEquals($channel->name, $updatedChannel->name);
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_channel_delete_should_be_validated()
    {
        $this->registerRolesAndPermissions();

        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $user->givePermissionTo('channel management');
        $channel = Channel::factory()->create();
        $response = $this->deleteJson(route('channel.delete', $channel->id), []);
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_delete_channel()
    {
        $this->registerRolesAndPermissions();

        $user = User::factory()->create();
        Sanctum::actingAs($user);
        $user->givePermissionTo('channel management');
        $channel = Channel::factory()->create();
        $response = $this->json('DELETE', route('channel.delete', $channel->id), [
            'id' => $channel->id
        ]);
        $response->assertStatus(Response::HTTP_OK);
    }
}
