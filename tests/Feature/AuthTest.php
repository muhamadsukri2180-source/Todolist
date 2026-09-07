<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_can_view_registration_page()
    {
        $response = $this->get('/daftar');

        $response->assertStatus(200);
        $response->assertViewIs('auth.register');
        $response->assertSee('Daftar Akun Baru');
    }

    /** @test */
    public function guest_can_register_new_account()
    {
        $response = $this->post('/daftar', [
            'name' => 'Budi Santoso',
            'username' => 'budisantoso',
            'email' => 'budi@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect('/tugas');
        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', [
            'name' => 'Budi Santoso',
            'username' => 'budisantoso',
            'email' => 'budi@example.com',
            'role' => 'user',
        ]);
    }

    /** @test */
    public function registration_auto_generates_clean_username_if_not_provided()
    {
        $response = $this->post('/daftar', [
            'name' => 'Ahmad Dahlan',
            'email' => 'ahmad@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect('/tugas');
        $this->assertAuthenticated();
        $user = User::where('email', 'ahmad@example.com')->first();
        $this->assertNotNull($user);
        $this->assertEquals('ahmad', $user->username);
    }

    /** @test */
    public function registration_fails_with_duplicate_email()
    {
        User::factory()->create([
            'email' => 'duplikat@example.com',
            'username' => 'user1',
        ]);

        $response = $this->post('/daftar', [
            'name' => 'User Kedua',
            'username' => 'user2',
            'email' => 'duplikat@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    /** @test */
    public function default_admin_account_is_automatically_ensured_by_controller()
    {
        // Database is fresh and has no users yet
        $this->assertDatabaseMissing('users', ['username' => 'admin']);

        // Visiting login page automatically initializes the admin account
        $response = $this->get('/masuk');
        $response->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'username' => 'admin',
            'role' => 'admin',
        ]);
    }

    /** @test */
    public function user_cannot_register_with_admin_username()
    {
        $response = $this->post('/daftar', [
            'name' => 'Calon Hacker',
            'username' => 'admin',
            'email' => 'fakeadmin@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors('username');
        $this->assertGuest();
    }

    /** @test */
    public function guest_can_view_login_page()
    {
        $response = $this->get('/masuk');

        $response->assertStatus(200);
        $response->assertViewIs('auth.login');
        $response->assertSee('Masuk ke Akun Anda');
    }

    /** @test */
    public function user_can_login_using_username_and_password()
    {
        $user = User::factory()->create([
            'username' => 'penggunakeren',
            'password' => Hash::make('rahasia123'),
        ]);

        $response = $this->post('/masuk', [
            'username' => 'penggunakeren',
            'password' => 'rahasia123',
        ]);

        $response->assertRedirect('/tugas');
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function login_fails_with_invalid_credentials()
    {
        User::factory()->create([
            'username' => 'penggunasalah',
            'password' => Hash::make('benar123'),
        ]);

        $response = $this->post('/masuk', [
            'username' => 'penggunasalah',
            'password' => 'salah123',
        ]);

        $response->assertSessionHasErrors('username');
        $this->assertGuest();
    }

    /** @test */
    public function authenticated_user_can_logout()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/keluar');

        $response->assertRedirect('/');
        $this->assertGuest();
    }
}
