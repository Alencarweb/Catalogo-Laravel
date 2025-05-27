<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogo - @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
  </head>
  <body class="bg-gray-100 text-sm" x-data="{ sidebarOpen: false }">
    <div class="flex min-h-screen relative">
      <!-- Overlay para dispositivos móveis -->
      <div 
        x-show="sidebarOpen" 
        @click="sidebarOpen = false" 
        class="fixed inset-0 z-20 bg-black bg-opacity-50 transition-opacity lg:hidden">
      </div>

      <!-- MENU LATERAL -->
      <aside 
        :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}"
        class="fixed top-0 left-0 z-30 w-64 h-full bg-gray-800 text-white p-4 transform transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:w-60" style="height: 100vh;">
        
        <div class="flex items-center justify-between mb-6">
          <h2 class="text-xl font-bold">Menu</h2>
          <button @click="sidebarOpen = false" class="text-white lg:hidden">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
        
        <nav class="flex flex-col space-y-3">
          <a href="/admin/" class="hover:text-gray-400 py-2 px-1 rounded hover:bg-gray-700 transition">Dashboard</a>
          <a href="/admin/products" class="hover:text-gray-400 py-2 px-1 rounded hover:bg-gray-700 transition">Produtos</a>
          <a href="#" class="hover:text-gray-400 py-2 px-1 rounded hover:bg-gray-700 transition">Relatórios</a>
          <a href="#" class="hover:text-gray-400 py-2 px-1 rounded hover:bg-gray-700 transition">Configurações</a>
          <a href="/logout" class="hover:text-gray-400 py-2 px-1 rounded hover:bg-gray-700 transition">Sair</a>
        </nav>
      </aside>

      <!-- CONTEÚDO PRINCIPAL -->
      <main class="flex-1 p-4 lg:p-6 h-screen overflow-auto">
        <!-- Botão do menu para dispositivos móveis -->
        <div class="lg:hidden mb-4">
          <button @click="sidebarOpen = true" class="p-2 rounded-md bg-gray-200 hover:bg-gray-300">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          </button>
        </div>
        
        @yield('content')
      </main>
    </div>
  </body>
</html>
