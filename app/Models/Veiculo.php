<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
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

    protected function statusHoje(): Attribute
    {
        return Attribute::get(function (): string {
            if ($this->status === 'manutencao') {
                return 'manutencao';
            }

            return $this->alugadoEm(now()) ? 'alugado' : 'disponivel';
        });
    }

    protected function statusHojeLabel(): Attribute
    {
        return Attribute::get(fn (): string => match ($this->status_hoje) {
            'alugado' => 'Alugado hoje',
            'manutencao' => 'Manutenção',
            default => 'Disponível hoje',
        });
    }

    protected function statusHojeClasses(): Attribute
    {
        return Attribute::get(fn (): string => match ($this->status_hoje) {
            'alugado' => 'bg-sky-400/15 text-sky-200',
            'manutencao' => 'bg-amber-400/15 text-amber-200',
            default => 'bg-emerald-400/15 text-emerald-200',
        });
    }

    public function locacoes(): HasMany
    {
        return $this->hasMany(Locacao::class);
    }

    public function alugadoEm($date): bool
    {
        $date = Carbon::parse($date)->toDateString();

        if ($this->relationLoaded('locacoes')) {
            return $this->locacoes->contains(
                fn (Locacao $locacao): bool => $locacao->data_retirada->toDateString() <= $date
                    && $locacao->data_devolucao->toDateString() >= $date
            );
        }

        return $this->locacoes()
            ->whereDate('data_retirada', '<=', $date)
            ->whereDate('data_devolucao', '>=', $date)
            ->exists();
    }

    public function scopeAlugadosEm(Builder $query, $date): Builder
    {
        $date = Carbon::parse($date)->toDateString();

        return $query
            ->where('status', '!=', 'manutencao')
            ->whereHas('locacoes', function (Builder $query) use ($date): void {
                $query
                    ->whereDate('data_retirada', '<=', $date)
                    ->whereDate('data_devolucao', '>=', $date);
            });
    }

    public function scopeDisponiveisEm(Builder $query, $date): Builder
    {
        $date = Carbon::parse($date)->toDateString();

        return $query
            ->where('status', '!=', 'manutencao')
            ->whereDoesntHave('locacoes', function (Builder $query) use ($date): void {
                $query
                    ->whereDate('data_retirada', '<=', $date)
                    ->whereDate('data_devolucao', '>=', $date);
            });
    }
}
