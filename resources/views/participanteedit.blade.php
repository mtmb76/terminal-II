@extends('layouts.main')

@section('title','Participantes')

<link href="../css/dashboard.css" rel="stylesheet">

@section('user.name')
    {{auth()->user()->name}}
@endsection

@section('user.unidade')
    {{$unidades}}
@endsection

@section('form.title')
    <nav class="navbar navbar-light bg-light flex-md-nowrap p-0">
      <h4>Edição do Participante # {{$campos->id}} </h4>
    </nav>
@endsection

@section('auth.content')

  <form class="form-control mb-3" style="border: 0px transparent; font-size: 12px;" action="{{route('participante.update')}}" name='frmEdicaoParticipante' method="post">

    @csrf

    <div class="form-group">
        <label for="unidade_id"><b>Unidade:</b></label>
        <input id="unidade_id" class="form-control mb-2 py-0" style="font-size: 12px; width: 150px; text-align: center;" type="text" name="unidade_id" disabled value="{{$unidades}}">

        <label for="cpf"><b>CPF:</b></label>
        <input value="{{$campos->cpf}}" id="cpf" name="cpf" style="font-size: 12px;width: 150px;" class="form-control mb-2 py-0" type="text" maxlength="11" disabled>

        <label for="cracha"><b>Crachá:</b></label>
        <input value="{{$campos->cracha}}" id="cracha" name="cracha" style="font-size: 12px;width: 150px;" class="form-control mb-2 py-0" maxlength="15" type="text" required>

        <label for="nome"><b>Nome:</b></label>
        <input value="{{$campos->nome}}" id="nome" name="nome" style="font-size: 12px;width: 600px;"class="form-control mb-2 py-0 " type="text" required>

        <label for="email"><b>Email:</b></label>
        <input value="{{$campos->email}}" id="email" name="email" style="font-size: 12px;width: 600px;" class="form-control mb-2 py-0" type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$">

        <label for="ativo" class="mb-3"><b>Cadastro ativo ?</b></label>
        <div class="btn-group btn-group-toggle" data-toggle="buttons">
            <label class="btn btn-light">
                <input type="radio" id="ativo" name="ativo" value="1" {{($campos->ativo == 1)?'checked':''}}> Sim
                <input type="radio" id="ativo" name="ativo" value="0" {{($campos->ativo == 0)?'checked':''}}> Não
            </label>
        </div>

        <input name="id" type="hidden" value="{{$campos->id}}">
        <input name="cpf" type="hidden" value="{{$campos->cpf}}">

        <nav class="navbar navbar-light bg-light flex-md-nowrap p-0">
            <ul class="navbar-nav px-0">
                <li class="nav-item text-nowrap">
                    <button class="btn btn-success"  style="width: 100px; height: 30px; font-size: 11px; font-weight: 500;"  type="submit">Salvar</button>
                    <a href="{{route('participante.lista')}}"
                        <button class="btn btn-danger"  style="width: 100px; height: 30px; font-size: 11px; font-weight: 500;"  type="button">Voltar</button>
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

   function TestaCPF() {
        var strCPF = document.frmEdicaoParticipante.cpf.value;
        var Soma;
        var Resto;
        Soma = 0;
    if (strCPF == "00000000000"){
        alert('Cpf inválido!');
        exit;
    }

    for (i=1; i<=9; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (11 - i);
    Resto = (Soma * 10) % 11;

        if ((Resto == 10) || (Resto == 11))  Resto = 0;
        if (Resto != parseInt(strCPF.substring(9, 10)) ){
            alert('Cpf inválido!');
            //document.frmEdicaoParticipante.cpf.focus();
            exit;
        }

    Soma = 0;
        for (i = 1; i <= 10; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (12 - i);
        Resto = (Soma * 10) % 11;

        if ((Resto == 10) || (Resto == 11))  Resto = 0;
        if (Resto != parseInt(strCPF.substring(10, 11) ) ){
            alert('Cpf inválido!');
            //document.frmEdicaoParticipante.cpf.focus();
            exit;
        }

    }

</script>
