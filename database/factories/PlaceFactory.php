<?php

namespace Database\Factories;

use App\Models\Place;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Place>
 */
class PlaceFactory extends Factory
{
    protected $model = Place::class;

    public function definition(): array
    {
        $places = [
            ['name' => 'Склад А', 'description' => 'Основной склад, стеллажи 1–5'],
            ['name' => 'Кладовая', 'description' => 'Подсобное помещение рядом с офисом'],
            ['name' => 'Гараж', 'description' => 'Гаражный бокс №12'],
            ['name' => 'Мастерская', 'description' => 'Зона текущих работ'],
            ['name' => 'Сервисный центр', 'description' => 'Ремонт и диагностика'],
            ['name' => 'Мойка', 'description' => 'Пост мойки оборудования'],
        ];
        $place = fake()->randomElement($places);

        return [
            'name' => $place['name'],
            'description' => $place['description'],
            'repair' => in_array($place['name'], ['Сервисный центр', 'Мойка'], true),
            'work' => in_array($place['name'], ['Мастерская'], true),
        ];
    }
}
