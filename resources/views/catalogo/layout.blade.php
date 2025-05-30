<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Produto - CPE</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

  <style>body {font-family: 'Roboto', sans-serif !important;}</style>
</head>
<body class="bg-[#1C242A] text-white font-sans">

  <!-- Header -->
  <header class="flex justify-between items-center px-8 py-4 border-b border-gray-700">
    <img src="/logo.svg" alt="CPE Logo" class="h-8" />
    <nav class="flex items-center gap-6 text-sm">
      <a href="#" class="hover:underline">Sobre</a>
      <a href="#" class="hover:underline">Tecnologias e Mercados</a>
      <a href="#" class="hover:underline">Qualidade</a>
      <a href="#" class="hover:underline">Premiações e certificações</a>
      <a href="#" class="hover:underline">Sustentabilidade</a>
      <a href="#" class="hover:underline">Fale conosco</a>
      <button class="bg-gray-200 text-black text-xs px-2 py-1 rounded">Catálogo Online</button>
    </nav>
  </header>

  <div class="container mx-auto">
   @yield('content')
  </div>
  <!-- Rodapé -->
  <footer class="bg-[#141B20] mt-12 py-8 px-8 text-sm text-gray-400">
    <div class="container mx-auto">
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div>
          <img src="/logo.svg" alt="CPE logo" class="h-6 mb-2" />
          <p>Inovação e versatilidade em compostos plásticos para múltiplos setores industriais.</p>
        </div>
        <div>
          <h3 class="text-white mb-2 font-semibold">Links Rápidos</h3>
          <ul class="space-y-1">
            <li><a href="#" class="hover:underline">Home</a></li>
            <li><a href="#" class="hover:underline">Tecnologias e Mercados</a></li>
            <li><a href="#" class="hover:underline">Produtos e Aplicações</a></li>
            <li><a href="#" class="hover:underline">Sustentabilidade</a></li>
            <li><a href="#" class="hover:underline">Fale Conosco</a></li>
          </ul>
        </div>
        <div>
          <h3 class="text-white mb-2 font-semibold">Contato</h3>
          <p>(11) 2142-2300</p>
          <p>contato@cpe.ind.br</p>
          <p>R. Manoel Pinto de Carvalho, 229<br />Jardim Pereira Leite - SP<br />CEP: 02712-120</p>
        </div>
      </div>
      <div class="mt-6 border-t border-gray-700 pt-4 flex justify-between text-xs">
        <p>© 2025. Todos os direitos reservados.</p>
        <div class="flex gap-4">
          <a href="#">Política de Privacidade</a>
          <a href="#">Termos e Condições</a>
          <a href="#">Política de Cookies</a>
        </div>
      </div>
    </div>
  </footer>

</body>
</html>