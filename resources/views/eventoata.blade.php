@extends('layouts.report')

@section('title','DDS - Ata de Presença')

@section('titulo','LOCALFRIO - ATA DE PRESENÇA EM EVENTO')

@section('content')
    <div class="container list-inline-item justify-items-center" style="font-size: 14px;">

        <div class="list-group list-group-horizontal-sm">
            <div class="list-group-item p-4 border-0">
                <h2> Diálogo Diário de Segurança </h2>
            </div>
        </div>

        <div class="row-cols-6">
            <b>Unidade:</b> {{$unidade->descricao}}
        </div>
        <div class="row-cols-6">
            <b>Dia:</b> {{ $evento->dia }}
        </div>
        <div class="row-cols-6">
            <b>Tema:</b> {{$tema->descricao}}
        </div>
        <div class="row-cols-6">
            <b>Turno:</b>
                    @if($evento->turno === 1)
                        Primeiro
                    @elseif($evento->turno === 2)
                        Segundo
                    @else
                        Terceiro
                    @endif
        </div>
        <div class="row-cols-6">
            <b>Área/Setor:</b>
                    @if($evento->area === 'O')
                        Operacional
                    @else
                        Administrativa
                    @endif
        </div>
    </div>
    <hr>

    <table class="table table-bordered mb-5" style="font-family: Arial, Helvetica, sans-serif">
        <thead>
        <tr class="table-primary">
            <th scope="col" style="text-align: left;">#</th>
            <th scope="col" style="text-align: left;">Nome</th>
            <th>&nbsp;</th>
            <th scope="col" style="text-align: left;">Email</th>
        </tr>
        </thead>
        <tbody>
        @foreach($participante as $data)
            <tr>
                <th scope="row">{{ $data->id }}</th>
                <td>{{ $data->nome }}</td>
                <td>&nbsp;</td>
                <td>{{ $data->email }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
