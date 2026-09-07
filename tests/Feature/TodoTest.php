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
    public function user_can_create_a_new_todo()
    {
        $response = $this->post('/todos', [
            'title' => 'Belajar Laravel Framework',
            'description' => 'Membuat aplikasi Todo List full stack',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('todos', [
            'title' => 'Belajar Laravel Framework',
            'description' => 'Membuat aplikasi Todo List full stack',
            'is_completed' => false,
        ]);
    }

    /** @test */
    public function user_can_mark_todo_as_completed()
    {
        $todo = Todo::create([
            'title' => 'Tugas Matematika',
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
}
