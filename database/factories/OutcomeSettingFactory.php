<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\OutcomeSetting;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @template TModel of \App\Models\OutcomeSetting
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<TModel>
 */
final class OutcomeSettingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<TModel>
     */
    protected $model = OutcomeSetting::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => $this->faker->unique()->word(),
            'color' => $this->faker->hexColor(),
            'icon' => 'heroicon-o-check-circle',
            'description' => $this->faker->sentence(),
            'is_active' => $this->faker->boolean(80),
        ];
    }
}
