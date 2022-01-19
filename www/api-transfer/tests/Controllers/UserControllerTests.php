<?php

namespace Tests\Controllers;

use App\Models\Purse;
use App\Models\User;
use Faker\Factory;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Tests\TestCase;

class UserControllerTests extends TestCase
{

    public function testIndexReturnsDataInValidFormat()
    {

        $this->getJson('api/v1/users')
            ->assertStatus(Response::HTTP_OK);

    }

    public function testPurseByUserIsShowCorrectly()
    {
        $faker = Factory::create('pt_BR');

        $user = User::create(
            [
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'document' => $faker->unique()->cpf(false),
                'profile' => 'common',
            ]
        );
        Purse::create(
            [
                'balance' => strval(1000),
                'user_id' => $user->id,
                'status' => "active"
            ]
        );
        $this->getJson('api/v1/users/'.$user->id.'/purse')
            ->assertStatus(Response::HTTP_OK);
    }

    public function testUserIsCreatedSuccessfully()
    {
        $faker = Factory::create('pt_BR');

        $user = [
            'name' => $faker->name,
            'email' => $faker->unique()->safeEmail(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'document' => $faker->cpf(false),
            'profile' => 'common',
        ];

        $this->postJson('api/v1/users', $user)
            ->assertStatus(Response::HTTP_CREATED);

        $this->assertDatabaseHas('users', $user);
    }
}
