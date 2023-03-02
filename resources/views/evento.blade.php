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
      <h4>Cadastro de Eventos</h4>
    </nav>
@endsection

@section('auth.content')

  <form class="form-control" style="border: 0px transparent;" action="{{route('evento.add')}}" method="POST">

    @csrf

    @method('POST')

    <div class="form-group">
        <label style="font-size: 12px;" for="area"><b>Unidade:</b></label>
        <input id="unidade_id" class="form-control mb-2 py-0" style="width: 150px; text-align: center; font-size: 12px;" type="text" name="dstema" disabled value="{{$unidades}}">

        <label style="font-size: 12px;" for="dia"><b>Dia do evento:</b></label>
        <input id="dia" name="dia" value="{{$hoje}}" style="width: 200px; margin-bottom: 10px;font-size: 12px;" class="form-control form-control-light p-1 mb-2" type="date" placeholder="Informe a data" aria-label="Informe a data" required>

        <div class="row">
            <div class="col-md-1 d-none d-md-block bg-light" style="width: 245px;">

                <label style="font-size: 12px;" for="turno"><b>Turno:</b></label>
                <select class="form-select form-select-sm" style="width: 200px; font-size: 12px;" name="turno" id="turno" required>
                    <option value="">Abra para selecionar</option>
                    <option value="1">Primeiro</option>
                    <option value="2">Segundo</option>
                    <option value="3">Terceiro</option>
                </select>

            </div>
            <div class="col-md-1 d-none d-md-block bg-light" style="width: 220px;">

                <label style="font-size: 12px;" for="area"><b>Área:</b></label>
                <select class="form-select form-select-sm" style="width: 200px; margin-bottom: 10px;font-size: 12px;" name="area" id="area" required>
                    <option value="">Abra para selecionar</option>
                    <option value="A">Administrativa</option>
                    <option value="O">Operacional</option>
                </select>

            </div>
        </div>

        <label style="font-size: 12px;" for="tema_id"><b>Tema:</b></label>
        <select class="form-select form-select-sm" style="width: 445px; margin-bottom: 20px;font-size: 12px;" name="tema_id" id="tema_id" required>
            <option value="">Selecione um tema</option>
            @foreach($temas as $cell)
                <option value="{{$cell->id}}">{{$cell->descricao}}</option>
            @endforeach
        </select>


        <nav class="navbar navbar-light bg-light flex-md-nowrap p-0 mt-3">
            <ul class="navbar-nav px-0">
                <li class="nav-item text-nowrap">
                    <button class="btn btn-success" style="width: 100px; height: 30px; font-size: 11px; font-weight: 500;" type="submit">Salvar</button>
                    <a href="{{route('evento.lista')}}"
                        <button class="btn btn-danger" style="width: 100px; height: 30px; font-size: 11px; font-weight: 500;"  type="button">Voltar</button>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

  </form>

@endsection
