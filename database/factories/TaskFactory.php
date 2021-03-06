<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = User::factory()->create();
        $status = TaskStatus::factory()->create();
        return [
            'name' => $this->faker->name(),
            'status_id' => $status->id,
            'created_by_id' => $user->id
        ];
    }
}
