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
      <h4>Cadastro de Participantes</h4>
    </nav>
@endsection

@section('auth.content')

  <form class="form-control" style="border: 0px transparent; font-size: 12px;" action="{{route('participante.add')}}" method="post">

    @csrf

    <div class="form-group">
        <label for="area"><b>Unidade:</b></label>
        <input id="unidade_id" class="form-control mb-2 py-0" style="font-size: 12px;width: 150px; text-align: center;" type="text" name="dstema" disabled value="{{$unidades}}">

        <label for="cpf"><b>CPF:</b></label>
        <input id="cpf" name="cpf" style="font-size: 12px;width: 150px; height: 30px;" class="form-control mb-2 py-0" type="text" maxlength="11" required>

        <label for="cracha"><b>Crachá:</b></label>
        <input id="cracha" name="cracha" style="font-size: 12px;width: 150px; height: 30px;" class="form-control mb-2 py-0" maxlength="15" type="text" required>

        <label for="nome"><b>Nome:</b></label>
        <input id="nome" name="nome" style="font-size: 12px;width: 600px; height: 30px;"class="form-control mb-2 py-0 " type="text" required>

        <label for="email"><b>Email:</b></label>
        <input id="email" name="email" style="font-size: 12px;width: 600px; height: 30px;" class="form-control mb-2 py-0" type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$">

        <label for="ativo" class="mb-3"><b>Cadastro ativo ?</b></label>
        <div class="btn-group btn-group-toggle" data-toggle="buttons">
            <label class="btn btn-light">
                <input type="radio" id="ativo" name="ativo" value="1" checked > Sim
                <input type="radio" id="ativo" name="ativo" value="0" > Não
            </label>
        </div>

        <nav class="navbar navbar-light bg-light flex-md-nowrap p-0">
            <ul class="navbar-nav px-0">
                <li class="nav-item text-nowrap">
                    <button class="btn btn-success" style="width: 100px; height: 30px; font-size: 11px; font-weight: 500;"  type="submit">Salvar</button>
                    <a href="{{route('participante.lista')}}"
                        <button class="btn btn-danger" style="width: 100px; height: 30px; font-size: 11px; font-weight: 500;"  type="button">Voltar</button>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

  </form>

@endsection

<script>
    function mascara(i){

        var v = i.value;

        if(isNaN(v[v.length-1])){ // impede entrar outro caractere que não seja número
            i.value = v.substring(0, v.length-1);
            return;
        }

        i.setAttribute("maxlength", "14");
        if (v.length == 3 || v.length == 7) i.value += ".";
        if (v.length == 11) i.value += "-";

    }

    function TestaCPF(strCPF) {
        var Soma;
        var Resto;
        Soma = 0;
        if (strCPF == "00000000000") return false;

        for (i=1; i<=9; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (11 - i);
        Resto = (Soma * 10) % 11;

            if ((Resto == 10) || (Resto == 11))  Resto = 0;
            if (Resto != parseInt(strCPF.substring(9, 10)) ) return false;

        Soma = 0;
            for (i = 1; i <= 10; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (12 - i);
            Resto = (Soma * 10) % 11;

            if ((Resto == 10) || (Resto == 11))  Resto = 0;
            if (Resto != parseInt(strCPF.substring(10, 11) ) ) return false;
            return true;
    }
</script>
