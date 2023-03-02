<?php

namespace App\Http\Controllers;

use App\Models\Unidade;
use App\Models\User;
use App\Models\Evento;
use App\Models\Tema;
use App\Models\Participante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


/**
 * Summary of UserController
 */
class UserController extends Controller
{

    /**
     * Summary of login
     * @return mixed
     */
    public function login(){

        if( Auth::check() && Auth()->user()->ativo === 1 ){
            return redirect('/dashboard');
        }

        Auth::logout();

        $terminais = Unidade::orderby('id')->get(['id', 'descricao']);

        return view('login', compact('terminais'));
    }


    /**
     * Summary of logout
     * @param Request $request
     * @return mixed
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }


    /**
     * Summary of autenticar
     * @param Request $request
     * @return mixed
     */
    public function autenticar(Request $request)
    {

        if( Auth::check() && Auth()->user()->ativo === 1){
            return redirect('/dashboard');
        }

        Auth::logout();

        $credentials = $request->validate([
            'email'       => ['required', 'email'],
            'password'    => ['required'],
            'unidade_id'  => ['required']
        ]);

        $lembrar = ($request->remember == 1)?true:false;

        if (User::where('email',  $request->email)->where('unidade_id',$request->unidade_id)->count() === 0 ) {

            $user = User::create([
                'name'          => ucwords(str_replace('.', ' ', str_replace('@localfrio.com.br', '', $request->email))),
                'email'         => $request->email,
                'password'      => bcrypt($request->password),
                'unidade_id'    => $request->unidade_id,
                'grupo'         => 'ssma',
                'ativo'         => 0,
            ]);

        }

        $user = User::where('email',  $request->email)->where('unidade_id',$request->unidade_id)->first();

        if( $user->ativo === 0 ){
            return back()->withErrors([
                'email' => $user->name.', seu usuário enconta-se inativo para acesso a esta filial',
            ])->onlyInput('email');
        }

        if (Auth::attempt($credentials, $lembrar)) {

            $request->session()->regenerate();

            $this->geraCalendarioJS();

            $this->geraGraficoUnidade();

            $this->geraGraficoGeral();

            $unidades = Unidade::where('id', auth()->user()->unidade_id)->first();

            $unidades = $unidades->descricao;

            $userid   = auth()->user()->id;

            if(auth()->user()->grupo === 'lider'){
                return redirect()->intended('participante/lista');
            }else{
                return view('dashboard', compact('unidades', 'userid'));
            }
            

        } else {
            return back()->withErrors([
                'email' => 'As credenciais informadas são inválidas, ou não possui acesso a unidade escolhida...',
            ])->onlyInput('email');
        }

    }


    /**
     * Summary of dashboard
     * @param Request $request
     * @return mixed
     */
    public function dashboard(Request $request){

        $this->geraCalendarioJS();

        $this->geraGraficoUnidade();

        $this->geraGraficoGeral();

        $unidades    = Unidade::where('id', auth()->user()->unidade_id)->first();

        $unidades    = $unidades->descricao;

        $userid      = auth()->user()->id;

        return view('dashboard', compact('unidades', 'userid'));

    }


    /**
     * Summary of lista
     * @param Request $request
     * @return mixed
     */
    public function lista(Request $request){

        $users      = User::all();

        $nomeUnidade= Unidade::where('id',Auth()->user()->unidade_id)->first('descricao');

        return view('adminlista', compact('nomeUnidade','users'));
    }


    /**
     * Summary of consulta
     * @param Request $request
     * @return mixed
     */
    public function consulta(Request $request){


        $users =  User::where('name' ,'like','%'. $request->name .'%')->
                        where('grupo','like','%'. $request->grupo .'%')->
                        where('ativo','like','%'. $request->ativo .'%')->
                        skip(100)->
                        take(100)->
                        Paginate(10);

        $nomeUnidade= Unidade::where('id',Auth()->user()->unidade_id)->first('descricao');

        return view('adminlista', compact('nomeUnidade','users'));
    }


    /**
     * Summary of delete
     * @param mixed $id
     * @return mixed
     */
    public function delete($id)
    {
        if( User::where('id', $id)->delete() ){
            $sucesso = 'Registro excluído com sucesso!';
        }else{
            return back()->withErrors([
                'email' => 'Falha ao excluir o registro...',
            ])->onlyInput('email');
        }

        $users      = User::all();

        $nomeUnidade= Unidade::where('id',Auth()->user()->unidade_id)->first('descricao');

        return view('adminlista', compact('nomeUnidade','users', 'sucesso'));

    }


