<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Document>
 */
class DocumentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $createdAndUpdatedAt = fake()->dateTime();

        return [
            'name' => fake()->sentence(2),
            'user_id' => User::all()->random()->id,
            'file_name' => fake()->sentence(1).'docx',
            'file_path' => '123/'.fake()->sentence(1),
            'created_at' => $createdAndUpdatedAt,
            'updated_at' => $createdAndUpdatedAt,
        ];
    }
}
