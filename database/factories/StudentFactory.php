<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Student::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName ,
            'last_name' => $this->faker->lastName,
            'identification_no' => $this->faker->unique()->randomDigit(),
            'country' => $this->faker->country,
            'date_of_birth' => $this->faker->dateTime()->format('d-m-Y H:i:s'),
            'registered_on' => $this->faker->dateTime()->format('d-m-Y H:i:s'),
        ];
    }
}