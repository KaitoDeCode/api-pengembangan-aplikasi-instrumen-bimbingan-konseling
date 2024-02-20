<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Criterion;
use App\Models\Group;
use App\Models\Instrument;
use App\Models\Participation;
use App\Models\User;

class ParticipationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Participation::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'instrument_id' => Instrument::factory(),
            'group_id' => Group::factory(),
            'user_id' => User::factory(),
            'criteria_id' => Criterion::factory(),
            'point' => $this->faker->randomFloat(0, 0, 9999999999.),
        ];
    }
}
