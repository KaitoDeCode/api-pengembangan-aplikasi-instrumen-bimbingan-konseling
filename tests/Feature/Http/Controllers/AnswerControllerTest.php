<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Answer;
use App\Models\Instrument;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\AnswerController
 */
final class AnswerControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $answers = Answer::factory()->count(3)->create();

        $response = $this->get(route('answer.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AnswerController::class,
            'store',
            \App\Http\Requests\AnswerControllerStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $instrument = Instrument::factory()->create();
        $text = $this->faker->text();
        $pointFav = $this->faker->randomFloat(/** decimal_attributes **/);
        $pointUnFav = $this->faker->randomFloat(/** decimal_attributes **/);

        $response = $this->post(route('answer.store'), [
            'instrument_id' => $instrument->id,
            'text' => $text,
            'pointFav' => $pointFav,
            'pointUnFav' => $pointUnFav,
        ]);

        $answers = Answer::query()
            ->where('instrument_id', $instrument->id)
            ->where('text', $text)
            ->where('pointFav', $pointFav)
            ->where('pointUnFav', $pointUnFav)
            ->get();
        $this->assertCount(1, $answers);
        $answer = $answers->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $answer = Answer::factory()->create();

        $response = $this->get(route('answer.show', $answer));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\AnswerController::class,
            'update',
            \App\Http\Requests\AnswerControllerUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $answer = Answer::factory()->create();
        $instrument = Instrument::factory()->create();
        $text = $this->faker->text();
        $pointFav = $this->faker->randomFloat(/** decimal_attributes **/);
        $pointUnFav = $this->faker->randomFloat(/** decimal_attributes **/);

        $response = $this->put(route('answer.update', $answer), [
            'instrument_id' => $instrument->id,
            'text' => $text,
            'pointFav' => $pointFav,
            'pointUnFav' => $pointUnFav,
        ]);

        $answer->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($instrument->id, $answer->instrument_id);
        $this->assertEquals($text, $answer->text);
        $this->assertEquals($pointFav, $answer->pointFav);
        $this->assertEquals($pointUnFav, $answer->pointUnFav);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $answer = Answer::factory()->create();

        $response = $this->delete(route('answer.destroy', $answer));

        $response->assertNoContent();

        $this->assertModelMissing($answer);
    }
}
