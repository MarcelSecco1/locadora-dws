<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;

class Veiculo extends Model
{
    use HasFactory;

    protected $fillable = [
        'modelo',
        'marca',
        'ano',
        'placa',
        'status',
        'imagem',
    ];

    protected function imagemUrl(): Attribute
    {
        return Attribute::get(fn (): ?string => $this->imagem ? Storage::disk('public')->url($this->imagem) : null);
    }

    public function locacoes(): HasMany
    {
        return $this->hasMany(Locacao::class);
    }
}
