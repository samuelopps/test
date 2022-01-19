<?php

namespace Tests\Controllers;

use App\Models\Purse;
use App\Models\User;
use Faker\Factory;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Tests\TestCase;

class PurseControllerTests extends TestCase
{

    public function testPurseIsCreatedSuccessfully()
    {
        $faker = Factory::create('pt_BR');

        $user = User::create(
            [
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'document' => $faker->cpf(false),
                'profile' => 'common',
            ]
        );

        $purse = [
            'balance' => 100,
            'user_id' => $user->id,
            'status' => 'active',
        ];

        $this->postJson("api/v1/purses", $purse)
            ->assertStatus(Response::HTTP_CREATED);

        $this->assertDatabaseHas('purses', $purse);
    }

    public function testUpdateBalanceFromPurseReturnsCorrectData()
    {
        $faker = Factory::create('pt_BR');

        $user = User::create(
            [
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'document' => $faker->cpf(false),
                'profile' => 'common',
            ]
        );

        $purse = Purse::create($purse = [
            'balance' => 100,
            'user_id' => $user->id,
            'status' => 'active',
        ]);

        $update = [
            'balance' => strval(1500),
        ];

        $this->patchJson("api/v1/purses/$purse->id/balance", $update)
            ->assertStatus(Response::HTTP_OK);

        $this->assertDatabaseHas('purses', array_merge($update, [
            'id' => $purse->id
        ]));
    }
}
