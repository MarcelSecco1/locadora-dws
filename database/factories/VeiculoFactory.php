<?php

namespace Database\Factories;

use App\Models\Veiculo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Veiculo>
 */
class VeiculoFactory extends Factory
{
    protected $model = Veiculo::class;

    public function definition(): array
    {
        return [
            'modelo' => fake()->randomElement(['Onix', 'Corolla', 'Compass', 'Creta', 'Ka', 'HB20']),
            'marca' => fake()->randomElement(['Chevrolet', 'Toyota', 'Jeep', 'Hyundai', 'Ford']),
            'ano' => fake()->numberBetween(2018, (int) date('Y')),
            'placa' => strtoupper(fake()->unique()->bothify('???-#?#')),
            'status' => fake()->randomElement(['disponivel', 'alugado', 'manutencao']),
            'imagem' => null,
        ];
    }
}
