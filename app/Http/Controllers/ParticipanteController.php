<?php

namespace App\Http\Controllers;

use App\Models\Eventoparticipante;
use App\Models\Participante;
use App\Models\Unidade;
use Illuminate\Http\Request;

class ParticipanteController extends Controller
{
    public function index(Request $request)
    {

        $participantes = Participante::where('unidade_id', auth()->user()->unidade_id)->skip(100)->take(100)->Paginate(10);

        $unidades = Unidade::where('id', auth()->user()->unidade_id)->first();
        $unidades = $unidades->descricao;

        return view('participantelist', compact('participantes', 'unidades'));
    }

    public function consulta(Request $request)
    {

        $participantes = Participante::where('cracha', 'like', '%' . $request->cracha . '%')->
                                       where('nome', 'like', '%' . $request->nome . '%')->
                                       where('unidade_id', auth()->user()->unidade_id)->skip(100)->take(100)->Paginate(10);

        $unidades = Unidade::where('id', auth()->user()->unidade_id)->first();
        $unidades = $unidades->descricao;

        return view('participantelist', compact('participantes', 'unidades'));
    }

    public function open(Request $request)
    {

        $unidades = Unidade::where('id', auth()->user()->unidade_id)->first();
        $unidades = $unidades->descricao;

        return view('participante', compact('unidades'));
    }

    public function add(Request $request)
    {
        $credentials = $request->validate([
            'nome'     => ['required'],
            'cpf'      => ['required'],
            'cracha'   => ['required'],
            'ativo'    => ['required'],
        ]);

        if(! $this->validaCPF($request->cpf) ){
            return back()->withErrors([
                'descricao' => 'O CPF do colaborador não é válido.',
            ])->onlyInput('descricao');
        }

        $busca = Participante::where('cpf', $request->cpf)->get();

        if( empty($request->ativo) ){
            $ativo = 0;
        }else{
            $ativo = 1;
        }

        if ($busca->count() === 0) {
            $participante = Participante::create([
                'nome'       => $request->nome,
                'cpf'        => str_replace(['.','-',' '],'',$request->cpf),
                'cracha'     => $request->cracha,
                'ativo'      => $ativo,
                'email'      => $request->email,
                'unidade_id' => auth()->user()->unidade_id,
                'user_id'    => auth()->user()->id,
            ]);
            $sucesso = 'Registro cadastrado com sucesso...';
        } else {
            return back()->withErrors([
                'descricao' => 'Este Participante já está cadastrado.',
            ])->onlyInput('descricao');
        }

        $unidades = Unidade::where('id', auth()->user()->unidade_id)->first();
        $unidades = $unidades->descricao;

        return view('participante', compact('unidades', 'sucesso'));
    }

    public function edit($id)
    {
        $campos = Participante::where('id', $id)->where('unidade_id', auth()->user()->unidade_id)->first();

        if ($campos->count() === 0) {
            return back()->withErrors([
                'descricao' => 'Participante não localizado para edição.',
            ])->onlyInput('descricao');
        }

        $unidades = Unidade::where('id', auth()->user()->unidade_id)->first();
        $unidades = $unidades->descricao;

        return view('participanteedit', compact('unidades', 'campos'));
    }

    public function update(Request $request)
    {

        if(! $this->validaCPF($request->cpf) ){
            return back()->withErrors([
                'descricao' => 'O CPF do colaborador não é válido.',
            ])->onlyInput('descricao');
        }
        $update = Participante::where('id', $request->id)->
                                where('unidade_id', auth()->user()->unidade_id)->
                                update( ['nome'   => $request->nome,
                                         'cpf'    => str_replace(['.', '-', ' '], '', $request->cpf),
                                         'cracha' => $request->cracha,
                                         'email'  => $request->email,
                                         'ativo'  => $request->ativo,
                                        ]);

        if ($update === 0) {
            return back()->withErrors([
                'descricao' => 'Erro ao salvar as alterações!',
            ])->onlyInput('descricao');
        } else {
            $sucesso = 'Registro alterado com sucesso...';
        }

        $campos = Participante::where('id', $request->id)->where('unidade_id', auth()->user()->unidade_id)->first();

        $unidades = Unidade::where('id', auth()->user()->unidade_id)->first();
        $unidades = $unidades->descricao;

        return view('participanteedit', compact('campos', 'unidades', 'sucesso'));
    }

    public function view($id)
    {
        $campos = Participante::where('id', $id)->where('unidade_id', auth()->user()->unidade_id)->first();
        if ($campos->count() === 0) {
            return back()->withErrors([
                'descricao' => 'Participante não localizado para consulta.',
            ])->onlyInput('descricao');
        }

        $unidades = Unidade::where('id', auth()->user()->unidade_id)->first();
        $unidades = $unidades->descricao;

        return view('participanteview', compact('unidades', 'campos', 'id'));
    }

    public function delete($id)
    {
        $jaRegistrado = Eventoparticipante::where('participante_id', $id)->where('unidade_id', auth()->user()->unidade_id)->count();
        if ($jaRegistrado > 0) {
            return back()->withErrors([
                'descricao' => 'Participante não pode ser excluído, pois possui registo em evento(s).',
            ])->onlyInput('descricao');
        }

        Participante::where('id', $id)->where('unidade_id', auth()->user()->unidade_id)->delete();

        $unidades = Unidade::where('id', auth()->user()->unidade_id)->first();
        $unidades = $unidades->descricao;

        return redirect()->intended('participante/lista');
    }

    public function validaCPF($cpf) {

        // Extrai somente os números
        $cpf = preg_replace( '/[^0-9]/is', '', $cpf );


        // Verifica se foi informado todos os digitos corretamente
        if (strlen($cpf) != 11) {
            return false;
        }

        // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        // Faz o calculo para validar o CPF
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }
        return true;
    }

}
