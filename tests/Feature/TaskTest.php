<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class TaskTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Artisan::call('migrate');
    }

    public function testIndex(): void
    {
        $response = $this->get(route('tasks.index'));
        $response->assertOk();
    }

    public function testCreate()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('tasks.create'));
        $response->assertOk();
    }

    public function testStore(): void
    {
        $user = User::factory()->create();

        $data = [
            'name' => 'Test task'
        ];

        $response = $this->actingAs($user)->post(route('tasks.store'), $data);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('task_statuses', $data);
    }

    public function testEdit()
    {
        $user = User::factory()->create();

        $task = Task::factory()->create();
        $response = $this->actingAs($user)->get(route('tasks.edit', [$task]));
        $response->assertOk();
    }

    public function testUpdate()
    {
        $user = User::factory()->create();

        $task = Task::factory()->create();
        $factoryData = Task::factory()->make()->toArray();
        $data = ['name' => $factoryData['name']];
        $response = $this->actingAs($user)->patch(route('tasks.update', $task), $data);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('tasks', $data);
    }

    // public function testDestroy()
    // {
    //     $task = Task::factory()->create();
    //     $response = $this->delete(route('tasks.destroy', [$task]));
    //     $response->assertSessionHasNoErrors();
    //     $response->assertRedirect();

    //     $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    // }
}