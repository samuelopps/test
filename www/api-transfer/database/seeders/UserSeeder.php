<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Services\Interfaces\UserServiceInterface;
use Faker\Factory;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    private UserServiceInterface $userServiceInterface;

    public function __construct(UserServiceInterface $userServiceInterface)
    {
        $this->userServiceInterface = $userServiceInterface;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create('pt_BR');

        for ($i = 0; $i < 5; $i++) {
            $par = ($i % 2) == 0 ? true : false;

            $this->userServiceInterface->create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail(),
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
                'document' => $par ? $faker->cpf(false) : $faker->cnpj(false),
                'profile' => $par ? 'common' : 'storekeeper',
            ]);
        }
    }
}
