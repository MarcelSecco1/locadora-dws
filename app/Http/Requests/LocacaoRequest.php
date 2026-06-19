<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LocacaoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $locacao = $this->route('locacao');

        return [
            'veiculo_id' => ['required', Rule::exists('veiculos', 'id')],
            'cliente' => ['required', 'string', 'max:255'],
            'data_retirada' => ['required', 'date'],
            'data_devolucao' => ['required', 'date', 'after_or_equal:data_retirada'],
        ];
    }
}
