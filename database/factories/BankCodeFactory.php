<?php

namespace GloCurrency\PolarisBank\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use GloCurrency\PolarisBank\Models\BankCode;
use GloCurrency\PolarisBank\PolarisBank;

class BankCodeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BankCode::class;

    /**
     * Define the model's default state.
     *
     * @return array<string,mixed>
     */
    public function definition()
    {
        return [
            'id' => $this->faker->uuid(),
            'bank_id' => (PolarisBank::$bankModel)::factory(),
            'code' => $this->faker->unique()->word(),
        ];
    }
}