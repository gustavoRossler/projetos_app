@extends('layouts.app')

@section('content')

@foreach ($projects as $project)
<div class="col-md-4 mb-3">
    <div class="card">
        <img class="card-img-top" src="{{ url('/') }}/files/{{ $project->images[0]->file }}" 
            height="150">
        <hr>
        <div class="card-body pt-1 pb-2 pl-4 pr-4">
            <p class="card-text">{{ str_limit(html_entity_decode(strip_tags($project->description)), $limit = 100, $end = '...') }}</p>
            <p class="card-text">
                <span class="float-left">
                    <b>Área:</b> {{ $project->area }}m²
                </span>
                <span class="float-right">
                    <b>Valor:</b> R$ {{ number_format($project->project_final_price, 2, ',', '.') }}
                </span>
            </p>
        </div>
        <div class="card-body p-0 text-center">
            <a href="{{ route('projects.show', $project->id) }}" 
                class="btn btn-default">ver mais</a>
        </div>
    </div>
</div>
@endforeach

@endsection