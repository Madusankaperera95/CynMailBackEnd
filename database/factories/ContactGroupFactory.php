<?php

namespace Database\Factories;

use App\Models\ContactGroup;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ContactGroup>
 */
class ContactGroupFactory extends Factory
{


    public function definition(): array
    {
        return [
            'groupName' => fake()->company,
            'user_id' =>  function () {
                // Assuming you have a User model, this will create a foreign key to a user
                return User::factory()->create()->id;
            },
        ];
    }
}