    /**
     * Summary of edit
     * @param mixed $id
     * @return mixed
     */
    public function edit($id)
    {
        $campos = User::where('id', $id)->first();

        if ($campos->count() === 0) {
            return back()->withErrors([
                'descricao' => 'Participante não localizado para edição.',
            ])->onlyInput('descricao');
        }

        $unidades = Unidade::where('id', auth()->user()->unidade_id)->first();

        $unidades = $unidades->descricao;

        return view('adminedit', compact('unidades', 'campos'));
    }


    /**
     * Summary of update
     * @param Request $request
     * @return mixed
     */
    public function update(Request $request)
    {
        $update = User::where('id', $request->id)->
                        update(['grupo'  => $request->grupo,
                                'ativo'  => $request->ativo,
                        ]);
        if ($update === 0) {
            return back()->withErrors([
                'descricao' => 'Erro ao salvar as alterações!',
            ])->onlyInput('descricao');
        } else {
            $sucesso = 'Registro alterado com sucesso...';
        }

        $campos = User::where('id', $request->id)->first();

        if ($campos->count() === 0) {
            return back()->withErrors([
                'descricao' => 'Participante não localizado para edição.',
            ])->onlyInput('descricao');
        }

        $unidades = Unidade::where('id', auth()->user()->unidade_id)->first();

        $unidades = $unidades->descricao;

        return view('adminedit', compact('unidades', 'campos','sucesso'));
    }


    /**
     * Summary of geraGraficoUnidade
     * @return bool
     */
    public function geraGraficoUnidade(){

        $dias           = '';
        $qtd            = 0;
        $participacoes  = '';
        $ausencias = '';
        $qtdDiasMes     = date("t");
        $ativos         = Participante::where('ativo','1')->
                                         where('unidade_id',auth()->user()->unidade_id)->count();

        for ($i=1; $i <= $qtdDiasMes; $i++) { 
            $dias = $dias . "'".$i."',";
            $qtd  = DB::scalar('SELECT COUNT(*) AS participacoes 
                                  FROM eventoparticipantes a 
                                 WHERE a.evento_id IN( 
                                                      SELECT id 
                                                        FROM eventos 
                                                       WHERE dia = :dia 
                                                         AND unidade_id = :unidade_id)'
                                                        ,[ 'dia' => date('Y-m-'). str_pad($i,2,'0',STR_PAD_LEFT), 
                                                        'unidade_id' => auth()->user()->unidade_id ]);
            $participacoes .= $qtd . ',';
            $ausencias .= ($ativos - $qtd) . ',';
        }

        $corpo = '
            $(document).ready(function () {
                var ctx = document.getElementById("grafico_participacoes_unidade").getContext("2d");
                var myChart = new Chart(ctx, {
                type: "bar",
                data: {
                    labels: ['. $dias .'],
                    labely:["'.$ativos.'"],
                    datasets: [
                    {
                        label: "Participações",
                        data: ['.$participacoes.'],
                        backgroundColor: "#22a32f",
                    },
                    {
                        label: "Ausências", 
                        data: ['.$ausencias.'],
                        backgroundColor: "#dbd96b",
                    },
            
                    ],
                },
                });
            });
        ';

        $file = "js/" . auth()->user()->id . "_grafico-unidade.js";

        if( file_exists($file) ){
            if( unlink($file) ){
                $arquivo = fopen($file, "w");
                fwrite($arquivo, $corpo);
                fclose($arquivo);
                $retorno = true;
            }else{
                $retorno = false;
            }
        }else{
            $arquivo = fopen($file, "w");
            fwrite($arquivo, $corpo);
            fclose($arquivo);
            $retorno = true;
        }

        return $retorno;

    }


