<?php

namespace App\Http\Requests;

use App\Models\Veiculo;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VeiculoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $veiculo = $this->route('veiculo');

        return [
            'modelo' => ['required', 'string', 'max:255'],
            'marca' => ['required', 'string', 'max:255'],
            'ano' => ['required', 'integer', 'min:1900', 'max:'.date('Y')],
            'placa' => [
                'required',
                'string',
                'max:20',
                Rule::unique(Veiculo::class, 'placa')->ignore($veiculo?->id),
            ],
            'status' => ['required', Rule::in(['disponivel', 'alugado', 'manutencao'])],
            'imagem' => [
                Rule::requiredIf($this->isMethod('post')),
                'image',
                'max:10240',
            ],
        ];
    }
}
