<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{

    private $nationalIds = [
        '40202091600452',
        '52502093262442',
        '37202091610452',
        '25602041500432',
        '30202081600462',
        '20302091698472',
        '33102091600482'
    ];

    private $phoneNumbers = [
        '01556130630',
        '01267220631',
        '01062131516',
        '01101516590',
        '01280312510',
        '01109922510'
    ];

    private $passwords = [
        'password',
        'security',
        '12345678',
        'adminadmin',
        'rootroot',
        '87654321',
        'abcdefg'
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $email = fake()->unique()->safeEmail();

        $isMale = fake()->boolean();
        $gender = $isMale ? 'male' : 'female';
        $name = $isMale ? fake()->firstNameMale() : fake()->firstNameFemale();

        $password = $this->passwords[User::count() % count($this->passwords)];

        return [
            'email' => $email,
            'email_verified_at' => now(),
            'password' => Hash::make($password),
            'remember_token' => Str::random(10),

            'name' => $name,
            'national_number' => $this->nationalIds[fake()->numberBetween(0, count($this->nationalIds)-1)],
            'phone' => $this->phoneNumbers[fake()->numberBetween(0, count($this->phoneNumbers)-1)],
            'age' => fake()->numberBetween(25, 45),
            'gender' => $gender
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
