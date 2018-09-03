@extends('layouts.app')

@section('content')

<div class="col-md-12">
    <h3>Detalhes do projeto</h3>
    {!! $project->description !!}
    <p class="">
        <b>Área:</b> {{ $project->area }}m²
    </p>
    <p class="">
        <b>Valor:</b> R$ {{ number_format($project->project_final_price, 2, ',', '.') }}
    </p>
    <hr>
</div>
<div class="col-md-6">
    @foreach ($project->images as $image)
    <div class="col-md-4 border border-primary">
        <img src="{{ url('/') }}/files/{{ $image->file }}" style="width:100%;">
    </div>
    @endforeach

    <div class="row mt-5">
        <div class="col-md-6 mt-5 text-center">
            <b>Arquiteto:</b> {{ $project->user->name }}
            <br>
            <img src="{{ url('/') }}/files/{{ $project->user->logo }}" alt="Logo do arquiteto" width="100">
        </div>
        <div class="col-md-6 mt-5 text-center">
            <b>Engenheiro:</b> {{ $engineer->name }}
            <br>
            <img src="{{ url('/') }}/files/{{ $engineer->logo }}" alt="Logo do engenheiro" width="100">
        </div>
    </div>
</div>
<div class="col-md-6">
    <form action="" method="post">
        @csrf
        <input type="hidden" name="project_id" value="{{ $project->id }}">
        <p>
            Está interessado? mande uma mensagem que entramos em contato com você.
        </p>
        <div class="form-group">
            <label for="name" class="mb-0">Nome</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="email" class="mb-0">E-mail</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="email" class="mb-0">Mensagem</label>
            <textarea name="email" id="email" class="form-control" rows="3"></textarea>
        </div>
        <p class="text-right">
            <button type="submit" class="btn btn-secondary">Enviar</button>
        </p>
    </form>
</div>

@endsection