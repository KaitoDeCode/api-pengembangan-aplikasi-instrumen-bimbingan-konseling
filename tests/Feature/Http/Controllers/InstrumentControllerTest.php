<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Instrument;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\InstrumentController
 */
final class InstrumentControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $instruments = Instrument::factory()->count(3)->create();

        $response = $this->get(route('instrument.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\InstrumentController::class,
            'store',
            \App\Http\Requests\InstrumentControllerStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $title = $this->faker->sentence(4);
        $description = $this->faker->text();

        $response = $this->post(route('instrument.store'), [
            'title' => $title,
            'description' => $description,
        ]);

        $instruments = Instrument::query()
            ->where('title', $title)
            ->where('description', $description)
            ->get();
        $this->assertCount(1, $instruments);
        $instrument = $instruments->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $instrument = Instrument::factory()->create();

        $response = $this->get(route('instrument.show', $instrument));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\InstrumentController::class,
            'update',
            \App\Http\Requests\InstrumentControllerUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $instrument = Instrument::factory()->create();
        $title = $this->faker->sentence(4);
        $description = $this->faker->text();

        $response = $this->put(route('instrument.update', $instrument), [
            'title' => $title,
            'description' => $description,
        ]);

        $instrument->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($title, $instrument->title);
        $this->assertEquals($description, $instrument->description);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $instrument = Instrument::factory()->create();

        $response = $this->delete(route('instrument.destroy', $instrument));

        $response->assertNoContent();

        $this->assertModelMissing($instrument);
    }
}
