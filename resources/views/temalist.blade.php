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
      <h4>Listagem de Temas </h4>
    </nav>
@endsection

@section('auth.content')

        <form class="form-control ml-0" style="border: 0px transparent;" action="{{route('tema.consulta')}}" name="frmTema/consulta" enctype="multipart/form-data" method="GET" >

            @csrf
            @method('GET')

            <label style=" font-size: 12px;" for="descricao"><b>Pesquisa pela descrição:</b></label>
            <input id="descricao" name="descricao" style="width: 600px; font-size: 12px;" class="form-control form-control-light p-1" type="text" placeholder="Pesquise aqui pela descrição" aria-label="Pesquise aqui pela descrição">
            <!--<button class="btn btn-success" type="submit">Text</button>-->

            <ul class="navbar-nav mt-2 mb-1" style="margin-left: 0px;">
                <li class="nav-item text-nowrap mt-3">
                    <button style="width: 100px; height: 30px; font-size: 11px; font-weight: 500;" class="btn btn-info" type="submit">Pesquisar</button>
                    <a href="{{route('tema.lista')}}"
                        <button style="width: 100px; height: 30px; font-size: 11px; font-weight: 500;" class="btn btn-warning" type="button">Atualizar</button>
                    </a>
                    <a href="{{route('tema.novo')}}"
                        <button style="width: 100px; height: 30px; font-size: 11px; font-weight: 500;" class="btn btn-success" type="button">Novo</button>
                    </a>
                </li>
            </ul>
        </form>

        <table class="table table-striped table-hover table-sm">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Descrição</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @if(! empty($temas) && $temas->count())
                    @foreach ($temas as $cell)
                        <tr>
                            <td style="width: 10%;">{{$cell->id}}</td>
                            <td style="width: 80%;">{{$cell->descricao}}</td>
                            <td style="width: 10%; color: darkslategray">
                                <a href="/tema/view/{{$cell->id}}" style="text-decoration: none;">
                                    <span data-feather="eye"></span>
                                </a>
                                &nbsp;
                                <a href="/tema/edit/{{$cell->id}}" style="text-decoration: none;">
                                    <span data-feather="edit"></span>
                                </a>
                                &nbsp;
                                <a href="/tema/delete/{{$cell->id}}" style="text-decoration: none;">
                                    <span data-feather="trash"></span>
                                </a>
                                &nbsp;
                                @if ($cell->arquivo)
                                    <a href="../storage/{{ str_replace('public/','',$cell->arquivo)}}" style="text-decoration: none;" target="_blank" rel="noopener">
                                        <span data-feather="file"></span>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td>Nenhum tema cadastrado...</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                @endif
            </tbody>
        </table>
        
        <nav aria-label="...">
            <ul class="pagination w-100" style=" font-size: 12px;">
                <li class="page-item"><a class="page-link" href="{{url('tema/consulta?page=1')}}">1</a></li>
                <li class="page-item"><a class="page-link" href="{{url('tema/consulta?page=2')}}">2</a></li>
                <li class="page-item"><a class="page-link" href="{{url('tema/consulta?page=3')}}">3</a></li>
                <li class="page-item"><a class="page-link" href="{{url('tema/consulta?page=4')}}">4</a></li>
                <li class="page-item"><a class="page-link" href="{{url('tema/consulta?page=5')}}">5</a></li>
                <li class="page-item"><a class="page-link" href="{{url('tema/consulta?page=6')}}">6</a></li>
                <li class="page-item"><a class="page-link" href="{{url('tema/consulta?page=7')}}">7</a></li>
                <li class="page-item"><a class="page-link" href="{{url('tema/consulta?page=8')}}">8</a></li>
                <li class="page-item"><a class="page-link" href="{{url('tema/consulta?page=9')}}">9</a></li>
                <li class="page-item"><a class="page-link" href="{{url('tema/consulta?page=10')}}">10</a></li>
            </ul>
        </nav>

        @if(Auth()->user()->grupo == 'admin')

            <form class="form-control w-50 bg-gradient p-2 text-dark bg-opacity-10" action="{{route('tema.import')}}" name="frmImport" enctype="multipart/form-data" method="POST" >

                @csrf
                @method('POST')

                <div class="d-inline-flex ml-0 " style="width: 100%;">
                    <div class="d-inline ">
                        <label style="font-weight: 600; font-size: 14px; margin-left: 5px;" for="arquivo">Selecione um arquivo texto contendo sua lista para importação: </label>
                        <input class="mr-0 form-control"  style="width: 450px; font-size: 12px; height: 30px;" type="file" accept = ".txt" id="arquivo" name="arquivo" aria-placeholder="Selecione um arquivo para importar">
                    </div>
                    <div class="d-inline pt-4 p-3 ">
                        <button style="width: auto; height: 30px; font-size: 11px; font-weight: 600;" class="btn btn-outline-dark" type="submit"> Processar Arquivo </button>
                    </div>
                </div>
            </form>

        @endif

@endsection
