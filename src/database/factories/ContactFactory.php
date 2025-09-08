<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    public function definition(): array
    {
        // Laravel 8 などでは $this->faker を使う
        $f = $this->faker;

        return [
            'last_name'   => $f->lastName(),
            'first_name'  => $f->firstName(),
            'gender'      => $f->randomElement([1, 2, 3]),
            'email'       => $f->unique()->safeEmail(),
            'tel'         => '0' . $f->numerify('#########'),
            'address'     => $f->prefecture().' '.$f->city().' '.$f->streetAddress(),
            'building'    => $f->optional(0.5)->secondaryAddress(),
            'category_id' => $f->numberBetween(1, 5),
            'detail'      => $f->realText(100),
            'created_at'  => $f->dateTimeBetween('-60 days', 'now'),
            'updated_at'  => now(),
        ];
    }
}
