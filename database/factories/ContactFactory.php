<?php

namespace Database\Factories;


use App\Models\ContactGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'firstName' => fake()->firstName(),
            'lastName' => fake()->lastName(),
            'phone' => fake()->phoneNumber(),
            'email' => fake()->email,
            'photo' => 'Images/'.$this->faker->image(storage_path('app/Images'), 400, 300, null, false),
            'address' => fake()->address,
            'contact_group_id' => ContactGroup::factory()->create()->id
        ];
    }
}
