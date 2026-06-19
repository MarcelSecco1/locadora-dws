<?php

namespace Database\Factories;

use App\Models\Locacao;
use App\Models\Veiculo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Locacao>
 */
class LocacaoFactory extends Factory
{
    protected $model = Locacao::class;

    public function definition(): array
    {
        $retirada = fake()->dateTimeBetween('-3 months', '+1 month');
        $devolucao = (clone $retirada)->modify('+'.fake()->numberBetween(3, 15).' days');

        return [
            'veiculo_id' => Veiculo::factory(),
            'cliente' => fake()->name(),
            'data_retirada' => $retirada,
            'data_devolucao' => $devolucao,
        ];
    }
}
