<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\Models\User;
use App\Models\Task;

class TasksTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_user_auth_can_list_tasks()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->getJson('/api/tasks');

        $response->assertStatus(200);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_user_auth_can_create_new_task()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)
            ->postJson('/api/tasks', [
                'title' => 'Minha tarefa',
                'description' => 'Minha descrição',
                'finished' => 0
            ]);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'title' => 'Minha tarefa',
                'description' => 'Minha descrição',
                'finished' => 0
            ]);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_user_auth_can_show_task()
    {
        // cria o usuario
        $user = factory(User::class)->create();

        // cria a tarefa
        $task = factory(Task::class)->create(['user_id' => $user->id]);

        // pega a tarefa
        $response = $this->actingAs($user)
            ->getJson("/api/tasks/". $task->id);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'title' => $task->title,
                'description' => $task->description
            ]);
    }


    public function test_user_auth_can_update_task()
    {
        // cria o usuario
        $user = factory(User::class)->create();

        // cria a tarefa
        $task = factory(Task::class)->create(['user_id' => $user->id]);

        // pega a tarefa
        $response = $this->actingAs($user)
            ->putJson("/api/tasks/". $task->id, [
                'title' => 'Meu novo titulo',
                'description' => 'Minha nova descricao',
                'finished' => 1
            ]);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'title' => 'Meu novo titulo',
                'description' => 'Minha nova descricao'
            ]);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_user_auth_can_delete_task()
    {
        // cria o usuario
        $user = factory(User::class)->create();

        // cria a tarefa
        $task = factory(Task::class)->create(['user_id' => $user->id]);

        // pega a tarefa
        $response = $this->actingAs($user)
            ->deleteJson("/api/tasks/". $task->id);

        $response->assertStatus(200)
            ->assertJsonFragment([
                'sucess' => 'Task deleted sucesfull'
            ]);
    }
}
