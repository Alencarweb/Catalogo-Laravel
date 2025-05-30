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
    <?php
      $config = json_decode(file_get_contents(public_path('conf/info.json')), true);
    ?>
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
          @if(!empty($config['logo']))
              <img src="{{ asset($config['logo']) }}" alt="Logo" class="filter invert p-[15px]">
          @endif
          <button @click="sidebarOpen = false" class="text-white lg:hidden">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
        
        <nav class="flex flex-col space-y-3">
          <a href="/admin/" class="flex gap-[10px] items-center hover:text-gray-400 py-2 px-1 rounded hover:bg-gray-700 transition">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-layout-dashboard-icon lucide-layout-dashboard"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
            Dashboard
          </a>
          <a href="/admin/products" class="flex gap-[10px] items-center hover:text-gray-400 py-2 px-1 rounded hover:bg-gray-700 transition">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-package-search-icon lucide-package-search"><path d="M21 10V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l2-1.14"/><path d="m7.5 4.27 9 5.15"/><polyline points="3.29 7 12 12 20.71 7"/><line x1="12" x2="12" y1="22" y2="12"/><circle cx="18.5" cy="15.5" r="2.5"/><path d="M20.27 17.27 22 19"/></svg>
            Produtos</a>
          <a href="/admin/config" class=" flex gap-[10px] items-center hover:text-gray-400 py-2 px-1 rounded hover:bg-gray-700 transition">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-monitor-cog-icon lucide-monitor-cog"><path d="M12 17v4"/><path d="m14.305 7.53.923-.382"/><path d="m15.228 4.852-.923-.383"/><path d="m16.852 3.228-.383-.924"/><path d="m16.852 8.772-.383.923"/><path d="m19.148 3.228.383-.924"/><path d="m19.53 9.696-.382-.924"/><path d="m20.772 4.852.924-.383"/><path d="m20.772 7.148.924.383"/><path d="M22 13v2a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h7"/><path d="M8 21h8"/><circle cx="18" cy="6" r="3"/></svg>
            Configurações</a>
          <a href="/logout" class="flex gap-[10px] items-center hover:text-gray-400 py-2 px-1 rounded hover:bg-gray-700 transition">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-log-out-icon lucide-log-out"><path d="m16 17 5-5-5-5"/><path d="M21 12H9"/><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/></svg>
            Sair</a>
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
