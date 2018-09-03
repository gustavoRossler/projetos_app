@extends('layouts.app')

@section('content')

<div class="col-md-12">

    <h3>Projetos</h3>
    <p>
        Criar novo projeto.
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


    <form action="{{ route('projects.store') }}" method="post" class="row" enctype="multipart/form-data">
        @csrf
        <div class="col-md-6">
            <div class="form-group">
                <label for="area" class="mb-0">Área m²</label>
                <input type="text" name="area" id="area" class="form-control text-right numbers_only" 
                    required value="{{ old('area') }}">
                @if ($errors->has('area'))
                    <span class="text-danger">
                        {{ $errors->first('area') }}
                    </span>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="project_architect_price" class="mb-0">Preço do projeto arquitetônico</label>
                <input type="text" name="project_architect_price" id="project_architect_price" 
                    class="form-control text-right money" required value="{{ old('project_architect_price') }}">
                @if ($errors->has('project_architect_price'))
                    <span class="text-danger">
                        {{ $errors->first('project_architect_price') }}
                    </span>
                @endif
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label for="description" class="mb-0">Descrição</label>
                <vue-ckeditor
                    id="ckEditorAddMensagem"
                    name="description"
                    value="{{ old('description') }}"
                    v-bind:config="{
                        toolbar: [
                            [
                                'Bold', 'Undo', 'Redo','NumberedList', 'BulletedList',
                            ]
                        ],
                        height: 200
                    } "
                />
                @if ($errors->has('description'))
                    <span class="text-danger">
                        {{ $errors->first('description') }}
                    </span>
                @endif
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label for="images" class="mb-0">Fotos</label>
                <input type="file" name="images[]" id="images" multiple 
                    class="form-control" required>
                @if ($errors->has('images.*'))
                    <span class="text-danger">
                        Erro: {{ $errors->first('images.*') }}
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