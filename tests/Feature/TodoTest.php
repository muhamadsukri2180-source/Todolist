<?php

namespace Tests\Feature;

use App\Models\Todo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TodoTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_display_the_todo_list_page()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertViewIs('todos.index');
    }

    /** @test */
    public function user_can_create_a_new_todo_with_priority_and_due_date()
    {
        $response = $this->post('/todos', [
            'title' => 'Belajar Laravel Framework',
            'description' => 'Membuat aplikasi Todo List full stack',
            'priority' => 'high',
            'due_date' => '2026-10-15',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('todos', [
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
        Todo::create(['title' => 'Membeli Kopi', 'description' => 'Beli di minimarket']);
        Todo::create(['title' => 'Membaca Buku PHP', 'description' => 'Bab Laravel']);

        $response = $this->get('/?search=Kopi');

        $response->assertStatus(200);
        $response->assertSee('Membeli Kopi');
        $response->assertDontSee('Membaca Buku PHP');
    }

    /** @test */
    public function user_can_mark_todo_as_completed()
    {
        $todo = Todo::create([
            'title' => 'Tugas Matematika',
            'priority' => 'medium',
            'is_completed' => false,
        ]);

        $response = $this->patch("/todos/{$todo->id}", [
            'toggle_status' => '1',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('todos', [
            'id' => $todo->id,
            'is_completed' => true,
        ]);
    }

    /** @test */
    public function user_can_delete_a_todo()
    {
        $todo = Todo::create([
            'title' => 'Tugas Yang Mau Dihapus',
            'is_completed' => false,
        ]);

        $response = $this->delete("/todos/{$todo->id}");

        $response->assertRedirect();
        $this->assertDatabaseMissing('todos', [
            'id' => $todo->id,
        ]);
    }

    /** @test */
    public function it_calculates_correct_progress_percentage()
    {
        Todo::create(['title' => 'Task 1', 'is_completed' => true]);
        Todo::create(['title' => 'Task 2', 'is_completed' => false]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertViewHas('progressPercentage', 50);
    }
}
