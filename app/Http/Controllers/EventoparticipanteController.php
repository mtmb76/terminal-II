<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Unidade;
use App\Models\Evento;
use App\Models\Participante;
use App\Models\Eventoparticipante;

class EventoparticipanteController extends Controller
{
    public function delete($evento, $participante){

        Eventoparticipante::where('evento_id', $evento)->
                            where('participante_id', $participante)->
                            delete();

        return redirect()->intended('evento/view/'.$evento);
    }

    public function add(Request $request)
    {
        #pesquiso primeiro pelo crachá
        $participante = Participante::where('cracha',trim($request->cracha))->first();

        if(!$participante){

            # se não achou pelo crachá, pesquisa pelo cpf
            $participante = Participante::where('cpf',trim($request->cracha))->first();

            if(!$participante){
                return back()->withErrors([
                    'cracha' => 'Crachá não localizado para inclusão!',
                ])->onlyInput('cracha');
            }
        }

        if($participante->ativo == 0){
            return back()->withErrors([
                'cracha' => 'Este participante está inativo!',
            ])->onlyInput('cracha');
        }

        $evento = Evento::where('id', $request->evento_id)->where('unidade_id', auth()->user()->unidade_id)->first();

        $jaexiste = Eventoparticipante::where('participante_id', $participante->id)->
                                        where('evento_id', $request->evento_id)->
                                        where('unidade_id', auth()->user()->unidade_id)->first();

        if(!$jaexiste)
        {
            $evento->eventoparticipante()->create([
                'unidade_id' => auth()->user()->unidade_id,
                'evento_id' => $request->evento_id,
                'participante_id' => $participante->id,
                'user_id' => auth()->user()->id,
            ]);

        }else{
            return back()->withErrors([
                'cracha' => 'Presença já registrada!',
            ])->onlyInput('cracha');
        }

        return redirect()->intended('evento/view/' . $request->evento_id);
    }

}
