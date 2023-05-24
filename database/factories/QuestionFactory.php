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
            'default_title' => 'How do you rate your experience?',
            'title_langs' => [
                'pt-br' => 'Como voc\u00ea avalia sua experi\u00eancia?',
            ],
            // 'limit_to_1_answer' => true,
            'questions' =>  [
                // ...\json_decode(
                //     '[
                //         {
                //             "name": "rating",
                //             "type": "select_list",
                //             "options": [
                //                 {
                //                     "label": {
                //                         "default": "0"
                //                     },
                //                     "value": 0
                //                 },
                //                 {
                //                     "label": {
                //                         "default": "1"
                //                     },
                //                     "value": 1
                //                 },
                //                 {
                //                     "label": {
                //                         "default": "2"
                //                     },
                //                     "value": 2
                //                 },
                //                 {
                //                     "label": {
                //                         "default": "3"
                //                     },
                //                     "value": 3
                //                 },
                //                 {
                //                     "label": {
                //                         "default": "4"
                //                     },
                //                     "value": 4
                //                 },
                //                 {
                //                     "label": {
                //                         "default": "5"
                //                     },
                //                     "value": 5
                //                 },
                //                 {
                //                     "label": {
                //                         "default": "6"
                //                     },
                //                     "value": 6
                //                 },
                //                 {
                //                     "label": {
                //                         "default": "7"
                //                     },
                //                     "value": 7
                //                 },
                //                 {
                //                     "label": {
                //                         "default": "8"
                //                     },
                //                     "value": 8
                //                 },
                //                 {
                //                     "label": {
                //                         "default": "9"
                //                     },
                //                     "value": 9
                //                 },
                //                 {
                //                     "label": {
                //                         "default": "10"
                //                     },
                //                     "value": 10
                //                 }
                //             ],
                //             "question": {
                //                 "pt-br": "Em uma escala de 0 a 10, qual a probabilidade de voc\u00ea recomendar nossa empresa a um amigo ou colega?",
                //                 "default": "On a scale of 0 to 10, how likely are you to recommend our business to a friend or colleague?"
                //             },
                //             "required": true,
                //             "validation": [
                //                 "required",
                //                 "integer",
                //                 "in:0,1,2,3,4,5,6,7,8,9,10"
                //             ],
                //             "help_message": {
                //                 "pt-br": "...",
                //                 "default": "..."
                //             },
                //             "multi_select": false,
                //             "key_for_reports": true
                //         },
                //         {
                //             "max": 1000,
                //             "min": 5,
                //             "name": "message",
                //             "type": "multi_line_text",
                //             "question": {
                //                 "pt-br": "Gostaria de adicionar uma mensagem \u00e0 sua resposta?",
                //                 "default": "Would you like to add a message to your reply?"
                //             },
                //             "required": false,
                //             "validation": [
                //                 "nullable",
                //                 "string",
                //                 "min:5",
                //                 "max:1000"
                //             ],
                //             "placeholder": {
                //                 "pt-br": "Sua mensagem aqui...",
                //                 "default": "Your message here..."
                //             },
                //             "help_message": {
                //                 "pt-br": "Sua mensagem nos ajuda a melhorar nossos servi\u00e7os.",
                //                 "default": "Your message helps us to improve our services."
                //             }
                //         }
                //     ]',
                //     \true
                // ),
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

    /**
     * Without organization
     */
    public function withoutOrganization(): static
    {
        return $this->state(fn (array $attributes) => [
            'organization_id' => null,
        ]);
    }
}
