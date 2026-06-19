<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(): View
    {
        return view('usuarios.index', [
            'users' => User::query()
                ->with(['roles', 'permissions'])
                ->orderBy('name')
                ->paginate(10),
        ]);
    }

    public function create(): View
    {
        return view('usuarios.create', $this->formData(new User()));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateRequest($request);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
        ]);

        $this->syncAuthorization($user, $data);

        return redirect()
            ->route('usuarios.index')
            ->with('success', 'Usuário cadastrado com sucesso.');
    }

    public function edit(User $user): View
    {
        $user->load(['roles', 'permissions']);

        return view('usuarios.edit', $this->formData($user));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $data = $this->validateRequest($request, $user);

        $payload = [
            'name' => $data['name'],
            'email' => $data['email'],
        ];

        if (! empty($data['password'])) {
            $payload['password'] = $data['password'];
        }

        $user->update($payload);

        $this->syncAuthorization($user, $data);

        return redirect()
            ->route('usuarios.index')
            ->with('success', 'Usuário atualizado com sucesso.');
    }

    private function validateRequest(Request $request, ?User $user = null): array
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class, 'email')->ignore($user?->id),
            ],
            'password' => [$user ? 'nullable' : 'required', 'confirmed', Password::defaults()],
            'role' => ['required', Rule::exists('roles', 'name')],
            'permissions' => ['array'],
            'permissions.*' => [Rule::exists('permissions', 'name')],
        ]);

        if (! $user || filled($validated['password'] ?? null)) {
            $validated['password'] = bcrypt($validated['password'] ?? '');
        }

        return $validated;
    }

    private function syncAuthorization(User $user, array $data): void
    {
        $user->syncRoles([$data['role']]);
        $user->syncPermissions($data['permissions'] ?? []);
    }

    private function formData(User $user): array
    {
        return [
            'user' => $user,
            'roles' => Role::query()->orderBy('name')->pluck('name'),
            'permissions' => Permission::query()->orderBy('name')->pluck('name'),
            'userRole' => $user->roles->first()?->name,
            'userPermissions' => $user->permissions->pluck('name')->all(),
        ];
    }
}
