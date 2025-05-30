@extends('catalogo.layout')
@section('content')
<!-- Breadcrumb -->
  <div class="text-sm text-gray-400 px-8 py-2">
    Home / Produtos / <span class="text-white">Compostos de Polipropileno</span>
  </div>

<!-- Conteúdo Principal -->
  <main class="px-8 py-6 grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Informações do Produto -->
    <section class="lg:col-span-2">
      <h1 class="font-roboto font-light text-[40px] leading-[120%] mb-6 text-[#E5C97E]">{{ $product->code }}</h1>

      <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-[#29363F] p-4 rounded shadow rounded-[10px]">
          <h2 class="text-[#E5C97E] font-semibold mb-2">Descrição</h2>
          <p class="text-sm">{{ $product->description }}</p>
        </div>
        <div class="bg-[#29363F] p-4 rounded shadow rounded-[10px]">
          <h2 class="text-[#E5C97E] font-semibold mb-2">Aplicações Típicas</h2>
          <p class="text-sm">{{ $product->typical_applications ?? '-' }}</p>
        </div>
        <div class="bg-[#29363F] p-4 rounded shadow rounded-[10px]">
            <h2 class="text-[#E5C97E] font-semibold mb-2">Normas</h2>
            <p class="text-sm">
                @if(count($automotive_specifications) > 0)
                    {{ implode(', ', $automotive_specifications) }}
                @else
                    -
                @endif
            </p>
        </div>
      </div>

      <!-- Detalhes Técnicos -->
      <h2 class="text-xl text-[#E5C97E] font-semibold mb-4">Detalhes Técnicos</h2>
      <table class="w-full text-sm bg-[#2B2D33] rounded overflow-hidden bg-transparent">
        <thead class="text-left">
          <tr>
            <th class="p-2">Propriedades</th>
            <th class="p-2">Método</th>
            <th class="p-2">Unidade</th>
            <th class="p-2">Valores Típicos</th>
          </tr>
        </thead>
        <tbody>
        @foreach ([
        'Físicas' => $product->physicalProperties,
        ] as $group => $properties)
            <tr class="bg-[#29353F]"><td colspan="4" style="font-weight: bold; font-size: 13px;"  class="p-2 bg0-[#29353F]">{{ $group }}</td></tr>
            @forelse ($properties as $property)
                <tr>
                    <td  class="p-2">{{ $property->name }}</td>
                    <td  class="p-2">{{ $property->standard }}</td>
                    <td  class="p-2">{{ $property->unit }}</td>
                    <td  class="p-2">{{ $property->value }}</td>
                </tr>
            @empty
                <tr><td colspan="4">Nenhuma propriedade cadastrada.</td></tr>
            @endforelse
        @endforeach
        </tbody>
      </table>

      <!-- Chamada para Ação -->
      <div class="mt-6 bg-[#29353F] p-4 rounded shadow rounded-[10px] flex justify-between items-center">
        <div>
            <p class="text-[#E5C97E] font-semibold mb-2">Quer conhecer todos os detalhes técnicos deste produto?</p>
            <p class="text-sm mb-2">Baixe agora o nosso Data Sheet completo!</p>
        </div>
        <button class="bg-[#546871] h-[max-content] rounded-[20px]  hover:bg-gray-600 px-4 py-2 rounded text-white">Download Data Sheet</button>
      </div>
    </section>

    <!-- Filtro lateral -->
    <aside>
      <div class="bg-transparent p-4 rounded-lg space-y-6 text-sm">
        <!-- Produto -->
        <div>
          <label class="text-[#E5C97E] font-roboto font-semibold text-[20px] leading-[150%]">Produto</label>
          <input type="text" placeholder="Produto" class="w-full px-3 py-2 rounded text-white bg-[#FFFFFF33]" />
        </div>
        <!-- Tipo de Carga -->
        <div x-data="customRangeCarga()">
            <label class="text-[#E5C97E] font-roboto font-semibold text-[20px] leading-[150%]">Fluidez</label>
            <input
                type="range"
                class="w-full accent-[#6D7F7F]"
                :min="0"
                :max="values.length - 1"
                x-model="selectedIndexCarga"
            />
            <div class="flex justify-between text-white mt-2">
                <span x-text="values[0]"></span>
                <span x-text="values[selectedIndexCarga]"></span>
                <span x-text="values[values.length - 1]"></span>
            </div>
        </div>
        <!-- Resina Base -->
        <div>
          <label class="text-[#E5C97E] font-roboto font-semibold text-[20px] leading-[150%]">Resina Base</label>
          <select class="w-full px-3 py-2 rounded text-white bg-[#FFFFFF33]">
            <option>Resina Base</option>
          </select>
        </div>
        <!-- Fluidez -->
        <div x-data="customRange()">
            <label class="text-[#E5C97E] font-roboto font-semibold text-[20px] leading-[150%]">Fluidez</label>
            <input
                type="range"
                class="w-full accent-[#6D7F7F]"
                :min="0"
                :max="values.length - 1"
                x-model="selectedIndex"
            />
            <div class="flex justify-between text-white mt-2">
                <span x-text="values[0]"></span>
                <span x-text="values[selectedIndex]"></span>
                <span x-text="values[values.length - 1]"></span>
            </div>
        </div>
        <!-- Norma -->
        <div>
          <label class="text-[#cc] font-roboto font-semibold text-[20px] leading-[150%]s">Norma</label>
          <input type="text" placeholder="Norma" class="w-full px-3 py-2 rounded text-white bg-[#FFFFFF33]" />
        </div>

        

        <script>
        function customRange() {
            let values = [1.5, 15, 10, 18, 2.5, 11, 99, 187, 50, 2.7];
            values.sort(function(a, b) { return a - b; }); // Ordena em ordem crescente
            return {
                values: values,
                selectedIndex: 0,
            };
        }
        function customRangeCarga() {
            let values = [0.5, 15, 10, 18, 2.5, 11, 99, 187, 50, 2.7];
            values.sort(function(a, b) { return a - b; }); // Ordena em ordem crescente
            return {
                values: values,
                selectedIndexCarga: 0,
            };
        }
        </script>


      </div>
    </aside>
  </main>

@endsection