<?php

namespace Tests\Feature;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cannot_access_admin_user_list()
    {
        $response = $this->get('/admin/pengguna');

        $response->assertRedirect('/masuk');
    }

    /** @test */
    public function regular_user_is_forbidden_from_admin_user_list()
    {
        $user = User::factory()->create([
            'role' => 'user',
        ]);

        $response = $this->actingAs($user)->get('/admin/pengguna');

        $response->assertStatus(403);
    }

    /** @test */
    public function admin_can_view_registered_users_list()
    {
        $admin = User::factory()->create([
            'username' => 'adminutama',
            'role' => 'admin',
        ]);

        $user1 = User::factory()->create([
            'name' => 'Siti Nurhaliza',
            'username' => 'sitinur',
            'email' => 'siti@example.com',
            'role' => 'user',
        ]);

        Todo::create([
            'user_id' => $user1->id,
            'title' => 'Tugas Siti',
        ]);

        $response = $this->actingAs($admin)->get('/admin/pengguna');

        $response->assertStatus(200);
        $response->assertViewIs('admin.users');
        $response->assertSee('Daftar Pengguna Terdaftar');
        $response->assertSee('Siti Nurhaliza');
        $response->assertSee('sitinur');
        $response->assertSee('siti@example.com');
        $response->assertSee('Mode Hanya Baca');
    }

    /** @test */
    public function admin_can_search_registered_users()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'Budi Sudarsono',
            'username' => 'budisudarsono',
            'email' => 'budi@bola.id',
        ]);

        User::factory()->create([
            'name' => 'Bambang Pamungkas',
            'username' => 'bambang9',
            'email' => 'bepe@bola.id',
        ]);

        $response = $this->actingAs($admin)->get('/admin/pengguna?search=Sudarsono');

        $response->assertStatus(200);
        $response->assertSee('Budi Sudarsono');
        $response->assertDontSee('Bambang Pamungkas');
    }
}
