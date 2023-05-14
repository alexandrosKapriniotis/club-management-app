<?php

use App\Models\Club;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use DatabaseMigrations;

    protected User $user;
    public function setUp(): void
    {
        parent::setUp();

        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        /* Create admin and user roles */
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'user']);
        Club::factory()->create(['logo' => '']);
        $this->user = User::factory()->user()->create();
    }

    /** @test */
    public function a_user_can_see_the_login_screen()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);

        $response->assertSeeText('Login');
        $response->assertSeeText('Email Address');
    }

    /** @test */
    public function test_users_can_authenticate_using_the_login_screen()
    {
        $response = $this->post('/login', [
            'email' => $this->user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/');
    }

    /** @test */
    public function test_users_can_not_authenticate_with_invalid_password()
    {
        $this->post('/login', [
            'email' => $this->user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }
}
