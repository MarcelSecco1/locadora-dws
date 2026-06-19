<?php

namespace App\Http\Requests;

use App\Models\Locacao;
use App\Models\Veiculo;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class LocacaoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'veiculo_id' => ['required', Rule::exists('veiculos', 'id')],
            'cliente' => ['required', 'string', 'max:255'],
            'data_retirada' => ['required', 'date'],
            'data_devolucao' => ['required', 'date', 'after_or_equal:data_retirada'],
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator): void {
                if ($validator->errors()->any()) {
                    return;
                }

                $veiculoId = (int) $this->input('veiculo_id');
                $dataRetirada = $this->date('data_retirada')->toDateString();
                $dataDevolucao = $this->date('data_devolucao')->toDateString();
                $locacao = $this->route('locacao');
                $locacaoId = $locacao instanceof Locacao ? $locacao->getKey() : null;

                $veiculo = Veiculo::query()->find($veiculoId);

                if ($veiculo?->status === 'manutencao') {
                    $validator->errors()->add('veiculo_id', 'Este veículo está em manutenção e não pode ser locado.');
                }

                $conflito = Locacao::query()
                    ->where('veiculo_id', $veiculoId)
                    ->when($locacaoId, fn ($query) => $query->where('id', '!=', $locacaoId))
                    ->whereDate('data_retirada', '<=', $dataDevolucao)
                    ->whereDate('data_devolucao', '>=', $dataRetirada)
                    ->first();

                if ($conflito) {
                    $validator->errors()->add(
                        'data_retirada',
                        sprintf(
                            'Este período conflita com a locação #%d (%s a %s).',
                            $conflito->id,
                            $conflito->data_retirada->format('d/m/Y'),
                            $conflito->data_devolucao->format('d/m/Y')
                        )
                    );
                }
            },
        ];
    }
}
