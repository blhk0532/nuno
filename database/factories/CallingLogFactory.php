<?php

namespace Database\Factories;

use App\Models\CallingLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends \Illuminate\Database\Eloquent\Factories\Factory<CallingLog> */
class CallingLogFactory extends Factory
{
    protected $model = CallingLog::class;

    public function definition(): array
    {
        $started = $this->faker->dateTimeBetween('-30 days', 'now');
        $duration = $this->faker->numberBetween(10, 3600);

        return [
            'user_id' => User::inRandomOrder()->first()?->id ?? null,
            'call_sid' => 'CS'.$this->faker->regexify('[A-Z0-9]{16}'),
            'target_number' => $this->faker->e164PhoneNumber(),
            'target_name' => $this->faker->name(),
            'duration_seconds' => $duration,
            'started_at' => $started,
            'ended_at' => (clone $started)->modify("+{$duration} seconds"),
            'status' => $this->faker->randomElement(['initiated', 'in_progress', 'completed', 'no_answer', 'failed']),
            'recording_url' => null,
            'notes' => $this->faker->optional()->sentence(),
        ];
    }
}
