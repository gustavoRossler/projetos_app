@extends('layouts.app')

@section('content')

<div class="col-md-12">

    <h3>Arquitetos</h3>
    <p>
        Cadastrar arquiteto.
    </p>
    <hr>
</div>
<div class="col-md-12">
    @if (count($errors) > 0)
    <div class="alert alert-danger">
        <strong>Sorry!</strong> There were more problems with your HTML input.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif


    <form action="{{ route('users.store') }}" method="post" class="row" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="group_id" value="2">
        <div class="col-md-6">
            <div class="form-group">
                <label for="name" class="mb-0">Nome</label>
                <input type="text" name="name" id="name" class="form-control" 
                    required value="{{ old('name') }}">
                @if ($errors->has('name'))
                    <span class="text-danger">
                        {{ $errors->first('name') }}
                    </span>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="email" class="mb-0">E-mail</label>
                <input type="email" name="email" id="email" class="form-control" 
                    required value="{{ old('email') }}">
                @if ($errors->has('email'))
                    <span class="text-danger">
                        {{ $errors->first('email') }}
                    </span>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="password" class="mb-0">Senha</label>
                <input type="password" name="password" id="password" class="form-control" 
                    required value="{{ old('password') }}">
                @if ($errors->has('password'))
                    <span class="text-danger">
                        {{ $errors->first('password') }}
                    </span>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="password_confirmation" class="mb-0">Confirmação da senha</label>
                <input type="password" name="password_confirmation" id="password_confirmation" 
                    class="form-control" required value="{{ old('password_confirmation') }}">
                @if ($errors->has('password_confirmation'))
                    <span class="text-danger">
                        {{ $errors->first('password_confirmation') }}
                    </span>
                @endif
            </div>
        </div>
        <div class="col-md-12 mt-4 text-center">
            <button type="submit" class="btn btn-secondary">
                <i class="fas fa-plus"></i> Enviar
            </button>
        </div>
    </form>
</div>
@endsection