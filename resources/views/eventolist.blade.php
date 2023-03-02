@extends('layouts.main')

@section('title','Eventos')

@section('user.name')
    {{auth()->user()->name}}
@endsection

@section('user.unidade')
    {{$unidades}}
@endsection

@section('form.title')
    <nav class="navbar navbar-light bg-light flex-md-nowrap p-0">
      <h4>Listagem de Eventos</h4>
    </nav>
@endsection

@section('auth.content')

        <form class="form-control" style="border: 0px transparent;" action="{{route('evento.consulta')}}" name="frmEventoConsulta" method="GET">

            @csrf

            @method('GET')

            <label for="dias" style=" font-size: 12px;"><b>Pesquisa pela data entre:</b></label>
            <div id="dias" class="row">
                <div class="col-md-1 d-none d-md-block bg-light" style="width: 220px;">
                    <input id="diainicio" name="diainicio" value="{{$data_inicio}}" style="width: 200px; margin-bottom: 10px; font-size: 12px;" class="form-control form-control-light p-1 mb-2" type="date" placeholder="Pesquise aqui pela data" aria-label="Pesquise aqui pela data">
                </div>
                <div class="col-md-1 d-none d-md-block bg-light" style="width: 10px;">
                    e
                </div>
                <div class="col-md-1 d-none d-md-block bg-light" style="width: 220px;">
                    <input id="diafim" name="diafim" value="{{$data_fim}}" style="width: 200px; margin-bottom: 10px; font-size: 12px;" class="form-control form-control-light p-1 mb-2" type="date" placeholder="Pesquise aqui pela data" aria-label="Pesquise aqui pela data">
                </div>
            </div>

            <div class="row">
                <div class="col-md-1 d-none d-md-block bg-light" style="width: 245px;">

                    <label  style=" font-size: 12px;" for="turno"><b>Pesquisa pelo turno:</b></label>
                    <select class="form-select form-select-sm" style="width: 200px; font-size: 12px;" name="turno" id="turno">
                        <option value="">Abra para selecionar</option>
                        <option value="1">Primeiro</option>
                        <option value="2">Segundo</option>
                        <option value="3">Terceiro</option>
                    </select>

                </div>
                <div class="col-md-1 d-none d-md-block bg-light" style="width: 220px;">

                    <label style=" font-size: 12px;" for="area"><b>Pesquisa pela área:</b></label>
                    <select class="form-select form-select-sm" style="width: 200px; margin-bottom: 10px; font-size: 12px;" name="area" id="area">
                        <option value="">Abra para selecionar</option>
                        <option value="A">Administrativa</option>
                        <option value="O">Operacional</option>
                    </select>

                </div>
            </div>

            <label  style=" font-size: 12px;" for="tema"><b>Pesquisa pelo tema:</b></label>
            <select class="form-select form-select-sm" style="width: 445px; font-size: 12px;" name="tema" id="tema">
                <option value="">Selecione um tema</option>
                @foreach($temas as $cell)
                    <option value="{{$cell->id}}">{{$cell->descricao}}</option>
                @endforeach
            </select>

            <ul class="navbar-nav mt-3 mb-3" style="margin-left: 0px;">
                <li class="nav-item text-nowrap">
                    <button style="width: 100px; height: 30px; font-size: 11px; font-weight: 500;"  class="btn btn-info" type="submit">Pesquisar</button>
                    <a href="{{route('evento.lista')}}"
                        <button style="width: 100px; height: 30px; font-size: 11px; font-weight: 500;"  class="btn btn-warning" type="button">Atualizar</button>
                    </a>
                    <a href="{{route('evento.novo')}}"
                        <button style="width: 100px; height: 30px; font-size: 11px; font-weight: 500;"  class="btn btn-success" type="button">Novo</button>
                    </a>
                </li>
            </ul>

        </form>

        <table class="table table-striped table-hover table-sm">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Dia</th>
                    <th>Turno</th>
                    <th>Área</th>
                    <th>Tema</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @if(! empty($eventos) && $eventos->count())
                    @foreach ($eventos as $evento)
                        <tr>
                            <td style="width: 10%;">{{$evento->id}}</td>
                            <td style="width: 10%;">{{  date('d-m-Y',strtotime($evento->dia)) }}</td>

                            @if($evento->turno == 1)
                               <td style="width: 10%;">Primeiro</td>
                            @elseif($evento->turno == 2)
                               <td style="width: 10%;">Segundo</td>
                            @else
                               <td style="width: 10%;">Terceiro</td>
                            @endif

                            @if($evento->area == 'A')
                               <td style="width: 10%;">Administrativo</td>
                            @elseif($evento->area == 'O')
                               <td style="width: 10%;">Operacional</td>
                            @else
                               <td style="width: 10%;"></td>
                            @endif

                            <td style="width: 40%; font-weight: 800; color:cadetblue;">
                                @foreach($temas as $tema)
                                    {{($tema->id == $evento->tema_id)?$tema->descricao:''}}
                                @endforeach
                            </td>

                            <td style="width: 10%; color: darkslategray">
                                <a href="/evento/view/{{$evento->id}}" style="text-decoration: none;">
                                    <span data-feather="eye"></span>
                                </a>
                                &nbsp;
                                <a href="/evento/edit/{{$evento->id}}" style="text-decoration: none;">
                                    <span data-feather="edit"></span>
                                </a>
                                &nbsp;
                                <a href="/evento/delete/{{$evento->id}}" style="text-decoration: none;">
                                    <span data-feather="trash"></span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td>Nenhum evento cadastrado...</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                @endif
            </tbody>
        </table>

        <nav aria-label="...">
            <ul class="pagination w-100" style=" font-size: 12px;">
                <li class="page-item"><a class="page-link" href="{{url('evento/consulta?page=1')}}">1</a></li>
                <li class="page-item"><a class="page-link" href="{{url('evento/consulta?page=2')}}">2</a></li>
                <li class="page-item"><a class="page-link" href="{{url('evento/consulta?page=3')}}">3</a></li>
                <li class="page-item"><a class="page-link" href="{{url('evento/consulta?page=4')}}">4</a></li>
                <li class="page-item"><a class="page-link" href="{{url('evento/consulta?page=5')}}">5</a></li>
                <li class="page-item"><a class="page-link" href="{{url('evento/consulta?page=6')}}">6</a></li>
                <li class="page-item"><a class="page-link" href="{{url('evento/consulta?page=7')}}">7</a></li>
                <li class="page-item"><a class="page-link" href="{{url('evento/consulta?page=8')}}">8</a></li>
                <li class="page-item"><a class="page-link" href="{{url('evento/consulta?page=9')}}">9</a></li>
                <li class="page-item"><a class="page-link" href="{{url('evento/consulta?page=10')}}">10</a></li>
            </ul>
        </nav>

@endsection
