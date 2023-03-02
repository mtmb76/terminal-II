@extends('layouts.main')

@section('title','Eventos')

@section('user.name')
    {{auth()->user()->name}}
@endsection

@section('user.unidade')
    {{$unidades}}
@endsection

@section('form.title')
    <nav class="navbar navbar-light flex-md-nowrap p-0">
      <h4>Consulta do Evento #{{$campos->id}}</h4>
    </nav>
@endsection

@section('auth.content')

<div class="container">

    <div class="row w-100">

        <div class="col col-sm-5 sm-1 py-0">

            <label style="font-size: 12px;" for="unidade_id"><b>Unidade:</b></label>
            <input id="unidade_id" class="form-control mb-2 py-1" style="font-size: 12px; font-weight: bold; width: 150px; text-align: center;" type="text" name="dstema" disabled value="{{$unidades}}">

            <label style="font-size: 12px;" for="dia"><b>Dia do evento:</b></label>
            <input id="dia" name="dia" value="{{$campos->dia}}" style="font-size: 12px; width: 200px; margin-bottom: 10px;" class="form-control form-control-light p-1 mb-2" type="date" placeholder="Informe a data" aria-label="Informe a data" disabled>

            <div class="row">
                <div class="col-md-1 d-none d-md-block " style="width: 245px;">

                    <label style="font-size: 12px;" for="turno"><b>Turno:</b></label>
                    <select class="form-select form-select-sm" style="width: 200px;" name="turno" id="turno" disabled>
                        <option value="">Abra para selecionar</option>
                        <option value="1" {{($campos->turno == 1)?'selected':''}}>Primeiro</option>
                        <option value="2" {{($campos->turno == 2)?'selected':''}}>Segundo</option>
                        <option value="3" {{($campos->turno == 3)?'selected':''}}>Terceiro</option>
                    </select>

                </div>
                <div class="col-md-1 d-none d-md-block " style="width: 220px;">

                    <label style="font-size: 12px;" for="area"><b>Área:</b></label>
                    <select class="form-select form-select-sm" style="width: 200px; margin-bottom: 10px;" name="area" id="area" disabled>
                        <option value="">Abra para selecionar</option>
                        <option value="A" {{($campos->area == 'A')?'selected':''}}>Administrativa</option>
                        <option value="O" {{($campos->area == 'O')?'selected':''}}>Operacional</option>
                    </select>

                </div>
            </div>

            <label style="font-size: 12px;" for="tema"><b>Tema:</b></label>
            <input id="tema" class="form-control mb-3 py-1" style="font-size: 12px; font-weight: 500; color:cadetblue; width: 93%;" type="text" name="tema" disabled value="{{$temas->descricao}}">

            @if ($temas->arquivo)
                <div class="row mb-4">
                    <div class="col-md-1 d-none d-md-block " style="width: 350px;">
                        <label style="font-size: 12px;" for="area"><b>Arquivo de Apresentação:</b></label>

                            <a href="../../storage/{{ str_replace('public/','',$temas->arquivo)}}" style="text-decoration: none; font-size: 14px;" target="_blank" rel="noopener">
                                <span data-feather="file" style="width: 15px;height: 15px; color:darkviolet;"></span>
                            </a>
                    </div>
                </div>
            @endif

            <div class="row mb-4">
                <div class="col-md-1 d-none d-md-block " style="width: 245px;">
                    <label style="font-size: 12px;" for="created"><b>Criado em:</b></label>
                    <span id="created" style="font-size: 12px;">{{ date_format($campos->created_at,'d-m-Y H:i:s')}}</span>
                </div>
                <div class="col-md-1 d-none d-md-block " style="width: 245px;">
                    <label style="font-size: 12px;" for="updated"><b>Editado em:</b></label>
                    <span id="updated" style="font-size: 12px;">{{ date_format($campos->created_at,'d-m-Y H:i:s')}}</span>
                </div>
            </div>

            <form class=" pl-sm-1" style="font-size: 12px; border: transparent;" action="{{route('eventoparticipante.add')}}" name="frmConsultaCracha" method="POST">
                @csrf
                @method('POST')
                <div class="input-group mt-4">
                    <span class="input-group-text" id="basic-addon1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-broadcast" viewBox="0 0 16 16">
                            <path d="M3.05 3.05a7 7 0 0 0 0 9.9.5.5 0 0 1-.707.707 8 8 0 0 1 0-11.314.5.5 0 0 1 .707.707zm2.122 2.122a4 4 0 0 0 0 5.656.5.5 0 1 1-.708.708 5 5 0 0 1 0-7.072.5.5 0 0 1 .708.708zm5.656-.708a.5.5 0 0 1 .708 0 5 5 0 0 1 0 7.072.5.5 0 1 1-.708-.708 4 4 0 0 0 0-5.656.5.5 0 0 1 0-.708zm2.122-2.12a.5.5 0 0 1 .707 0 8 8 0 0 1 0 11.313.5.5 0 0 1-.707-.707 7 7 0 0 0 0-9.9.5.5 0 0 1 0-.707zM10 8a2 2 0 1 1-4 0 2 2 0 0 1 4 0z"/>
                        </svg>
                    </span>
                    <input id="cracha" name="cracha" class="btn btn-light" style="font-size: 12px; border: 0px #ffff transparent;" type="text" placeholder="Realize a leitura do crachá" aria-label="Realize a leitura do crachá" autofocus>
                    <input type="hidden" name="evento_id" value="{{$campos->id}}">
                </div>
            </form>

            <nav class="navbar navbar-light  flex-md-nowrap p-0 mt-5">
                <ul class="navbar-nav px-0">
                    <li class="nav-item text-nowrap">
                        <a href="{{route('evento.lista')}}"
                            <button class="btn btn-danger" style="width: 100px; height: 30px; font-size: 11px; font-weight: 500;"  type="button">Voltar</button>
                        </a>
                        <a href="{{route('dashboard')}}"
                            <button class="btn btn-warning" style="width: 100px; height: 30px; font-size: 11px; font-weight: 500;"  type="button">Dashboard</button>
                        </a>
                        <a href="{{route('evento.novo')}}"
                            <button class="btn btn-success" style="width: 100px; height: 30px; font-size: 11px; font-weight: 500;"  type="button">Novo</button>
                        </a>
                        @if($participante->count() > 0)
                            <a href="{{route('evento.ata',[$campos->id])}}"
                            <button class="btn btn-primary" style="width: 100px; height: 30px; font-size: 11px; font-weight: 500;"  type="button">PDF</button>
                            </a>
                        @endif
                    </li>
                </ul>
            </nav>
        </div>

        <div class="col col-sm-7  sm-1 shadow py-1" style=" border-radius: 10px; height: 70%;">
            <table class="table table-striped table-hover table-sm " style="font-size: 10px;">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Crachá</th>
                        <th>Participante</th>
                        <th>Origem</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    @if(! empty($participante) && $participante->count())
                        @foreach ($participante as $cell)
                            <tr>
                                <td style="width: 10%;">{{$cell->id}}</td>
                                <td style="width: 20%;">{{$cell->cracha}}</td>
                                <td style="width: 40%;">{{$cell->nome}}</td>
                                <td style="width: 20%; color: #0f6674; font-weight: 600;">{{\App\Models\Unidade::find($cell->unidade_id)->descricao}} </td>
                                <td style="width: 10%; color: darkslategray">
                                    <a href="{{ route('eventoparticipante.delete', ['evento'=>$campos->id,'participante'=>$cell->id]) }}" style="text-decoration: none;">
                                        <span data-feather="trash"></span>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td>Nenhum participante vinculado ainda...</td>
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
                    <li class="page-item"><a class="page-link" href="{{url('evento/view/'.$campos->id.'?page=1')}}">1</a></li>
                    <li class="page-item"><a class="page-link" href="{{url('evento/view/'.$campos->id.'?page=2')}}">2</a></li>
                    <li class="page-item"><a class="page-link" href="{{url('evento/view/'.$campos->id.'?page=3')}}">3</a></li>
                    <li class="page-item"><a class="page-link" href="{{url('evento/view/'.$campos->id.'?page=4')}}">4</a></li>
                    <li class="page-item"><a class="page-link" href="{{url('evento/view/'.$campos->id.'?page=5')}}">5</a></li>
                </ul>
            </nav>
        </div>
    </div>

    <div class="row ">
        <div class="col col-sm-4">

        </div>
    </div>
</div>
@endsection
