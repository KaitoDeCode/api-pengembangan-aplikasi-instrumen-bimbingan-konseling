<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Answer;
use App\Models\Survey;

class AnswerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Answer::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'survey_id' => Survey::factory(),
            'text' => $this->faker->text(),
            'pointFav' => $this->faker->randomFloat(0, 0, 9999999999.),
            'pointUnFav' => $this->faker->randomFloat(0, 0, 9999999999.),
        ];
    }
}
