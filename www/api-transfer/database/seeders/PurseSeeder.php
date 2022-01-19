<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Services\Interfaces\PurseServiceInterface;
use Faker\Factory;
use Illuminate\Support\Str;

class PurseSeeder extends Seeder
{
    private PurseServiceInterface $purseServiceInterface;

    public function __construct(
        PurseServiceInterface $purseServiceInterface)
    {
        $this->purseServiceInterface = $purseServiceInterface;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create('pt_BR');

        for ($i = 1; $i < 6; $i++) {
            $this->purseServiceInterface->create([
                'balance' =>$faker->numberBetween(1500, 10000),
                'user_id' => User::has('purse', '<', 1)->first()->id,
            ]);
        }
    }
}
