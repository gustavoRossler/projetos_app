@extends('layouts.app')

@section('content')

<div class="col-md-12">
    <h3>Projetos</h3>
    @can('architect')
    <p>
        Gerencie os seus projetos.
    </p>
    @elsecan('admin')
    <p>
        Gerencie todos os projetos enviados.
    </p>
    @endcan
    @can('architect')
    <hr>
    <p>
        <a href="{{ route('projects.create') }}" class="btn btn-secondary">
            <i class="fas fa-plus"></i> Criar projeto
        </a>
    </p>
    @endcan

    @if(count($projects))
    <div class="table-responsive">
        <table class="table table-striped">
            <tr>
                @can('admin')
                <th>Arquiteto</th>
                @endcan
                <th>Project</th>
                <th>Área</th>
                <th>Preço do projeto @can('admin')(arquiteto)@endcan</th>
                @can('admin')
                <th>Preço do projeto (engenheiro)</th>
                <th>Preço de construção</th>
                @endcan
                <th>Status</th>
                <th></th>
            </tr>
            @foreach ($projects as $project)
            <tr>
                @can('admin')
                <td>{{ $project->user->name }}</td>
                @endcan
                <td>{{ str_limit($project->description, $limit = 60, $end = '...') }}</td>
                <td>{{ $project->area }}m²</td>
                <td>R$ {{ number_format($project->project_architect_price, 2, ',', '.') }}</td>
                @can('admin')
                <td>R$ {{ number_format($project->project_engineer_price, 2, ',', '.') }}</td>
                <td>R$ {{ number_format($project->construction_price, 2, ',', '.') }}</td>
                @endcan
                <td>{{ ($project->active == 1) ? 'Ativo' : 'Inativo' }}</td>
                <td>
                    <a href="{{ route('projects.edit', $project->id) }}">editar</a>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
    @endif
</div>
	
@endsection