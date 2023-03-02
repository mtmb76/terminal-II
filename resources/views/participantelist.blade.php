@extends('layouts.main')

@section('title','Participantes')

@section('user.name')
    {{auth()->user()->name}}
@endsection

@section('user.unidade')
    {{$unidades}}
@endsection

@section('form.title')

    <nav class="navbar navbar-light bg-light flex-md-nowrap p-0">
      <h4>Listagem de Participantes</h4>
    </nav>

@endsection

@section('auth.content')

        <form class="form-control" style="border: 0px transparent;" action="{{route('participante.consulta')}}" name="frmParticipante/consulta" method="GET">

            @csrf

            @method('GET')

            <label style=" font-size: 12px;" for="cracha"><b>Pesquisa pelo número do crachá:</b></label>
            <input id="cracha" name="cracha" style="width: 200px; font-size: 12px;" class="form-control form-control-light p-1 mb-2" type="text" placeholder="Pesquise aqui pelo cracha" aria-label="Pesquise aqui pelo cracha">

            <label style=" font-size: 12px;" for="nome"><b>Pesquisa pelo nome do participante:</b></label>
            <input id="nome" name="nome" style="width: 600px; font-size: 12px;" class="form-control form-control-light p-1" type="text" placeholder="Pesquise aqui pelo nome" aria-label="Pesquise aqui pelo nome">

            <ul class="navbar-nav mt-3 mb-3" style="margin-left: 0px;">
                <li class="nav-item text-nowrap">
                    <button style="width: 100px; height: 30px; font-size: 11px; font-weight: 500;" class="btn btn-info" type="submit">Pesquisar</button>
                    <a href="{{route('participante.lista')}}"
                        <button style="width: 100px; height: 30px; font-size: 11px; font-weight: 500;"  class="btn btn-warning" type="button">Atualizar</button>
                    </a>
                    <a href="{{route('participante.novo')}}"
                        <button style="width: 100px; height: 30px; font-size: 11px; font-weight: 500;"  class="btn btn-success" type="button">Novo</button>
                    </a>
                </li>
            </ul>

        </form>

        <table class="table table-striped table-hover table-sm">
            <thead class="thead-dark">
                <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th>Crachá</th>
                    <th>E-mail</th>
                    <th>Ativo</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @if(! empty($participantes) && $participantes->count())
                    @foreach ($participantes as $cell)
                        <tr>
                            <td style="width: 5%;">{{$cell->id}}</td>
                            <td style="width: 50%;">{{$cell->nome}}</td>
                            <td style="width: 10%;">{{$cell->cracha}}</td>
                            <td style="width: 20%;">{{$cell->email}}</td>
                            <td style="width: 5%;">{{ ($cell->ativo =='0')?'Não':'Sim'; }}</td>

                            <td style="width: 10%; color: darkslategray">
                                <a href="/participante/view/{{$cell->id}}" style="text-decoration: none;">
                                    <span data-feather="eye"></span>
                                </a>
                                &nbsp;
                                <a href="/participante/edit/{{$cell->id}}" style="text-decoration: none;">
                                    <span data-feather="edit"></span>
                                </a>
                                &nbsp;
                                <a href="/participante/delete/{{$cell->id}}" style="text-decoration: none;">
                                    <span data-feather="trash"></span>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td>Nenhum participante cadastrado...</td>
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
            <li class="page-item"><a class="page-link" href="{{url('participante/consulta?page=1')}}">1</a></li>
            <li class="page-item"><a class="page-link" href="{{url('participante/consulta?page=2')}}">2</a></li>
            <li class="page-item"><a class="page-link" href="{{url('participante/consulta?page=3')}}">3</a></li>
            <li class="page-item"><a class="page-link" href="{{url('participante/consulta?page=4')}}">4</a></li>
            <li class="page-item"><a class="page-link" href="{{url('participante/consulta?page=5')}}">5</a></li>
            <li class="page-item"><a class="page-link" href="{{url('participante/consulta?page=6')}}">6</a></li>
            <li class="page-item"><a class="page-link" href="{{url('participante/consulta?page=7')}}">7</a></li>
            <li class="page-item"><a class="page-link" href="{{url('participante/consulta?page=8')}}">8</a></li>
            <li class="page-item"><a class="page-link" href="{{url('participante/consulta?page=9')}}">9</a></li>
            <li class="page-item"><a class="page-link" href="{{url('participante/consulta?page=10')}}">10</a></li>
        </ul>
        </nav>

@endsection
