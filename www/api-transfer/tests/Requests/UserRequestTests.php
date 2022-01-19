<?php

namespace Tests\Feature;

use App\Models\Purse;
use App\Models\User;
use Faker\Factory;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Tests\TestCase;

class UserRequestTests extends TestCase
{

    public function testUserNameValidationSuccessfully()
    {
        $faker = Factory::create('pt_BR');

        $user = [
            'name' => '',
            'email' => $faker->unique()->safeEmail(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'document' => $faker->cpf(false),
            'profile' => 'common',
        ];

        $response =  $this->postJson('api/v1/users', $user);

        $response->assertStatus(
            Response::HTTP_UNPROCESSABLE_ENTITY
        );

        $response->assertJsonValidationErrors('name');
    }

    public function testEmailValidationSuccessfully()
    {
        $faker = Factory::create('pt_BR');

        $user = [
            'name' => $faker->name,
            'email' => 'emailinvalido',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'document' => $faker->cpf(false),
            'profile' => 'common',
        ];

        $response =  $this->postJson('api/v1/users', $user);

        $response->assertStatus(
            Response::HTTP_UNPROCESSABLE_ENTITY
        );

        $response->assertJsonValidationErrors('email');
    }

    public function testPassValidationSuccessfully()
    {
        $faker = Factory::create('pt_BR');

        $user = [
            'name' => $faker->name,
            'email' => $faker->unique()->safeEmail(),
            'password' => '',
            'document' => $faker->cpf(false),
            'profile' => 'common',
        ];

        $response =  $this->postJson('api/v1/users', $user);

        $response->assertStatus(
            Response::HTTP_UNPROCESSABLE_ENTITY
        );

        $response->assertJsonValidationErrors('password');
    }

    public function testDocumentValidationSuccessfully()
    {
        $faker = Factory::create('pt_BR');

        $user = [
            'name' => $faker->name,
            'email' => $faker->unique()->safeEmail(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'document' => '',
            'profile' => 'common',
        ];

        $response =  $this->postJson('api/v1/users', $user);

        $response->assertStatus(
            Response::HTTP_UNPROCESSABLE_ENTITY
        );

        $response->assertJsonValidationErrors('document');
    }

    public function testProfileValidationSuccessfully()
    {
        $faker = Factory::create('pt_BR');

        $user = [
            'name' => $faker->name,
            'email' => $faker->unique()->safeEmail(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'document' => $faker->cpf(false),
            'profile' => 'nao-tem',
        ];

        $response =  $this->postJson('api/v1/users', $user);

        $response->assertStatus(
            Response::HTTP_UNPROCESSABLE_ENTITY
        );

        $response->assertJsonValidationErrors('profile');
    }
}
