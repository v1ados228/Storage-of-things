<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Place;
use App\Models\Role;
use App\Models\Thing;
use App\Models\ThingDescription;
use App\Models\ThingUse;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $faker = fake('ru_RU');

        $adminRole = Role::firstOrCreate(
            ['slug' => 'admin'],
            ['name' => 'Администратор']
        );
        $userRole = Role::firstOrCreate(
            ['slug' => 'user'],
            ['name' => 'Пользователь']
        );

        $admin = User::updateOrCreate(
            ['email' => 'maryon096@mail.ru'],
            [
                'name' => 'Администратор',
                'password' => Hash::make('password'),
                'role_id' => $adminRole->id,
            ]
        );

        $usersData = [
            ['name' => 'Иван Петров', 'email' => 'ivan.petrov@example.com'],
            ['name' => 'Мария Соколова', 'email' => 'maria.sokolova@example.com'],
            ['name' => 'Алексей Иванов', 'email' => 'alexey.ivanov@example.com'],
            ['name' => 'Екатерина Смирнова', 'email' => 'ekaterina.smirnova@example.com'],
            ['name' => 'Дмитрий Орлов', 'email' => 'dmitriy.orlov@example.com'],
            ['name' => 'Ольга Николаева', 'email' => 'olga.nikolaeva@example.com'],
            ['name' => 'Сергей Кузнецов', 'email' => 'sergey.kuznetsov@example.com'],
            ['name' => 'Анна Морозова', 'email' => 'anna.morozova@example.com'],
        ];

        $users = collect();
        foreach ($usersData as $userData) {
            $users->push(User::updateOrCreate(
                ['email' => $userData['email']],
                [
                    'name' => $userData['name'],
                    'password' => Hash::make('password'),
                    'role_id' => $userRole->id,
                ]
            ));
        }

        while ($users->count() < 10) {
            $users->push(User::create([
                'name' => $faker->name(),
                'email' => $faker->unique()->safeEmail(),
                'password' => Hash::make('password'),
                'role_id' => $userRole->id,
            ]));
        }

        User::where('id', '!=', $admin->id)->update([
            'role_id' => $userRole->id,
        ]);

        $unitsData = [
            ['name' => 'штука', 'abbreviation' => 'шт.'],
            ['name' => 'упаковка', 'abbreviation' => 'уп.'],
            ['name' => 'килограмм', 'abbreviation' => 'кг'],
            ['name' => 'литр', 'abbreviation' => 'л'],
            ['name' => 'комплект', 'abbreviation' => 'к-т'],
        ];
        $units = collect();
        foreach ($unitsData as $unitData) {
            $units->push(Unit::updateOrCreate(
                ['name' => $unitData['name']],
                $unitData
            ));
        }

        $placesData = [
            ['name' => 'Склад А', 'description' => 'Основной склад, стеллажи 1–5', 'repair' => false, 'work' => false],
            ['name' => 'Кладовая', 'description' => 'Подсобное помещение рядом с офисом', 'repair' => false, 'work' => false],
            ['name' => 'Гараж', 'description' => 'Гаражный бокс №12', 'repair' => false, 'work' => false],
            ['name' => 'Мастерская', 'description' => 'Зона текущих работ', 'repair' => false, 'work' => true],
            ['name' => 'Сервисный центр', 'description' => 'Ремонт и диагностика', 'repair' => true, 'work' => false],
            ['name' => 'Мойка', 'description' => 'Пост мойки оборудования', 'repair' => true, 'work' => false],
        ];
        $places = collect();
        foreach ($placesData as $placeData) {
            $places->push(Place::updateOrCreate(
                ['name' => $placeData['name']],
                $placeData
            ));
        }

        $thingsData = [
            ['name' => 'Дрель Bosch', 'wrnt' => '2027-01-01', 'description' => 'Работает штатно, комплект полный.'],
            ['name' => 'Набор отверток', 'wrnt' => null, 'description' => 'В кейсе, 24 предмета.'],
            ['name' => 'Пылесос для мастерской', 'wrnt' => '2026-12-31', 'description' => 'Фильтры заменены месяц назад.'],
            ['name' => 'Фотоаппарат Canon', 'wrnt' => '2028-03-10', 'description' => 'Используется редко, хранится в чехле.'],
            ['name' => 'Лыжи беговые', 'wrnt' => null, 'description' => 'Есть мелкие царапины, на ход не влияет.'],
            ['name' => 'Шуруповерт Makita', 'wrnt' => '2027-05-20', 'description' => 'Две батареи, зарядка в комплекте.'],
            ['name' => 'Удлинитель 10 м', 'wrnt' => null, 'description' => 'Кабель без повреждений.'],
            ['name' => 'Компрессор', 'wrnt' => '2027-11-15', 'description' => 'Требуется проверка перед использованием.'],
            ['name' => 'Проектор Epson', 'wrnt' => '2026-08-01', 'description' => 'Лампа менялась в прошлом году.'],
            ['name' => 'Лестница складная', 'wrnt' => null, 'description' => 'Лёгкая, алюминиевая.'],
            ['name' => 'Сварочный аппарат', 'wrnt' => '2028-02-18', 'description' => 'Работает штатно, износ минимальный.'],
            ['name' => 'Ноутбук Dell', 'wrnt' => '2026-09-09', 'description' => 'Установлен офисный софт, батарея держит 3–4 часа.'],
        ];

        $things = collect();
        foreach ($thingsData as $thingData) {
            $owner = $users->random();
            $thing = Thing::create([
                'name' => $thingData['name'],
                'wrnt' => $thingData['wrnt'],
                'master_id' => $owner->id,
                'total_amount' => $faker->numberBetween(2, 10),
                'unit_id' => $units->random()->id,
            ]);

            $description = ThingDescription::create([
                'thing_id' => $thing->id,
                'description' => $thingData['description'],
                'created_by' => $owner->id,
            ]);

            $thing->current_description_id = $description->id;
            $thing->save();

            $things->push($thing);
        }

        $allUsers = $users->push($admin);
        foreach ($things as $thing) {
            $assignees = $allUsers->where('id', '!=', $thing->master_id);
            $useUser = $assignees->isEmpty() ? $allUsers->random() : $assignees->random();
            ThingUse::create([
                'thing_id' => $thing->id,
                'place_id' => $places->random()->id,
                'user_id' => $useUser->id,
                'amount' => min($faker->numberBetween(1, 5), $thing->total_amount),
                'unit_id' => $thing->unit_id,
            ]);
        }
    }
}
