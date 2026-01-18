<?php

namespace Database\Factories;

use App\Models\Thing;
use App\Models\ThingDescription;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ThingDescription>
 */
class ThingDescriptionFactory extends Factory
{
    protected $model = ThingDescription::class;

    public function definition(): array
    {
        $descriptions = [
            'В хорошем состоянии, комплект полный.',
            'Используется редко, хранится в чехле.',
            'Требуется проверка перед использованием.',
            'Последнее обслуживание — в прошлом месяце.',
            'Работает штатно, износ минимальный.',
            'Есть мелкие царапины, на работу не влияет.',
        ];

        return [
            'thing_id' => Thing::factory(),
            'description' => fake()->randomElement($descriptions),
            'created_by' => User::factory(),
        ];
    }
}
