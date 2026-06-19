<?php

namespace Database\Seeders;

use App\Models\Locacao;
use App\Models\User;
use App\Models\Veiculo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'marcelsecco1@gmail.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('marcelsecco1@gmail.com'),
            ],
        );

        User::query()->updateOrCreate(
            ['email' => 'gerente@locadora.test'],
            [
                'name' => 'Gerente de Frota',
                'password' => Hash::make('password'),
            ],
        );

        User::query()->updateOrCreate(
            ['email' => 'atendente@locadora.test'],
            [
                'name' => 'Atendente',
                'password' => Hash::make('password'),
            ],
        );

        User::query()->updateOrCreate(
            ['email' => 'cliente@locadora.test'],
            [
                'name' => 'Cliente Demo',
                'password' => Hash::make('password'),
            ],
        );

        User::query()->where('email', 'admin@locadora.test')->delete();

        $veiculos = collect([
            [
                'modelo' => 'Corolla Altis',
                'marca' => 'Toyota',
                'ano' => 2023,
                'placa' => 'BRA-2E19',
                'status' => 'alugado',
            ],
            [
                'modelo' => 'Onix Premier',
                'marca' => 'Chevrolet',
                'ano' => 2022,
                'placa' => 'LOC-7H22',
                'status' => 'disponivel',
            ],
            [
                'modelo' => 'Compass Longitude',
                'marca' => 'Jeep',
                'ano' => 2024,
                'placa' => 'SUV-9J81',
                'status' => 'manutencao',
            ],
            [
                'modelo' => 'HB20 Comfort',
                'marca' => 'Hyundai',
                'ano' => 2021,
                'placa' => 'CITY-4K50',
                'status' => 'disponivel',
            ],
        ])->map(function (array $attributes) {
            return Veiculo::query()->updateOrCreate(
                ['placa' => $attributes['placa']],
                $attributes + ['imagem' => null],
            );
        });

        $veiculoAlugado = $veiculos->firstWhere('placa', 'BRA-2E19');

        if ($veiculoAlugado) {
            Locacao::query()->updateOrCreate(
                [
                    'veiculo_id' => $veiculoAlugado->id,
                    'cliente' => 'Mariana Santos',
                    'data_retirada' => '2026-06-10',
                ],
                [
                    'data_devolucao' => '2026-06-20',
                ],
            );
        }

        $this->call(RolePermissionSeeder::class);
    }
}
