@extends('layouts.main')

@section('title','Temas')

<link href="../css/dashboard.css" rel="stylesheet">

@section('user.name')
    {{auth()->user()->name}}
@endsection

@section('user.unidade')
    {{$unidades}}
@endsection

@section('form.title')
    <nav class="navbar navbar-light bg-light flex-md-nowrap p-0">
      <h4>Edição do Tema #{{$campos->id}}</h4>
    </nav>
@endsection

@section('auth.content')

  <form class="form-control mb-3" style="border: 0px transparent;" action="{{route('tema.update')}}" method="post" enctype="multipart/form-data">

    @csrf

    <div class="form-group">
        <label style="font-size: 12px;" for="unidade_id"><b>Unidade:</b></label>
        <input class="form-control mb-2" style="width: 200px; text-align: center;font-size: 12px;" type="text" value="{{$unidades}}" disabled>

        <label style="font-size: 12px;" for="descricao"><b>Descrição do Tema:</b></label>
        <input id="descricao" style="font-size: 12px; height: 30px;" class="form-control mb-2" type="text" name="descricao" value="{{$campos->descricao}}" required>

        <label style="font-size: 12px;" for="arquivo"><b>Arquivo da Apresentação:</b></label>
        <input style="width: 600px; font-size: 12px; height: 30px;" type="file" class="form-control" id="arquivo" name="arquivo">

        <input name="id" type="hidden" value="{{$campos->id}}">

        <nav class="navbar navbar-light bg-light flex-md-nowrap p-0 mt-3">
            <ul class="navbar-nav px-0">
                <li class="nav-item text-nowrap">
                    <button class="btn btn-success" style="width: 100px; height: 30px; font-size: 11px; font-weight: 500;" type="submit">Salvar</button>
                    <a href="{{route('tema.lista')}}"
                        <button class="btn btn-danger" style="width: 100px; height: 30px; font-size: 11px; font-weight: 500;" type="button">Voltar</button>
                    </a>
                </li>
            </ul>
        </nav>

    </div>
  </form>

@endsection
