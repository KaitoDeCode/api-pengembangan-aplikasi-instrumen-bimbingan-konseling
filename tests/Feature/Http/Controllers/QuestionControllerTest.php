<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Instrument;
use App\Models\Question;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\QuestionController
 */
final class QuestionControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $questions = Question::factory()->count(3)->create();

        $response = $this->get(route('question.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\QuestionController::class,
            'store',
            \App\Http\Requests\QuestionControllerStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $instrument = Instrument::factory()->create();
        $text = $this->faker->text();
        $favorable = $this->faker->boolean();

        $response = $this->post(route('question.store'), [
            'instrument_id' => $instrument->id,
            'text' => $text,
            'favorable' => $favorable,
        ]);

        $questions = Question::query()
            ->where('instrument_id', $instrument->id)
            ->where('text', $text)
            ->where('favorable', $favorable)
            ->get();
        $this->assertCount(1, $questions);
        $question = $questions->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $question = Question::factory()->create();

        $response = $this->get(route('question.show', $question));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\QuestionController::class,
            'update',
            \App\Http\Requests\QuestionControllerUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $question = Question::factory()->create();
        $instrument = Instrument::factory()->create();
        $text = $this->faker->text();
        $favorable = $this->faker->boolean();

        $response = $this->put(route('question.update', $question), [
            'instrument_id' => $instrument->id,
            'text' => $text,
            'favorable' => $favorable,
        ]);

        $question->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($instrument->id, $question->instrument_id);
        $this->assertEquals($text, $question->text);
        $this->assertEquals($favorable, $question->favorable);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $question = Question::factory()->create();

        $response = $this->delete(route('question.destroy', $question));

        $response->assertNoContent();

        $this->assertModelMissing($question);
    }
}
