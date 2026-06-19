<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $permissions = [
            'acessar dashboard',
            'gerenciar usuarios',
            'gerenciar veiculos',
            'gerenciar locacoes',
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission);
        }

        $administrador = Role::findOrCreate('administrador');
        $gerente = Role::findOrCreate('gerente');
        $atendente = Role::findOrCreate('atendente');
        $cliente = Role::findOrCreate('cliente');

        $administrador->givePermissionTo(Permission::all());
        $gerente->givePermissionTo([
            'acessar dashboard',
            'gerenciar veiculos',
            'gerenciar locacoes',
        ]);
        $atendente->givePermissionTo([
            'acessar dashboard',
            'gerenciar locacoes',
        ]);

        User::query()
            ->where('email', 'marcelsecco1@gmail.com')
            ->first()?->syncRoles(['administrador']);

        User::query()
            ->where('email', 'gerente@locadora.test')
            ->first()?->syncRoles(['gerente']);

        User::query()
            ->where('email', 'atendente@locadora.test')
            ->first()?->syncRoles(['atendente']);

        User::query()
            ->where('email', 'cliente@locadora.test')
            ->first()?->syncRoles(['cliente']);
    }
}
