@php
    $selectedRole = old('role', $userRole);
    $selectedPermissions = old('permissions', $userPermissions ?? []);
@endphp

<div class="grid gap-6 lg:grid-cols-2">
    <div class="space-y-6">
        <div>
            <x-input-label for="name" :value="__('Nome')" class="text-slate-200" />
            <x-text-input id="name" name="name" type="text" class="mt-2" :value="old('name', $user->name)" required autofocus />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="email" :value="__('E-mail')" class="text-slate-200" />
            <x-text-input id="email" name="email" type="email" class="mt-2" :value="old('email', $user->email)" required />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Senha')" class="text-slate-200" />
            <x-text-input id="password" name="password" type="password" class="mt-2" {{ $user->exists ? '' : 'required' }} />
            <p class="mt-2 text-xs text-slate-400">{{ $user->exists ? 'Deixe em branco para manter a senha atual.' : 'Informe uma senha para o novo usuário.' }}</p>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" :value="__('Confirmar senha')" class="text-slate-200" />
            <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-2" {{ $user->exists ? '' : 'required' }} />
        </div>

        <div>
            <x-input-label for="role" :value="__('Papel')" class="text-slate-200" />
            <x-select-input id="role" name="role" class="mt-2" required>
                <option value="">Selecione um papel</option>
                @foreach ($roles as $role)
                    <option value="{{ $role }}" @selected($selectedRole === $role)>{{ ucfirst($role) }}</option>
                @endforeach
            </x-select-input>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>
    </div>

    <div>
        <div class="rounded-[1.75rem] border border-white/10 bg-white/5 p-5">
            <div class="flex items-center justify-between gap-3">
                <div>
                    <h3 class="text-lg font-black text-white">Permissões</h3>
                    <p class="mt-1 text-sm text-slate-300">Marque as permissões específicas do usuário.</p>
                </div>
                <span class="rounded-full border border-white/10 px-3 py-1 text-xs font-semibold text-slate-300">{{ count($permissions) }} disponíveis</span>
            </div>

            <div class="mt-4 grid gap-3 sm:grid-cols-2">
                @foreach ($permissions as $permission)
                    <label class="flex cursor-pointer items-start gap-3 rounded-2xl border border-white/10 bg-slate-950/40 p-4">
                        <x-checkbox-input
                            type="checkbox"
                            name="permissions[]"
                            value="{{ $permission }}"
                            @checked(in_array($permission, $selectedPermissions, true))
                            class="mt-1"
                        />
                        <span class="text-sm text-slate-200">{{ ucfirst($permission) }}</span>
                    </label>
                @endforeach
            </div>
            <x-input-error :messages="$errors->get('permissions')" class="mt-2" />
        </div>
    </div>
</div>
