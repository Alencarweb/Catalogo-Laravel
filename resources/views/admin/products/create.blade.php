@extends('admin.layouts.admin')

@section('title', 'Criar Produto')

@section('content')
<a href="{{ route('admin.products.index') }}" class="btn btn-secondary mb-3">Voltar</a>

<form action="{{ route('admin.products.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label class="form-label">Código do Produto</label>
        <input type="text" name="code" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Cor</label>
        <input type="text" name="color" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label">URL da Imagem</label>
        <input type="url" name="image_url" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label">Descrição</label>
        <textarea name="description" class="form-control" rows="4"></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Observações</label>
        <textarea name="observations" class="form-control" rows="4"></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Salvar</button>
</form>
@endsection
