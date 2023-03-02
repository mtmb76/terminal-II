@extends('layouts.main')

@section('title','Temas')

@section('user.name')
    {{auth()->user()->name}}
@endsection

@section('user.unidade')
    {{$unidades}}
@endsection

@section('form.title')
    <nav class="navbar navbar-light bg-light flex-md-nowrap p-0">
      <h4>Cadastro de Temas</h4>
    </nav>
@endsection

@section('auth.content')

  <form class="form-control" style="border: 0px transparent;" action="{{route('tema.add')}}" method="post" enctype="multipart/form-data">

    @csrf

    @method('POST')

    <div class="form-group">

        <label style="font-size: 12px;" for="area"><b>Unidade:</b></label>
        <input id="unidade_id" class="form-control mb-2 py-0" style="width: 150px; text-align: center; font-size: 12px;" type="text" name="dstema" disabled value="{{$unidades}}">

        <label style="font-size: 12px;" for="descricao"><b>Descrição do Tema:</b></label>
        <input id="descricao" style="width: 600px; font-size: 12px; height: 30px;" class="form-control mb-2 py-0" type="text" name="descricao" required>

        <label style="font-size: 12px;" for="arquivo"><b>Arquivo da Apresentação:</b></label>
        <input style="width: 600px; font-size: 12px; height: 30px;" type="file" class="form-control" id="arquivo" name="arquivo">

        <nav class="navbar navbar-light bg-light flex-md-nowrap mt-3 p-0">
            <ul class="navbar-nav px-0">
                <li class="nav-item text-nowrap">
                    <button class="btn btn-success" style="width: 100px; height: 30px; font-size: 11px; font-weight: 500;"type="submit">Salvar</button>
                    <a href="{{route('tema.lista')}}"
                        <button class="btn btn-danger" style="width: 100px; height: 30px; font-size: 11px; font-weight: 500;"  type="button">Voltar</button>
                    </a>
                </li>
            </ul>
        </nav>

    </div>
  </form>

@endsection
