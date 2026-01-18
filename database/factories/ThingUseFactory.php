<?php

namespace Database\Factories;

use App\Models\Place;
use App\Models\Thing;
use App\Models\ThingUse;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ThingUse>
 */
class ThingUseFactory extends Factory
{
    protected $model = ThingUse::class;

    public function definition(): array
    {
        return [
            'thing_id' => Thing::factory(),
            'place_id' => Place::factory(),
            'user_id' => User::factory(),
            'amount' => fake()->numberBetween(1, 20),
            'unit_id' => Unit::factory(),
        ];
    }
}
