<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Criteria;
use App\Models\Instrument;

class CriteriaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Criteria::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'instrument_id' => Instrument::factory(),
            'text' => $this->faker->word(),
            'minimum' => $this->faker->randomFloat(0, 0, 9999999999.),
            'maximum' => $this->faker->randomFloat(0, 0, 9999999999.),
        ];
    }
}
