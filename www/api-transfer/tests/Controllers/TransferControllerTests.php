<?php

namespace Tests\Controllers;

use App\Models\Purse;
use App\Models\User;
use Faker\Factory;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Tests\TestCase;

class TransferControllerTests extends TestCase
{

    public function testIndexReturnsDataInValidFormat()
    {
        $this->getJson('api/v1/transfers')
            ->assertStatus(Response::HTTP_OK);
    }

    public function testTransferIsCreatedSuccessfully()
    {
        $faker = Factory::create('pt_BR');

        for ($i = 0; $i < 2; $i++) {
            $par = ($i % 2) == 0 ? true : false;

            $users[$i] = User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail(),
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
                'document' => $par ? $faker->cpf(false) : $faker->cnpj(false),
                'profile' => $par ? 'common' : 'storekeeper',
            ])->id;

            Purse::create([
                'balance' =>$faker->numberBetween(1500, 10000),
                'user_id' => $users[$i],
            ]);
        }

        $transfer = [
            'amount' => 100,
            'paying_purse_id' => $users[0],
            'receiver_purse_id' => $users[1],
        ];

        $this->postJson("api/v1/transfers", $transfer)
            ->assertStatus(Response::HTTP_CREATED);

        $this->assertDatabaseHas('transfers', $transfer);
    }
}
