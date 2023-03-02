@extends('layouts.main')

@section('title','Usuários')

<link href="../css/dashboard.css" rel="stylesheet">

@section('user.name')
    {{auth()->user()->name}}
@endsection

@section('user.unidade')
    {{$unidades}}
@endsection

@section('form.title')
    <nav class="navbar navbar-light bg-light flex-md-nowrap p-0">
        <h4>Edição do Usuário # {{$campos->id}} </h4>
    </nav>
@endsection

@section('auth.content')

    <form class="form-control mb-3" style="border: 0px transparent; font-size: 12px;" action="{{route('admin.update')}}" name='frmEdicaoUsuario' method="POST">

        @csrf

        @method('POST')

        <div class="form-group">

            <label style=" font-size: 12px;" for="name"><b>Nome do Usuário:</b></label>
            <input id="name" name="name" style="width: 600px; font-size: 12px; border: none;" value="{{$campos->name}}" class="form-control form-control-light p-1" type="text" placeholder="Pesquise aqui pelo nome" aria-label="Pesquise aqui pelo nome" disabled>

            <div class="row">
                <div class="col-md-1 d-none d-md-block bg-light" style="width: 245px;">

                    <label  style=" font-size: 12px;" for="grupo"><b>Grupo:</b></label>
                    <select class="form-select form-select-sm" style="width: 200px; font-size: 12px;" name="grupo" id="grupo">
                        <option value="">Abra para selecionar</option>
                        <option value="admin" {{($campos->grupo === 'admin')?' selected':''}}>Administrador</option>
                        <option value="head" {{($campos->grupo === 'head')?' selected':''}}>Gestor</option>
                        <option value="ssma" {{($campos->grupo === 'ssma')?' selected':''}}>SSMA</option>
                        <option value="lider" {{($campos->grupo === 'lider')?' selected':''}}>Líder</option>
                    </select>

                </div>
                <div class="col-md-1 d-none d-md-block bg-light" style="width: 220px;">

                    <label style=" font-size: 12px;" for="ativo"><b>Status:</b></label>
                    <select class="form-select form-select-sm" style="width: 200px; margin-bottom: 10px; font-size: 12px;" name="ativo" id="ativo">
                        <option value="">Abra para selecionar</option>
                        <option value="1" {{($campos->ativo === 1)?' selected':''}}>Ativo</option>
                        <option value="0" {{($campos->ativo === 0)?' selected':''}}>Inativo</option>
                    </select>

                </div>
                <div class="col-md-1 d-none d-md-block bg-light" style="width: 220px;">

                    <label style=" font-size: 12px;" for="unidade"><b>Unidade:</b></label>
                    <input id="unidade" name="unidade" style="width: 135px; text-align: center; font-size: 12px;  color: #0f6674; border: none; font-weight: 800;" value="{{ \App\Models\Unidade::where('id',$campos->unidade_id)->first()->descricao }}" class="form-control form-control-light p-1" type="text" disabled>
                </div>
            </div>

            <nav class="navbar navbar-light bg-light flex-md-nowrap p-0">
                <ul class="navbar-nav px-0">
                    <li class="nav-item text-nowrap">
                        <button class="btn btn-success"  style="width: 100px; height: 30px; font-size: 11px; font-weight: 500;"  type="submit">Salvar</button>
                        <a href="{{route('admin.lista')}}"
                        <button class="btn btn-danger"  style="width: 100px; height: 30px; font-size: 11px; font-weight: 500;"  type="button">Voltar</button>
                        </a>
                    </li>
                </ul>
            </nav>

        </div>
        <input name="id" type="hidden" value="{{$campos->id}}">
    </form>

@endsection
