<?php

namespace Tests\Feature;

use App\Models\Label;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class LabelTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Artisan::call('migrate');
    }

    public function testIndex(): void
    {
        $response = $this->get(route('labels.index'));
        $response->assertOk();
    }

    public function testCreate()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('labels.create'));
        $response->assertOk();
    }

    public function testStore(): void
    {
        $user = User::factory()->create();
        $data = [
            'name' => 'Test label'
        ];

        $response = $this->actingAs($user)->post(route('labels.store'), $data);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('labels', $data);
    }

    public function testEdit()
    {
        $user = User::factory()->create();
        $label = Label::factory()->create();
        $response = $this->actingAs($user)->get(route('labels.edit', [$label]));
        $response->assertOk();
    }

    public function testUpdate()
    {
        $user = User::factory()->create();
        $label = Label::factory()->create();
        $factoryData = Label::factory()->make()->toArray();
        $data = ['name' => $factoryData['name']];

        $response = $this->actingAs($user)->patch(route('labels.update', $label), $data);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertDatabaseHas('labels', $data);
    }

    public function testDestroy()
    {
        $user = User::factory()->create();
        $label = Label::factory()->create();

        $response = $this->actingAs($user)->delete(route('labels.destroy', [$label]));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();
        $this->assertSoftDeleted('labels', ['id' => $label->id]);
    }
}
