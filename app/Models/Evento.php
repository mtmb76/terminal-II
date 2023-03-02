<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'unidade_id',
        'tema_id',
        'user_id',
        'dia',
        'turno',
        'area',
    ];

    /**
     *   'evento_id', chave entre eventoparticipante e evento
     *   'id', chave em participante
     *   'id', chave em evento
     *   'participante_id'  chave de eventoparticipante para participante
     *   @return \Illuminate\Database\Eloquent\Relations\hasManyThrough
     */
    public function participantes()
    {
        return $this->hasManyThrough(Participante::class, Eventoparticipante::class,'evento_id','id','id','participante_id');
    }

    /**
     * Pega o tema do Evento
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function eventoparticipante()
    {
        return $this->hasMany(Eventoparticipante::class);
    }

}
