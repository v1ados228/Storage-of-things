<?php

namespace Database\Factories;

use App\Models\Thing;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Thing>
 */
class ThingFactory extends Factory
{
    protected $model = Thing::class;

    public function definition(): array
    {
        $things = [
            'Дрель Bosch',
            'Набор отверток',
            'Пылесос для мастерской',
            'Фотоаппарат Canon',
            'Лыжи беговые',
            'Шуруповерт Makita',
            'Удлинитель 10 м',
            'Компрессор',
            'Проектор Epson',
            'Лестница складная',
            'Сварочный аппарат',
            'Ноутбук Dell',
        ];

        return [
            'name' => fake()->randomElement($things),
            'wrnt' => fake()->randomElement(['2026-12-31', '2027-01-01', '2028-03-10', null]),
            'master_id' => User::factory(),
            'current_description_id' => null,
            'total_amount' => fake()->numberBetween(2, 10),
            'unit_id' => \App\Models\Unit::factory(),
        ];
    }
}
