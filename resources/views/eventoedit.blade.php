@extends('layouts.main')

@section('title','Eventos')

<link href="../css/dashboard.css" rel="stylesheet">

@section('user.name')
    {{auth()->user()->name}}
@endsection

@section('user.unidade')
    {{$unidades}}
@endsection

@section('form.title')
    <nav class="navbar navbar-light bg-light flex-md-nowrap p-0">
      <h4>Edição do Evento #{{$campos->id}} </h4>
    </nav>
@endsection

@section('auth.content')

  <form class="form-control" style="border: 0px transparent;" action="{{route('evento.update')}}" method="post">

    @csrf

    @method('POST')

    <input type="hidden" name="id" id="id" value="{{$id}}">

    <div class="form-group">
        <label style="font-size: 12px;" for="area"><b>Unidade:</b></label>
        <input id="unidade_id" class="form-control mb-2 py-0" style="width: 150px; text-align: center;font-size: 12px; font-weight: 600;" type="text" name="dstema" disabled value="{{$unidades}}">

        <label style="font-size: 12px;"  for="dia"><b>Dia do evento:</b></label>
        <input id="dia" name="dia" value="{{$campos->dia}}" style="width: 200px; margin-bottom: 10px; font-size: 12px;" class="form-control form-control-light p-1 mb-2" type="date" placeholder="Informe a data" aria-label="Informe a data" {{($disabled <> 0)?'disabled':'required'}}>

        <div class="row">
            <div class="col-md-1 d-none d-md-block bg-light" style="width: 245px;">

                <label style="font-size: 12px;"  for="turno"><b>Turno:</b></label>
                <select class="form-select form-select-sm" style="width: 200px; font-size: 12px;" name="turno" id="turno"  {{($disabled <> 0)?'disabled':'required'}}>
                    <option value="">Abra para selecionar</option>
                    <option value="1" {{($campos->turno == 1)?'selected':''}}>Primeiro</option>
                    <option value="2" {{($campos->turno == 2)?'selected':''}}>Segundo</option>
                    <option value="3" {{($campos->turno == 3)?'selected':''}}>Terceiro</option>
                </select>

            </div>
            <div class="col-md-1 d-none d-md-block bg-light" style="width: 220px;">

                <label style="font-size: 12px;" for="area"><b>Área:</b></label>
                <select class="form-select form-select-sm" style="width: 200px; margin-bottom: 10px; font-size: 12px;" name="area" id="area" {{($disabled <> 0)?'disabled':'required'}}>
                    <option value="">Abra para selecionar</option>
                    <option value="A" {{($campos->area == 'A')?'selected':''}}>Administrativa</option>
                    <option value="O" {{($campos->area == 'O')?'selected':''}}>Operacional</option>
                </select>

            </div>
        </div>

        <label style="font-size: 12px;"  for="tema_id"><b>Tema:</b></label>
        <select class="form-select form-select-sm" style="width: 445px; margin-bottom: 20px; font-size: 12px;" name="tema_id" id="tema_id" {{($disabled <> 0)?'disabled':'required'}}>
            <option value="">Selecione um tema</option>
            @foreach($temas as $cell)
                <option value="{{$cell->id}}" {{($campos->tema_id == $cell->id)?'selected':''}}>{{$cell->descricao}}</option>
            @endforeach
        </select>


        <nav class="navbar navbar-light bg-light flex-md-nowrap p-0">
            <ul class="navbar-nav px-0">
                <li class="nav-item text-nowrap">
                    <button class="btn btn-success" style="width: 100px; height: 30px; font-size: 11px; font-weight: 500;"  type="submit" {{($disabled <> 0)?'disabled':''}}>Salvar</button>
                    <a href="{{route('evento.lista')}}"
                        <button class="btn btn-danger" style="width: 100px; height: 30px; font-size: 11px; font-weight: 500;"  type="button">Voltar</button>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
  </form>

@endsection
