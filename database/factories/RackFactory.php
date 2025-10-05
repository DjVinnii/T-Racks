<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Rack;

class RackFactory extends Factory
{
    protected $model = Rack::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->bothify('Rack-##??'),
            'notes' => $this->faker->optional()->sentence(),
        ];
    }
}
