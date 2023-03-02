<?php

namespace App\Http\Controllers;

use PDF;
use Illuminate\Http\Request;
use App\Models\Unidade;
use App\Models\Evento;
use App\Models\Eventoparticipante;
use App\Models\Tema;
use Illuminate\Support\Facades\Auth;

/**
 * Summary of EventoController
 */
class EventoController extends Controller
{

    /**
     * Summary of index
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request)
    {
        $data_inicio = mktime(0, 0, 0, date('m'), 1, date('Y'));
        $data_fim   = mktime(23, 59, 59, date('m'), date("t"), date('Y'));
        $data_inicio =  date('Y-m-d', $data_inicio);
        $data_fim   = date('Y-m-d', $data_fim);
        $hoje    = date('Y-m-d');

        $eventos  = Evento::where('unidade_id', auth()->user()->unidade_id)->where('dia','>=',$hoje)->skip(100)->take(100)->Paginate(10);
        $temas    = Tema::where('unidade_id', auth()->user()->unidade_id)->get();
        $unidades = Unidade::where('id', auth()->user()->unidade_id)->first();
        $unidades = $unidades->descricao;

        return view('eventolist', compact('eventos', 'unidades', 'data_inicio', 'data_fim', 'temas'));
    }


    /**
     * Summary of consulta
     * @param Request $request
     * @return mixed
     */
    public function consulta(Request $request)
    {

        $data_inicio = mktime(0, 0, 0, date('m'), 1, date('Y'));
        $data_fim   = mktime(23, 59, 59, date('m'), date("t"), date('Y'));
        $data_inicio =  date('Y-m-d', $data_inicio);
        $data_fim   = date('Y-m-d', $data_fim);
        #$hoje    = date('Y-m-d');

        if($request->tema){
            $eventos = Evento::whereBetween('dia',[$request->diainicio, $request->diafim])->
                            where('area','like','%'.$request->area.'%')->
                            where('turno', 'like', '%'.$request->turno. '%')->
                            where('unidade_id', auth()->user()->unidade_id)->
                            where('tema_id',$request->tema)->
                            skip(100)->take(100)->
                            Paginate(10);
        }else{
            $eventos = Evento::whereBetween('dia',[$request->diainicio, $request->diafim])->
                            where('area','like','%'.$request->area.'%')->
                            where('turno', 'like', '%'.$request->turno. '%')->
                            where('unidade_id', auth()->user()->unidade_id)->
                            skip(100)->take(100)->
                            Paginate(10);
        }


        $temas    = Tema::where('unidade_id',auth()->user()->unidade_id)->get();
        $unidades = Unidade::where('id', auth()->user()->unidade_id)->first();
        $unidades = $unidades->descricao;

        return view('eventolist', compact('eventos', 'unidades', 'data_inicio', 'data_fim', 'temas'));
    }


    /**
     * Summary of open
     * @param Request $request
     * @return mixed
     */
    public function open(Request $request)
    {
        $data_inicio = mktime(0, 0, 0, date('m'), 1, date('Y'));
        $data_fim   = mktime(23, 59, 59, date('m'), date("t"), date('Y'));
        $data_inicio =  date('Y-m-d', $data_inicio);
        $data_fim   = date('Y-m-d', $data_fim);
        $hoje    = date('Y-m-d');

        $temas    = Tema::where('unidade_id',auth()->user()->unidade_id)->get();
        $unidades = Unidade::where('id', auth()->user()->unidade_id)->first();
        $unidades = $unidades->descricao;
        return view('evento', compact('unidades', 'hoje', 'data_inicio', 'data_fim', 'temas'));
    }


    /**
     * Summary of add
     * @param Request $request
     * @return mixed
     */
    public function add(Request $request)
    {

        $credentials = $request->validate([
            'dia'        => ['required'],
            'turno'      => ['required'],
            'area'       => ['required'],
            'tema_id'    => ['required'],
        ]);

        if( date_format(date_create($request->dia),'Ymd') <  date('Ymd') && auth()->user()->grupo !== 'admin'){
            return back()->withErrors([
                'Error' => 'Eventos retroativo só poderão ser cadastrados por um administrador.',
            ])->onlyInput('Error');
        }

        $busca = Evento::whereDate('dia', $request->dia)->
                         where('area',  $request->area)->
                         where('turno', $request->turno)->
                         where('unidade_id', auth()->user()->unidade_id)->
                         count();

        if ($busca === 0) {
            $evento = Evento::create([
                'dia'        => $request->dia,
                'turno'      => $request->turno,
                'area'       => $request->area,
                'tema_id'    => $request->tema_id,
                'user_id'    => auth()->user()->id,
                'unidade_id' => auth()->user()->unidade_id
            ]);
            $sucesso = 'Registro cadastrado com sucesso...';
        } else {
            return back()->withErrors([
                'Error' => 'Este Evento já está cadastrado.',
            ])->onlyInput('Error');
        }
        $hoje     = date('Y-m-d');
        $temas    = Tema::where('unidade_id', auth()->user()->unidade_id)->get();
        $unidades = Unidade::where('id', auth()->user()->unidade_id)->first();
        $unidades = $unidades->descricao;

        return view('evento', compact('unidades', 'sucesso', 'hoje', 'temas'));
    }


