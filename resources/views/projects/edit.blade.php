@extends('layouts.app')

@section('content')

<div class="col-md-12">

    <h3>Projetos</h3>
    <p>
        Editar projeto.
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

    @can('architect')
    <form action="{{ route('projects.update', $project->id) }}" method="post" class="row" 
        enctype="multipart/form-data" id="edit_project">
        @csrf
        <input type="hidden" name="_method" value="put">
        <div class="col-md-6">
            <div class="form-group">
                <label for="area" class="mb-0">Área m²</label>
                <input type="text" name="area" id="area" class="form-control text-right numbers_only" 
                    required value="{{ old('area') ?? $project->area }}">
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
                    class="form-control text-right money" required 
                    value="{{ old('project_architect_price') ?? number_format($project->project_architect_price, 2, ',', '.') }}">
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
                    value="{{ old('description') ?? $project->description }}"
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
                    class="form-control">
                @if ($errors->has('images.*'))
                    <span class="text-danger">
                        Erro: {{ $errors->first('images.*') }}
                    </span>
                @endif
            </div>
        </div>
        <div class="col-md-12 mt-4">
            <p>Imagens enviadas</p>
        </div>
        @foreach ($project->images as $image)
        <div class="col-md-4 border border-primary">
            <img src="{{ url('/') }}/files/{{ $image->file }}" style="width:100%;" 
                class="border-1">
            <p class="mt-3">
                <input type="radio" name="main_image" value="{{ $image->id }}" 
                    onclick="$('.warning-message').show();" 
                    {{ ($image->main) ? 'checked' : '' }}> principal
                <a href="javascript:;" onclick="deleteImage({{ $image->id }}, $(this))" 
                    class="btn btn-danger btn-sm float-right">excluir</a>
            </p>
        </div>
        @endforeach

        <div class="col-md-12 mt-2 text-danger warning-message" style="display:none;">
            <p>É necessário clicar em salvar, para confirmar as alterações.</p>
        </div>

        <div class="col-md-12 mt-4 text-center">
            <button type="submit" class="btn btn-secondary">
                <i class="fas fa-plus"></i> Salvar
            </button>
        </div>
    </form>
    @endcan

    @can('admin')
    <form action="{{ route('projects.update', $project->id) }}" method="post" class="row" 
        enctype="multipart/form-data" id="edit_project">
        @csrf
        <input type="hidden" name="_method" value="put">
        <div class="col-md-6">
            <div class="form-group">
                <label for="area" class="mb-0">Área m²</label>
                <input type="text" name="area" id="area" class="form-control text-right numbers_only" 
                    required value="{{ old('area') ?? $project->area }}" readonly>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="project_architect_price" class="mb-0">Preço do projeto arquitetônico</label>
                <input type="text" name="project_architect_price" id="project_architect_price" 
                    class="form-control text-right money" required  readonly 
                    value="{{ old('project_architect_price') ?? number_format($project->project_architect_price, 2, ',', '.') }}">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="project_engineer_price" class="mb-0">Preço do projeto de engenharia</label>
                <input type="text" name="project_engineer_price" id="project_engineer_price" 
                    class="form-control text-right money" 
                    required value="{{ old('project_engineer_price') ?? number_format($project->project_engineer_price, 2, ',', '.') }}">
                @if ($errors->has('project_engineer_price'))
                    <span class="text-danger">
                        {{ $errors->first('project_engineer_price') }}
                    </span>
                @endif
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="construction_price" class="mb-0">Preço de construção</label>
                <input type="text" name="construction_price" id="construction_price" 
                    class="form-control text-right money" 
                    required value="{{ old('construction_price') ?? number_format($project->construction_price, 2, ',', '.') }}">
                @if ($errors->has('construction_price'))
                    <span class="text-danger">
                        {{ $errors->first('construction_price') }}
                    </span>
                @endif
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label for="description" class="mb-0">Descrição</label>
                <textarea name="description" id="description" class="form-control" readonly 
                    required rows="10">{{ old('description') ?? $project->description }}</textarea>
            </div>
        </div>
        <div class="col-md-12">
            <p>
                <input type="checkbox" name="active" id="active" value="1" 
                    {{ ($project->active) ? 'checked' : '' }}> 
                    Ativo (visível no site para os usuários)
            </p>
        </div>
        <div class="col-md-12 mt-4">
            <p>Imagens enviadas</p>
        </div>
        @foreach ($project->images as $image)
        <div class="col-md-4 border border-primary">
            <img src="{{ url('/') }}/files/{{ $image->file }}" style="width:100%;" 
                class="border-1">
        </div>
        @endforeach

        <div class="col-md-12 mt-4 text-center">
            <button type="submit" class="btn btn-secondary">
                <i class="fas fa-plus"></i> Salvar
            </button>
        </div>
    </form>
    @endcan

</div>
@endsection