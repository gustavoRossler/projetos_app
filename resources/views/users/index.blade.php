@extends('layouts.app')

@section('content')

<div class="col-md-12">
    <h3>Arquitetos</h3>
    <p>
        Gerencie os arquitetos.
    </p>
    <hr>
    <p>
        <a href="{{ route('users.create') }}" class="btn btn-secondary">
            <i class="fas fa-plus"></i> Cadastrar arquiteto
        </a>
    </p>

    @if(count($users))
    <div class="table-responsive">
        <table class="table table-striped">
            <tr>
                <th>Nome</th>
                <th>E-mail</th>
                <th></th>
            </tr>
            @foreach ($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    <a href="{{ route('users.edit', $user->id) }}">editar</a>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
    @endif
</div>
	
@endsection