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
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <label for="telefone">Telefone:</label><br>
                <input type="text" name="telefone" id="telefone" class="w-full border px-3 py-1 rounded" value="{{ old('telefone', $data['telefone'] ?? '') }}">
            </div>

            <div>
                <label for="endereco">Endereço:</label><br>
                <input type="text" name="endereco" id="endereco" class="w-full border px-3 py-1 rounded" value="{{ old('endereco', $data['endereco'] ?? '') }}">
            </div>

            <div>
                <label for="email">E-mail:</label><br>
                <input type="email" name="email" id="email" class="w-full border px-3 py-1 rounded" value="{{ old('email', $data['email'] ?? '') }}">
            </div>
        </div>
        <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded">Salvar</button>
    </form>
</div>
@endsection
