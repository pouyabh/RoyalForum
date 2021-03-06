<?php

namespace Tests\Feature\API\v1\Auth;

use App\Models\User;
use Database\Factories\ChannelFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function registerRolesPermissions()
    {
        $Role_Database = Role::where('name', config('permission.default_roles')[0]);
        if ($Role_Database->count() < 1) {
            foreach (config('permission.default_roles') as $role) {
                Role::create([
                    'name' => $role,
                ]);
            }
        }
    }

    public function test_register_should_be_validated()
    {
        $response = $this->postJson(route('auth.register'));
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_new_user_can_register()
    {
        $this->registerRolesPermissions();
        $response = $this->postJson(route('auth.register', [
            'name' => $this->faker->name,
            'email' => $this->faker->unique->email,
            'password' => $this->faker->password,
        ]));
        $response->assertStatus(Response::HTTP_CREATED);

    }

    public function test_login_should_be_validated()
    {
        $response = $this->postJson(route('auth.login'));
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_user_can_login_with_credentials()
    {
        $user = User::factory()->create();
        $response = $this->postJson(route('auth.login', [
            'email' => $user->email,
            'password' => 'password',
        ]));
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_show_user_info_if_logged_in()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('auth.user'));
        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_logged_in_user_can_logout()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->postJson(route('auth.logout'));
        $response->assertStatus(Response::HTTP_OK);
    }

}
