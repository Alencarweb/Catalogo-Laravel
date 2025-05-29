@extends('admin.layouts.admin')

@section('content')
<div class="container w-full mx-auto bg-white shadow p-6 rounded-lg">
    <h2 class="text-2xl font-semibold text-gray-900 mb-4 sm:mb-0">Configurações</h2>

    @if(session('success'))
        <div style="color: green">{{ session('success') }}</div>
    @endif

    <form action="{{ url('/admin/config') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div style="margin-bottom: 20px;">
            <label for="logo">Logo (PNG, JPG):</label><br>
            <input type="file" name="logo" id="logo" accept="image/*"><br>
            @if(!empty($data['logo']))
                <img src="{{ asset($data['logo']) }}" alt="Logo atual" style="max-height: 80px; margin-top: 10px;">
            @endif
        </div>

        <div style="margin-bottom: 20px;">
            <label for="info">Informações:</label><br>
            <textarea name="info" id="info" class="form-control">{{ old('info', $data['info'] ?? '') }}</textarea>
        </div>

        <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded">Salvar</button>
    </form>
</div>
<!-- Editor HTML (Trumbowyg) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/trumbowyg@2.28.0/dist/ui/trumbowyg.min.css">
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/trumbowyg@2.28.0/dist/trumbowyg.min.js"></script>
<script>
    $(function () {
        $('#info').trumbowyg({
            btns: [
                ['viewHTML'],
                ['undo', 'redo'],
                ['formatting'],
                ['strong'],
                ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
                ['removeformat']
            ],
            autogrow: true
        });
    });
</script>
@endsection
