<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-100 to-gray-300 min-h-screen flex items-center justify-center">
    <div class="bg-gray-900 px-10 py-12 rounded-3xl shadow-2xl w-full max-w-md flex flex-col items-center gap-4">
        <div class="flex justify-center mb-4">
            <svg class="w-16 h-16 text-blue-50" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <circle cx="12" cy="8" r="4" stroke="currentColor" stroke-width="2" fill="none"/>
                <path stroke="currentColor" stroke-width="2" fill="none" d="M4 20c0-4 4-6 8-6s8 2 8 6"/>
            </svg>
        </div>
        <h2 class="text-3xl font-extrabold text-center text-blue-50 mb-1">Bem-vindo!</h2>
        <p class="text-center text-gray-400 mb-6">Faça login para continuar</p>
        
        @if ($errors->any())
            <div class="w-full bg-red-500 text-white px-4 py-2 rounded-lg mb-4">
                <strong>Erro!</strong> {{ $errors->first() }}
            </div>
        @endif
        
        <form method="POST" action="{{ route('login') }}" class="w-full flex flex-col gap-4">
            @csrf
            
            <div>
                <label class="block text-gray-400 mb-1" for="email">E-mail</label>
                <input class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 transition" 
                       type="email" 
                       name="email" 
                       id="email" 
                       placeholder="Digite seu e-mail" 
                       value="{{ old('email') }}" 
                       required 
                       autofocus>
            </div>
            
            <div>
                <label class="block text-gray-400 mb-1" for="password">Senha</label>
                <input class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 transition" 
                       type="password" 
                       name="password" 
                       id="password" 
                       placeholder="Digite sua senha" 
                       required>
            </div>
            
            <button class="w-full bg-blue-900 text-white py-2 rounded-lg font-semibold hover:bg-blue-700 transition" type="submit">Entrar</button>
            
            <div class="text-center">
                <!-- <a href="#" class="text-blue-600 hover:underline text-sm">Esqueceu a senha?</a> -->
            </div>
        </form>
        
        <div class="mt-4 text-center">
            <!-- <span class="text-gray-500 text-sm">Não tem uma conta?</span> -->
            <!-- <a href="#" class="text-blue-600 hover:underline text-sm font-semibold">Cadastre-se</a> -->
        </div>
    </div>
</body>
</html>
