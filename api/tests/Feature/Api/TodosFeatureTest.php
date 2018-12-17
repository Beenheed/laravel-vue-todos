<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class TodosApiUnitTest extends TestCase
{
    use WithFaker;

    protected $user;

    public function setUp()
    {
        parent::setUp();
    }

    /**
     * Testing index method
     */
    public function test_list_todos_success () 
    {
        $todos = factory(\App\Models\Todo::class, 5)->create();

        $response = $this->json('GET', '/api/v1/todos');
        $response->assertStatus(200)
            ->assertJsonCount(5)
            ->assertJsonStructure([
                '*' => ['id', 'title', 'description', 'done', 'due_date']
            ]);
    }

    /**
     * Testing create method
     */
    public function test_create_todo_fails_due_to_errors()
    {
        $data = [
            'title'         => '',
            'due_date'        => ''
        ];

        $response = $this->json('POST', '/api/v1/todos', $data);
        $response->assertStatus(422)
            ->assertJsonFragment(['message' => 'The given data was invalid.'])
            ->assertJsonFragment(['title' => ['The title field is required.']])
            ->assertJsonFragment(['due_date' => ['The due date field is required.']]);
    }

    public function test_create_todo_success()
    {
        $data = [
            'title'         => $this->faker->sentence,
            'description'   => $this->faker->paragraph,
            'due_date'        => $this->faker->date('Y-m-d H:i:s','now'),
            'done'          => $this->faker->boolean
        ];

        $response = $this->json('POST', '/api/v1/todos', $data);
        $response->assertStatus(201)
            ->assertJson($data);
    }

    /**
     * Testing show method
     */
    public function test_show_todo_fails_due_to_no_valid_id()
    {
        $todo = factory(\App\Models\Todo::class)->create();

        $response = $this->json('GET', '/api/v1/todos/invalid-id');
        $response->assertStatus(404);
    }

    public function test_show_todo_success()
    {
        $todo = factory(\App\Models\Todo::class)->create();

        $response = $this->json('GET', '/api/v1/todos/'.$todo->id);
        $response->assertStatus(200)
            ->assertJsonStructure(['id', 'title', 'description', 'due_date', 'done']);
    }

    /**
     * Testing update method
     */
    public function test_update_todo_fails_due_to_no_valid_id()
    {
        $todo = factory(\App\Models\Todo::class)->create();
        $data = $todo->toArray();

        $response = $this->json('PUT', '/api/v1/todos/invalid-id', $data);
        $response->assertStatus(404);
    }

    public function test_update_todo_success()
    {
        $todo = factory(\App\Models\Todo::class)->create();
        $data = $todo->toArray();
        $data['title'] = 'updated title';

        $response = $this->json('PUT', '/api/v1/todos/'.$todo->id, $data);
        $response->assertStatus(200)
            ->assertJson(['message' => 'todo updated']);
    }

    /**
     * Testing delete method
     */
    public function test_delete_todo_fails_due_to_no_valid_id()
    {
        $todo = factory(\App\Models\Todo::class)->create();

        $response = $this->json('DELETE', '/api/v1/todos/invalid_id');
        $response->assertStatus(404);
    }

    public function test_delete_todo_success()
    {
        $todo = factory(\App\Models\Todo::class)->create();

        $response = $this->json('DELETE', '/api/v1/todos/'.$todo->id);
        $response->assertStatus(200);
    }
}