    /**
     * Summary of edit
     * @param mixed $id
     * @return mixed
     */
    public function edit($id)
    {

        $campos   = Evento::where('id', $id)->where('unidade_id', auth()->user()->unidade_id)->first();
        if ($campos->count() === 0) {
            return back()->withErrors([
                'resp' => 'Evento não localizado para edição.',
            ])->onlyInput('resp');
        }

        if (date_format(date_create($campos->dia), 'Ymd') <  date('Ymd') && auth()->user()->grupo !== 'admin') {
            return back()->withErrors([
                'Error' => 'Eventos retroativo só poderão ser alterados por um administrador.',
            ])->onlyInput('Error');
        }

        # Se já possuir marcações de presença, não deixa editar o formulário mais...
        $disabled = Eventoparticipante::where('evento_id', $id)->where('unidade_id', auth()->user()->unidade_id)->count();
        if($disabled > 0){
            return back()->withErrors([
                'resp' => 'Este evento já possui participantes, logo não pode ser alterado.',
            ])->onlyInput('resp');
        }

        $hoje     = date('Y-m-d');
        $temas    = Tema::where('unidade_id', auth()->user()->unidade_id)->get();
        $unidades = Unidade::where('id', auth()->user()->unidade_id)->first();
        $unidades = $unidades->descricao;

        return view('eventoedit', compact('unidades','campos', 'hoje', 'temas', 'id', 'disabled'));

    }


    /**
     * Summary of update
     * @param Request $request
     * @return mixed
     */
    public function update(Request $request)
    {

        # Se já possuir marcações de presença, não deixa editar o formulário mais...
        $disabled = Eventoparticipante::where('evento_id', $request->id)->where('unidade_id', auth()->user()->unidade_id)->count();
        if ($disabled > 0) {
            return back()->withErrors([
                'resp' => 'Este evento já possui participantes, logo não pode ser alterado.',
            ])->onlyInput('resp');
        }

        $update = Evento::where('id', $request->id)->where('unidade_id', auth()->user()->unidade_id)->update([
                            'dia'     => $request->dia,
                            'turno'   => $request->turno,
                            'area'    => $request->area,
                            'tema_id' => $request->tema_id,
        ]);

        if ($update === 0) {
            return back()->withErrors([
                'descricao' => 'Erro ao salvar as alterações!',
            ])->onlyInput('descricao');
        } else {
            $sucesso = 'Registro alterado com sucesso...';
        }

        $id         = $request->id;
        $hoje       = date('Y-m-d');
        $temas      = Tema::where('unidade_id', auth()->user()->unidade_id)->get();
        $campos     = Evento::where('id', $request->id)->where('unidade_id', auth()->user()->unidade_id)->first();
        $unidades   = Unidade::where('id', auth()->user()->unidade_id)->first();
        $unidades   = $unidades->descricao;

        return view('eventoedit', compact('campos', 'unidades','sucesso', 'hoje', 'id', 'temas','disabled'));
    }


    /**
     * Summary of view
     * @param mixed $id
     * @return mixed
     */
    public function view($id)
    {
        $hoje       = date('Y-m-d');

        $campos     = Evento::where('id', $id)->where('unidade_id', auth()->user()->unidade_id)->first();

        $temas      = Tema::where('id', $campos->tema_id)->
                            where('unidade_id', auth()->user()->unidade_id)->
                            first();

        if (!$campos) {
            return back()->withErrors([
                'descricao' => 'Evento não localizado para consulta.',
            ])->onlyInput('descricao');
        }

       #### relacionamento evento -> eventoparticipante -> participante 1:N hasManyThrough no model Evento
       $participante = $campos->participantes()->orderBy('id', 'desc')->Paginate(10);
       ####################################################################

       $unidades = Unidade::where('id', auth()->user()->unidade_id)->first();
       $unidades = $unidades->descricao;

       return view('eventoview', compact('campos', 'unidades', 'hoje', 'temas', 'id', 'participante'));
    }


    /**
     * Summary of delete
     * @param mixed $id
     * @return mixed
     */
    public function delete($id)
    {
        Evento::where('id', $id)->where('unidade_id', auth()->user()->unidade_id)->delete();

        $unidades = Unidade::where('id', auth()->user()->unidade_id)->first();
        $unidades = $unidades->descricao;

        return redirect()->intended('evento/lista');
    }


    /**
     * Summary of ata
     * @param mixed $id
     * @return mixed
     */
    public function ata($id){

        $evento         = Evento::where('id',$id)->
                                  where('unidade_id',Auth::user()->unidade_id)->
                                  first();

        $tema           = Tema::where('id',$evento->tema_id)->first('descricao');

        $unidade        = Unidade::where('id',$evento->unidade_id)->first('descricao');

        $participante   = $evento->participantes()->orderBy('nome')->get();

        #return view('eventoata', compact('evento','tema', 'participante', 'unidade'));

        view()->share('eventoata',compact('evento','tema','participante','unidade'));
        $pdf = PDF::loadView('eventoata',compact('evento','tema','participante','unidade'));
        $pdf->render();
        #return $pdf->stream('Ata_De_Presença_'.$evento->dia.'.pdf', ['compress' => true,'Attachment' => false,]);
        return $pdf->download('Ata_De_Presença_'.$evento->dia.'.pdf');

    }

}
