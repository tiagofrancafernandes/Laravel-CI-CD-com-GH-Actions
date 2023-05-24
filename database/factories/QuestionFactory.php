<?php

namespace Database\Factories;

use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Question>
 */
class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'default_title' => 'Question ' . \fake()->words(3, true),
            'title_langs' => [
                'pt-br' => 'Questão ' . \fake()->words(3, true)
            ],
            'questions' => [
                [
                    'label' => [
                        'default' => 'Some question #1',
                        'pt-br' => 'Alguma pergunta #1',
                    ],
                    'type' => 'single_line_text',
                    'input_variant' => 'email',
                    'required' => false,
                    'name' => 'question_one',
                ],
                [
                    'label' => [
                        'default' => 'Some question #2',
                        'pt-br' => 'Alguma pergunta #2',
                    ],
                    'type' => 'single_line_text',
                    'input_variant' => 'email',
                    'required' => false,
                    'name' => 'question_two',
                ],
            ],
            'organization_id' => Organization::factory(),
        ];
    }
}
