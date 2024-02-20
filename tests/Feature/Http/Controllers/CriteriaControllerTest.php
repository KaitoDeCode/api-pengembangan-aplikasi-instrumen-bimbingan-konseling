<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Criteria;
use App\Models\Criterion;
use App\Models\Instrument;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\CriteriaController
 */
final class CriteriaControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $criteria = Criteria::factory()->count(3)->create();

        $response = $this->get(route('criterion.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CriteriaController::class,
            'store',
            \App\Http\Requests\CriteriaControllerStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $instrument = Instrument::factory()->create();
        $text = $this->faker->word();
        $minimum = $this->faker->randomFloat(/** decimal_attributes **/);
        $maximum = $this->faker->randomFloat(/** decimal_attributes **/);

        $response = $this->post(route('criterion.store'), [
            'instrument_id' => $instrument->id,
            'text' => $text,
            'minimum' => $minimum,
            'maximum' => $maximum,
        ]);

        $criteria = Criterion::query()
            ->where('instrument_id', $instrument->id)
            ->where('text', $text)
            ->where('minimum', $minimum)
            ->where('maximum', $maximum)
            ->get();
        $this->assertCount(1, $criteria);
        $criterion = $criteria->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $criterion = Criteria::factory()->create();

        $response = $this->get(route('criterion.show', $criterion));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CriteriaController::class,
            'update',
            \App\Http\Requests\CriteriaControllerUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $criterion = Criteria::factory()->create();
        $instrument = Instrument::factory()->create();
        $text = $this->faker->word();
        $minimum = $this->faker->randomFloat(/** decimal_attributes **/);
        $maximum = $this->faker->randomFloat(/** decimal_attributes **/);

        $response = $this->put(route('criterion.update', $criterion), [
            'instrument_id' => $instrument->id,
            'text' => $text,
            'minimum' => $minimum,
            'maximum' => $maximum,
        ]);

        $criterion->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($instrument->id, $criterion->instrument_id);
        $this->assertEquals($text, $criterion->text);
        $this->assertEquals($minimum, $criterion->minimum);
        $this->assertEquals($maximum, $criterion->maximum);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $criterion = Criteria::factory()->create();
        $criterion = Criterion::factory()->create();

        $response = $this->delete(route('criterion.destroy', $criterion));

        $response->assertNoContent();

        $this->assertModelMissing($criterion);
    }
}
