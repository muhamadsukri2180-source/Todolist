<?php

namespace Tests\Feature;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TodoTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create([
            'username' => 'testuser',
            'role' => 'user',
        ]);
    }

    /** @test */
    public function it_displays_the_landing_page_at_root()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertViewIs('landing');
        $response->assertSee('TaskFlow');
        $response->assertSee('Mulai Gratis Sekarang');
    }

    /** @test */
    public function guest_cannot_access_todos_page()
    {
        $response = $this->get('/tugas');
        $response->assertRedirect('/masuk');
    }

    /** @test */
    public function authenticated_user_can_display_todos_page()
    {
        $response = $this->actingAs($this->user)->get('/tugas');

        $response->assertStatus(200);
        $response->assertViewIs('todos.index');
    }

    /** @test */
    public function user_can_create_a_new_todo_with_priority_and_due_date()
    {
        $response = $this->actingAs($this->user)->post('/tugas', [
            'title' => 'Belajar Laravel Framework',
            'description' => 'Membuat aplikasi Todo List full stack',
            'priority' => 'high',
            'due_date' => '2026-10-15',
        ]);

        $response->assertRedirect('/tugas');
        $this->assertDatabaseHas('todos', [
            'user_id' => $this->user->id,
            'title' => 'Belajar Laravel Framework',
            'description' => 'Membuat aplikasi Todo List full stack',
            'priority' => 'high',
            'due_date' => '2026-10-15',
            'is_completed' => false,
        ]);
    }

    /** @test */
    public function user_can_search_todos_by_keyword()
    {
        Todo::create([
            'user_id' => $this->user->id,
            'title' => 'Membeli Kopi',
            'description' => 'Beli di minimarket',
        ]);
        Todo::create([
            'user_id' => $this->user->id,
            'title' => 'Membaca Buku PHP',
            'description' => 'Bab Laravel',
        ]);

        $response = $this->actingAs($this->user)->get('/tugas?search=Kopi');

        $response->assertStatus(200);
        $response->assertSee('Membeli Kopi');
        $response->assertDontSee('Membaca Buku PHP');
    }

    /** @test */
    public function user_can_sort_todos_by_deadline()
    {
        $near = Todo::create([
            'user_id' => $this->user->id,
            'title' => 'Tugas Dekat',
            'due_date' => '2026-09-10',
        ]);
        $far = Todo::create([
            'user_id' => $this->user->id,
            'title' => 'Tugas Jauh',
            'due_date' => '2026-12-25',
        ]);

        $responseAsc = $this->actingAs($this->user)->get('/tugas?sort=deadline_asc');
        $responseAsc->assertStatus(200);
        $this->assertEquals($near->id, $responseAsc->viewData('todos')->first()->id);

        $responseDesc = $this->actingAs($this->user)->get('/tugas?sort=deadline_desc');
        $responseDesc->assertStatus(200);
        $this->assertEquals($far->id, $responseDesc->viewData('todos')->first()->id);
    }

    /** @test */
    public function it_paginates_todos_10_per_page()
    {
        for ($i = 1; $i <= 15; $i++) {
            Todo::create([
                'user_id' => $this->user->id,
                'title' => "Tugas {$i}",
            ]);
        }

        $responsePage1 = $this->actingAs($this->user)->get('/tugas');
        $responsePage1->assertStatus(200);
        $this->assertCount(10, $responsePage1->viewData('todos'));

        $responsePage2 = $this->actingAs($this->user)->get('/tugas?page=2');
        $responsePage2->assertStatus(200);
        $this->assertCount(5, $responsePage2->viewData('todos'));
    }

    /** @test */
    public function user_can_mark_todo_as_completed()
    {
        $todo = Todo::create([
            'user_id' => $this->user->id,
            'title' => 'Tugas Matematika',
            'priority' => 'medium',
            'is_completed' => false,
        ]);

        $response = $this->actingAs($this->user)->patch("/tugas/{$todo->id}", [
            'toggle_status' => '1',
        ]);

        $response->assertRedirect('/tugas');
        $this->assertDatabaseHas('todos', [
            'id' => $todo->id,
            'is_completed' => true,
        ]);
    }

    /** @test */
    public function user_can_delete_a_todo()
    {
        $todo = Todo::create([
            'user_id' => $this->user->id,
            'title' => 'Tugas Yang Mau Dihapus',
            'is_completed' => false,
        ]);

        $response = $this->actingAs($this->user)->delete("/tugas/{$todo->id}");

        $response->assertRedirect('/tugas');
        $this->assertDatabaseMissing('todos', [
            'id' => $todo->id,
        ]);
    }

    /** @test */
    public function it_calculates_correct_progress_percentage()
    {
        Todo::create(['user_id' => $this->user->id, 'title' => 'Tugas 1', 'is_completed' => true]);
        Todo::create(['user_id' => $this->user->id, 'title' => 'Tugas 2', 'is_completed' => false]);

        $response = $this->actingAs($this->user)->get('/tugas');

        $response->assertStatus(200);
        $response->assertViewHas('progressPercentage', 50);
    }

    /** @test */
    public function user_cannot_see_or_modify_another_users_todo()
    {
        $otherUser = User::factory()->create(['username' => 'otheruser']);
        $otherTodo = Todo::create([
            'user_id' => $otherUser->id,
            'title' => 'Rahasia Pengguna Lain',
            'is_completed' => false,
        ]);

        // User A cannot see User B's todo
        $response = $this->actingAs($this->user)->get('/tugas');
        $response->assertDontSee('Rahasia Pengguna Lain');

        // User A cannot update User B's todo
        $updateResponse = $this->actingAs($this->user)->patch("/tugas/{$otherTodo->id}", [
            'toggle_status' => '1',
        ]);
        $updateResponse->assertStatus(403);

        // User A cannot delete User B's todo
        $deleteResponse = $this->actingAs($this->user)->delete("/tugas/{$otherTodo->id}");
        $deleteResponse->assertStatus(403);
    }
}
