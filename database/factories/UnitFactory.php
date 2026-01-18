<?php

namespace Database\Factories;

use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Unit>
 */
class UnitFactory extends Factory
{
    protected $model = Unit::class;

    public function definition(): array
    {
        $unit = fake()->randomElement([
            ['name' => 'штука', 'abbreviation' => 'шт.'],
            ['name' => 'упаковка', 'abbreviation' => 'уп.'],
            ['name' => 'килограмм', 'abbreviation' => 'кг'],
            ['name' => 'литр', 'abbreviation' => 'л'],
            ['name' => 'комплект', 'abbreviation' => 'к-т'],
        ]);

        return [
            'name' => $unit['name'],
            'abbreviation' => $unit['abbreviation'],
        ];
    }
}
