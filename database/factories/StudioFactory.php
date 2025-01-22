<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Studio>
 */
class StudioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => $this->faker->jobTitle(),
            'preview_text' => $this->faker->paragraphs(2, true),
            'detail_text' => $this->faker->paragraphs(5, true),
            'cost_training' => $this->faker->numberBetween(40000, 120000),
            'tags' => implode(', ', $this->faker->words(3)),
            'address' => $this->faker->streetAddress(),
            'coordinates' => '52.721295,41.452750',
            'city' => $this->faker->city(),
            'contact_email' => $this->faker->safeEmail(),
            'contact_phone' => $this->faker->phoneNumber(),
            'website_link' => $this->faker->url(),
            'vk_link' => $this->faker->url(),
            'sort' => $this->faker->numberBetween(1, 100),
        ];
    }
}
