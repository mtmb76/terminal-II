@extends('layouts.main')

@section('title','DDS - Dashboard')

<link rel="stylesheet" href="css/simple-calendar.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.2.2/Chart.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="js/jquery.simple-calendar.js"></script>
<script src="js/{{$userid}}_calendario.js"></script>
<script src="js/{{$userid}}_grafico-unidade.js"></script>
<script src="js/{{$userid}}_grafico-geral.js"></script>

@section('user.name')
    {{auth()->user()->name}}
@endsection

@section('user.unidade')
    {{$unidades}}
@endsection

@section('form.title')
   <h5>Dashboard de {{Auth()->user()->name}}</h5>
@endsection

@section('auth.content')

    @if(Auth()->user()->grupo !== 'lider')
            <ul class="nav nav-tabs"  id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active " id="calendario-tab" data-bs-toggle="tab" data-bs-target="#calendario" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true"> 
                        <span data-feather="corner-left-down"></span> 
                        &nbsp; Eventos - Agenda
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="grafico-unidade-tab" data-bs-toggle="tab" data-bs-target="#grafico-unidade" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">
                        <span data-feather="trending-up"></span> 
                        &nbsp; Gráfico - Unidade
                    </button>
                </li>
                @if (Auth()->user()->grupo !== 'ssma')
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="grafico-geral-tab" data-bs-toggle="tab" data-bs-target="#grafico-geral" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">
                            <span data-feather="bar-chart"></span> 
                            &nbsp; Gráfico - Geral
                        </button>
                    </li>                
                @endif
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="calendario" role="tabpanel" aria-labelledby="calendario-tab" tabindex="0">
                <div id="container"></div>
            </div>
            <div class="tab-pane fade" id="grafico-unidade" role="tabpanel" aria-labelledby="grafico-unidade-tab" tabindex="0">
                <style>
                    #container {
                    width: 70%;
                    margin: 15px auto;
                    text-align: center;
                    }
                </style>
                <div id="container">
                    <h2>Participações Diárias de {{App\Models\Unidade::find(Auth()->user()->unidade_id)->descricao}} </h2>
                    <div>
                        <canvas id="grafico_participacoes_unidade"></canvas>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="grafico-geral" role="tabpanel" aria-labelledby="grafico-unidade-tab" tabindex="0">
                <style>
                    #container {
                    width: 70%;
                    margin: 15px auto;
                    text-align: center;
                    }
                </style>
                <div id="container">
                    <h2>Participações Diárias Geral</h2>
                    <div>
                        <canvas id="grafico_participacoes_geral"></canvas>
                    </div>
                </div>
            </div>        
        </div>
    @endif


@endsection
