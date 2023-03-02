@extends('layouts.main')

@section('title','Administração de Usuários')

@section('user.name')
    {{auth()->user()->name}}
@endsection

@section('user.unidade')
    {{$nomeUnidade->descricao}}
@endsection

@section('form.title')
    <nav class="navbar navbar-light bg-light flex-md-nowrap p-0">
        <h4>Listagem de Usuários do Sistema</h4>
    </nav>
@endsection

@section('auth.content')

    <form class="form-control ml-0" style="border: 0px transparent;" action="{{route('admin.consulta')}}" name="frmAdminConsulta" method="GET">

        @csrf

        @method('GET')

        <label style=" font-size: 12px;" for="name"><b>Pesquisa pelo nome:</b></label>
        <input id="name" name="name" style="width: 600px; font-size: 12px;" class="form-control form-control-light p-1" type="text" placeholder="Pesquise aqui pelo nome" aria-label="Pesquise aqui pelo nome">

        <div class="row">
            <div class="col-md-1 d-none d-md-block bg-light" style="width: 245px;">

                <label  style=" font-size: 12px;" for="grupo"><b>Pesquisa pelo grupo:</b></label>
                <select class="form-select form-select-sm" style="width: 200px; font-size: 12px;" name="grupo" id="grupo">
                    <option value="">Abra para selecionar</option>
                    <option value="admin">Administrador</option>
                    <option value="ssma" >SSMA</option>
                    <option value="head" >Gestor</option>
                    <option value="lider">Líder</option>
                </select>

            </div>
            <div class="col-md-1 d-none d-md-block bg-light" style="width: 220px;">

                <label style=" font-size: 12px;" for="ativo"><b>Pesquisa pelo Status:</b></label>
                <select class="form-select form-select-sm" style="width: 200px; margin-bottom: 10px; font-size: 12px;" name="ativo" id="ativo">
                    <option value="">Abra para selecionar</option>
                    <option value="1">Ativo</option>
                    <option value="0">Inativo</option>
                </select>

            </div>
        </div>

        <ul class="navbar-nav mt-3 mb-3" style="margin-left: 0px;">
            <li class="nav-item text-nowrap">
                <button style="width: 100px; height: 30px; font-size: 11px; font-weight: 500;" class="btn btn-info" type="submit">Pesquisar</button>
                <a href="{{route('admin.lista')}}"
                    <button style="width: 100px; height: 30px; font-size: 11px; font-weight: 500;" class="btn btn-warning" type="button">Atualizar</button>
                </a>
            </li>
        </ul>
    </form>

    <table class="table table-striped table-hover table-sm">
        <thead class="thead-dark">
        <tr>
            <th>#</th>
            <th>Nome</th>
            <th>E-mail</th>
            <th>Unidade</th>
            <th>Grupo</th>
            <th>Ativo</th>
            <th>Ações</th>
        </tr>
        </thead>
        <tbody>
        @if(! empty($users) && $users->count())
            @foreach ($users as $cell)
                <tr>
                    <td style="width: 10%; font-weight: 800;">{{$cell->id}}</td>
                    <td style="width: 20%;">{{$cell->name}}</td>
                    <td style="width: 30%;">{{$cell->email}}</td>
                    <td style="width: 10%; color: #0f6674; font-weight: 800;">{{ \App\Models\Unidade::where('id',$cell->unidade_id)->first()->descricao }}</td>
                    @if ($cell->grupo === 'admin')
                        <td style="width: 10%; color: blueviolet; font-weight: 700;">{{ ucfirst( $cell->grupo ) }}</td>
                    @else
                        <td style="width: 10%;">{{ ucfirst( $cell->grupo ) }}</td>    
                    @endif
                    <td style="width: 10%;">{{ ($cell->ativo===1)?'Sim':'Não' }}</td>
                    <td style="width: 10%; color: darkslategray;">
                        <a href="/admin/edit/{{$cell->id}}" style="text-decoration: none;">
                            <span data-feather="edit"></span>
                        </a>
                        &nbsp;
                        @if(Auth()->user()->id !== $cell->id)
                            <a href="/admin/delete/{{$cell->id}}" style="text-decoration: none;">
                                <span data-feather="trash"></span>
                            </a>
                        @endif
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td>Nenhum usuário cadastrado...</td>
                <td>&nbsp;</td>
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
            <li class="page-item"><a class="page-link" href="{{url('admin/consulta?page=1')}}">1</a></li>
            <li class="page-item"><a class="page-link" href="{{url('admin/consulta?page=2')}}">2</a></li>
            <li class="page-item"><a class="page-link" href="{{url('admin/consulta?page=3')}}">3</a></li>
            <li class="page-item"><a class="page-link" href="{{url('admin/consulta?page=4')}}">4</a></li>
            <li class="page-item"><a class="page-link" href="{{url('admin/consulta?page=5')}}">5</a></li>
            <li class="page-item"><a class="page-link" href="{{url('admin/consulta?page=6')}}">6</a></li>
            <li class="page-item"><a class="page-link" href="{{url('admin/consulta?page=7')}}">7</a></li>
            <li class="page-item"><a class="page-link" href="{{url('admin/consulta?page=8')}}">8</a></li>
            <li class="page-item"><a class="page-link" href="{{url('admin/consulta?page=9')}}">9</a></li>
            <li class="page-item"><a class="page-link" href="{{url('admin/consulta?page=10')}}">10</a></li>
        </ul>
    </nav>

@endsection
