<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\TaskStatus;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class TaskStatusTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Artisan::call('migrate');
    }

    public function testIndex(): void
    {
        $response = $this->get(route('task_statuses.index'));
        $response->assertOk();
    }

    public function testCreate()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('task_statuses.create'));
        $response->assertOk();
    }

    public function testStore(): void
    {
        $user = User::factory()->create();

        $data = [
            'name' => 'Test status'
        ];

        $response = $this->actingAs($user)->post(route('task_statuses.store'), $data);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('task_statuses', $data);
    }

    public function testEdit()
    {
        $user = User::factory()->create();

        $taskStatus = TaskStatus::factory()->create();
        $response = $this->actingAs($user)->get(route('task_statuses.edit', [$taskStatus]));
        $response->assertOk();
    }

    public function testUpdate()
    {
        $user = User::factory()->create();

        $taskStatus = TaskStatus::factory()->create();
        $factoryData = TaskStatus::factory()->make()->toArray();
        $data = ['name' => $factoryData['name']];
        $response = $this->actingAs($user)->patch(route('task_statuses.update', $taskStatus), $data);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('task_statuses', $data);
    }

    // public function testDestroy()
    // {
    //     $taskStatus = TaskStatus::factory()->create();
    //     $response = $this->delete(route('task_statuses.destroy', [$taskStatus]));
    //     $response->assertSessionHasNoErrors();
    //     $response->assertRedirect();

    //     $this->assertDatabaseMissing('task_statuses', ['id' => $taskStatus->id]);
    // }
}
