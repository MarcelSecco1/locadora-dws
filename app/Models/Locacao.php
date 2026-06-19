<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Locacao extends Model
{
    use HasFactory;

    protected $table = 'locacoes';

    protected $fillable = [
        'veiculo_id',
        'cliente',
        'data_retirada',
        'data_devolucao',
    ];

    protected function casts(): array
    {
        return [
            'data_retirada' => 'date',
            'data_devolucao' => 'date',
        ];
    }

    public function veiculo(): BelongsTo
    {
        return $this->belongsTo(Veiculo::class);
    }
}
