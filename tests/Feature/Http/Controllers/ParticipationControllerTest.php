<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Criteria;
use App\Models\Group;
use App\Models\Instrument;
use App\Models\Participation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ParticipationController
 */
final class ParticipationControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $participations = Participation::factory()->count(3)->create();

        $response = $this->get(route('participation.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ParticipationController::class,
            'store',
            \App\Http\Requests\ParticipationStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $instrument = Instrument::factory()->create();
        $group = Group::factory()->create();
        $user = User::factory()->create();
        $criteria = Criteria::factory()->create();
        $point = $this->faker->randomFloat(/** decimal_attributes **/);

        $response = $this->post(route('participation.store'), [
            'instrument_id' => $instrument->id,
            'group_id' => $group->id,
            'user_id' => $user->id,
            'criteria_id' => $criteria->id,
            'point' => $point,
        ]);

        $participations = Participation::query()
            ->where('instrument_id', $instrument->id)
            ->where('group_id', $group->id)
            ->where('user_id', $user->id)
            ->where('criteria_id', $criteria->id)
            ->where('point', $point)
            ->get();
        $this->assertCount(1, $participations);
        $participation = $participations->first();

        $response->assertCreated();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $participation = Participation::factory()->create();

        $response = $this->get(route('participation.show', $participation));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ParticipationController::class,
            'update',
            \App\Http\Requests\ParticipationUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $participation = Participation::factory()->create();
        $instrument = Instrument::factory()->create();
        $group = Group::factory()->create();
        $user = User::factory()->create();
        $criteria = Criteria::factory()->create();
        $point = $this->faker->randomFloat(/** decimal_attributes **/);

        $response = $this->put(route('participation.update', $participation), [
            'instrument_id' => $instrument->id,
            'group_id' => $group->id,
            'user_id' => $user->id,
            'criteria_id' => $criteria->id,
            'point' => $point,
        ]);

        $participation->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($instrument->id, $participation->instrument_id);
        $this->assertEquals($group->id, $participation->group_id);
        $this->assertEquals($user->id, $participation->user_id);
        $this->assertEquals($criteria->id, $participation->criteria_id);
        $this->assertEquals($point, $participation->point);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $participation = Participation::factory()->create();

        $response = $this->delete(route('participation.destroy', $participation));

        $response->assertNoContent();

        $this->assertModelMissing($participation);
    }
}