    /**
     * Summary of geraGraficoGeral
     * @return bool
     */
    public function geraGraficoGeral(){

        $dias           = '';
        $qtd            = 0;
        $participacoes  = '';
        $ausencias = '';
        $qtdDiasMes     = date("t");
        $ativos         = Participante::where('ativo','1')->count();

        for ($i=1; $i <= $qtdDiasMes; $i++) { 
            $dias = $dias . "'".$i."',";
            $qtd  = DB::scalar('SELECT COUNT(*) AS participacoes 
                                  FROM eventoparticipantes a 
                                 WHERE a.evento_id IN( 
                                                      SELECT id 
                                                        FROM eventos 
                                                       WHERE dia = :dia)'
                                                        ,[ 'dia' => date('Y-m-'). str_pad($i,2,'0',STR_PAD_LEFT)]);
            $participacoes .= $qtd . ',';
            $ausencias .= ($ativos - $qtd) . ',';
        }

        $corpo = '
            $(document).ready(function () {
                var ctx = document.getElementById("grafico_participacoes_geral").getContext("2d");
                var myChart = new Chart(ctx, {
                type: "bar",
                data: {
                    labels: ['. $dias .'],
                    labely:["'.$ativos.'"],
                    datasets: [
                    {
                        label: "Participações",
                        data: ['.$participacoes.'],
                        backgroundColor: "#22a32f",
                    },
                    {
                        label: "Ausências", 
                        data: ['.$ausencias.'],
                        backgroundColor: "#dbd96b",
                    },
            
                    ],
                },
                });
            });
        ';

        $file = "js/" . auth()->user()->id . "_grafico-geral.js";

        if( file_exists($file) ){
            if( unlink($file) ){
                $arquivo = fopen($file, "w");
                fwrite($arquivo, $corpo);
                fclose($arquivo);
                $retorno = true;
            }else{
                $retorno = false;
            }
        }else{
            $arquivo = fopen($file, "w");
            fwrite($arquivo, $corpo);
            fclose($arquivo);
            $retorno = true;
        }

        return $retorno;

    }


    /**
     * Summary of geraCalendarioJS
     * @return bool
     */
    public function geraCalendarioJS(){

        #$data_incio  = date("Y-m-01");

        #$data_fim    = date("Y-m-t");

        #$eventos     = Evento::whereBetween('dia', [$data_incio, $data_fim])->where('unidade_id',auth()->user()->unidade_id)->orderBy('dia')->get();
        $eventos     = Evento::where('unidade_id',auth()->user()->unidade_id)->orderBy('dia')->get();

        $jsonEventos = '';

        foreach ($eventos as $value) {
            switch ($value->area) {
                case 'A':
                    $area = 'Administrativo';
                    break;
                case 'O':
                    $area = 'Operacional';
                    break;
                default:
                    $area = '*';
                    break;
            }
            switch ($value->turno) {
                case '1':
                    $turno = '1º';
                    break;
                case '2':
                    $turno = '2º';
                    break;
                case '3':
                    $turno = '3º';
                    break;
                default:
                    $turno = '*';
                    break;
            }

            # adiciono um dia ao dia do evento, porque o calendário tem um bug de colcar no dia anterior
            $dia          = date('Y-m-d', strtotime("+1 days", strtotime($value->dia)));

            $descricaoTema= Tema::find($value->tema_id);

            # crio um link para visualizar o evento
            $eventName    = "<a style='font-size:14px; color:#eee089;' href='" . url('/evento/view/' . $value->id) . "'>".'Evento #'.$value->id. "</a>" .'<br>Turno: '. $turno .'<br>Setor: '. $area . '<br>Tema: ' .$descricaoTema->descricao ;

            # crio a lista de eventos
            $jsonEventos .= '{startDate: "'.$dia.'",  endDate: "'.$dia.'",  summary:"'.$eventName.'"},';

        }
        $corpo = "
            $(document).ready(function () {
                $('#container').simpleCalendar({
                    fixedStartDay: true,
                    displayYear: true,
                    disableEventDetails: false,
                    disableEmptyDetails: true,
                    months: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
                    days: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
                    events: [
                    ".$jsonEventos."
                    ],
                });
            });
        ";

        $file = "js/" . auth()->user()->id . "_calendario.js";

        if( file_exists($file) ){
            if( unlink($file) ){
                $arquivo = fopen($file, "w");
                fwrite($arquivo, $corpo);
                fclose($arquivo);
                $retorno = true;
            }else{
                $retorno = false;
            }
        }else{
            $arquivo = fopen($file, "w");
            fwrite($arquivo, $corpo);
            fclose($arquivo);
            $retorno = true;
        }

        return $retorno;

    }

}
