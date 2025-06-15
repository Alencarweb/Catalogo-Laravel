@extends('admin.layouts.admin')

@section('title', 'Editar Produto')

@section('content')
<div class="div mb-3">
    <a href="{{ route('admin.products.index') }}" class="text-2xl font-semibold text-gray-900">Voltar</a>
</div>


<!-- <hr>--------------------------------------------------------------------------------------  -->
<form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">    
@csrf
@method('PUT')
<div class="w-full mx-auto bg-white shadow p-2 md:p-4 rounded-lg">
    <div>
        @if(session('success'))
            <div class="rounded-md bg-green-50 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif
        <div class="flex justify-between">
            <h1 class="text-2xl font-bold mb-4">Editar Produto: {{ $product->code }}</h1>
            <div class="flex items-center gap-[15px]">
                <label class="flex items-center cursor-pointer">
                <!-- Switch -->
                    <div class="relative">
                        <input type="checkbox" name="enabled" value="1"
                            class="sr-only peer"
                            {{ old('enabled', $product->enabled ?? true) ? 'checked' : '' }}>

                        <div class="w-11 h-6 bg-gray-300 rounded-full peer-checked:bg-green-500 transition-colors"></div>
                        <div class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow-md transition-transform peer-checked:translate-x-5"></div>
                    </div>

                    <!-- Label -->
                    <span class="ml-3 text-gray-700">Produto habilitado</span>
                </label>
                
            </div>
        </div>
        <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
            <div>
                <label class="block font-semibold mb-1">Nome</label>
                <input type="text" name="code" class="w-full border px-3 py-1 rounded" value="{{ $product->code }}" />
            </div>
            <div>
                <label class="block font-semibold mb-1">Cor</label>
                <input type="text" placeholder="cor" name="color"  value="{{ $product->color }}" class="border px-2 py-1 rounded w-full mr-2" />
            </div>
            <div>
                <label class="block font-semibold mb-1">Resina</label>
                <input type="text" placeholder="resina" name="resin" value="{{$product->resin }}" class="border px-2 py-1 rounded w-full mr-2" />
            </div>
        </div>
  
        <div class="mt-6 grid grid-cols-1  md:grid-cols-2 gap-6">
            <div>
                <div class="mb-3">
                    <label for="carga" class="form-label">Carga</label>
                    <input type="text" name="carga" id="carga" class="border px-2 py-1 rounded w-full mr-2" value="{{ old('carga', $product->carga ?? '') }}">
                </div>

                <div class="mb-3">
                    <label for="keywords" class="form-label">Palavras-chave</label>
                    <textarea name="keywords" id="keywords" rows="2" class="w-full border rounded px-3 py-2">{{ old('keywords', $product->keywords ?? '') }}</textarea>
                </div>

            </div>
            <div>
                <label class="block font-semibold mb-1">Descrição</label>
                    <textarea
                    name="description"
                    class="w-full border rounded px-3 py-2"
                    rows="2"
                >{{ $product->description }}</textarea>
            </div>
        </div>
    

        <div>
            <!-- Aplicações Típicas -->
            <div>
                <label class="block font-semibold mb-1" >Aplicações Típicas:</label>
                <textarea name="typical_applications" class="w-full border rounded px-3 py-2" rows="2" >{{ $product->typical_applications }}</textarea>
            </div>
            <!-- Especificações Automotivas -->
            <label class="block font-semibold mb-2 mt-4" >Normas:</label>
            <div x-data="autoSpecManager({{ $product->id }})" x-init="fetchSpecs()">
                    <div class="grid grid-cols-2 gap-2 h-[300px] overflow-auto">
                        <template x-for="(spec, index) in allSpecs" :key="index">
                            <label class="w-fit">
                                <input
                                    type="checkbox"
                                    :value="spec"
                                    :checked="selectedSpecs.includes(spec)"
                                    @change="toggle(spec)"
                                    class="mr-1"
                                >
                                <span x-text="spec"></span>
                            </label>
                        </template>
                    </div>

                    <div class="flex mt-4">
                        <input
                            type="text"
                            x-model="newSpec"
                            placeholder="Adicionar especificação"
                            class="border px-2 py-1 rounded w-full mr-2"
                        >
                        <button
                            type="button"
                            @click="addSpecification"
                            class="bg-blue-600 text-white px-4 py-1 rounded"
                        >
                            Salvar
                        </button>
                    </div>
            </div>
        </div>

<script>
function autoSpecManager(productId) {
    return {
        allSpecs: [],
        selectedSpecs: [],
        newSpec: '',

        async fetchSpecs() {
            try {
                const res = await fetch(`/admin/automotive-specifications/${productId}`);
                const data = await res.json();
                this.allSpecs = data.all;
                this.selectedSpecs = data.selected;
            } catch (error) {
                console.error('Erro ao buscar especificações:', error);
            }
        },

        async addSpecification() {
            const spec = this.newSpec.trim();
            if (!spec) return;

            const res = await fetch('/admin/automotive-specifications/toggle', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    product_id: productId,
                    specification: spec
                })
            });

            if (res.ok) {
                this.allSpecs.push(spec);
                this.selectedSpecs.push(spec);
                this.newSpec = '';
            } else {
                alert('Erro ao adicionar.');
            }
        },

        async toggle(spec) {
            const isChecked = this.selectedSpecs.includes(spec);

            const res = await fetch('/admin/automotive-specifications/toggle', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    product_id: productId,
                    specification: spec,
                    checked: !isChecked
                })
            });

            if (res.ok) {
                if (!isChecked) {
                    this.selectedSpecs.push(spec);
                } else {
                    const index = this.selectedSpecs.indexOf(spec);
                    if (index > -1) this.selectedSpecs.splice(index, 1);
                }
            } else {
                alert('Erro ao atualizar especificação.');
            }
        }
    }
}
</script>


<!-- Especificações Automotivas -->






        
    
    </div>

    <!-- Grupos de propriedades -->
    <div class="mt-8">
    <h2 class="font-bold text-lg mb-2">Propriedades Técnicas</h2>

    <div class="space-y-4">

        <!-- Grupo fisicas -->
        <div class="bg-gray-50 border p-4 rounded shadow-sm" 
            x-data="propertyForm({{ $product->id }}, 'Physical')" 
            x-init="init()">

            <div class="flex items-center justify-between mb-2">
                <span class="font-semibold">Físicas</span>
                <button type="button" @click="toggleForm()" class="text-gray-600 text-sm hover:underline"><svg class="w-[15px]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-plus-icon lucide-square-plus"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M8 12h8"/><path d="M12 8v8"/></svg></button>
            </div>

            <div x-show="showForm" class="mb-4">
                <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
                    <div>
                        <label class="block font-semibold mb-1">Propriedade</label>
                        <input type="text" x-model="form.name" class="w-full border px-3 py-1 rounded">
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">Norma</label>
                        <input type="text" x-model="form.standard" class="w-full border px-3 py-1 rounded">
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">Unidade</label>
                        <input type="text" x-model="form.unit" class="w-full border px-3 py-1 rounded">
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">Valor</label>
                        <input type="text" x-model="form.value" class="w-full border px-3 py-1 rounded">
                    </div>
                    <div>
                        <button type="button" @click="save()" class="bg-gray-600 text-white px-4 py-1 mt-5 rounded">Salvar</button>
                    </div>
                </div>
            </div>

            <table class="w-full text-left text-sm">
                <thead>
                <tr>
                    <th class="border-b p-1">Propriedade</th>
                    <th class="border-b p-1">Norma</th>
                    <th class="border-b p-1">Unidade</th>
                    <th class="border-b p-1">Valor</th>
                    <th class="border-b p-1">Ações</th>
                </tr>
                </thead>
                <tbody>
                <template x-for="item in list" :key="item.id">
                    <tr class='hover:bg-[#e7e7e7]'>
                        <td class="p-1" x-text="item.name"></td>
                        <td class="p-1" x-text="item.standard || '-'"></td>
                        <td class="p-1" x-text="item.unit || '-'"></td>
                        <td class="p-1" x-text="item.value"></td>
                        <td class="p-1 text-red-500 flex gap-2">
                            <a class="cursor-pointer" @click="remove(item.id)"><svg class="w-[15px]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash2-icon lucide-trash-2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg></a>
                            <a class="cursor-pointer" @click="edit(item)"><svg class="w-[15px]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-pen-icon lucide-square-pen"><path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"/></svg></a>
                        </td>
                    </tr>
                </template>
                </tbody>
            </table>
        </div>

        <!-- Grupo Mecânicas-->
        <div class="bg-gray-50 border p-4 rounded shadow-sm" 
            x-data="propertyForm({{ $product->id }}, 'Mechanical')" 
            x-init="init()">

            <div class="flex items-center justify-between mb-2">
                <span class="font-semibold">Mecânicas</span>
                <button type="button" @click="toggleForm()" class="text-gray-600 text-sm hover:underline"><svg class="w-[15px]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-plus-icon lucide-square-plus"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M8 12h8"/><path d="M12 8v8"/></svg></button>
            </div>

           
            <div x-show="showForm" class="mb-4">
                <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
                    <div>
                        <label class="block font-semibold mb-1">Propriedade</label>
                        <input type="text" x-model="form.name" class="w-full border px-3 py-1 rounded">
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">Norma</label>
                        <input type="text" x-model="form.standard" class="w-full border px-3 py-1 rounded">
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">Unidade</label>
                        <input type="text" x-model="form.unit" class="w-full border px-3 py-1 rounded">
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">Valor</label>
                        <input type="text" x-model="form.value" class="w-full border px-3 py-1 rounded">
                    </div>
                    <div>
                        <button type="button" @click="save()" class="bg-gray-600 text-white px-4 py-1 mt-5 rounded">Salvar</button>
                    </div>
                </div>
            </div>

            <table class="w-full text-left text-sm">
                <thead>
                <tr>
                    <th class="border-b p-1">Propriedade</th>
                    <th class="border-b p-1">Norma</th>
                    <th class="border-b p-1">Unidade</th>
                    <th class="border-b p-1">Valor</th>
                    <th class="border-b p-1">Ações</th>
                </tr>
                </thead>
                <tbody>
                <template x-for="item in list" :key="item.id">
                    <tr class='hover:bg-[#e7e7e7]'>
                        <td class="p-1" x-text="item.name"></td>
                        <td class="p-1" x-text="item.standard"></td>
                        <td class="p-1" x-text="item.unit"></td>
                        <td class="p-1" x-text="item.value"></td>
                        <td class="p-1 text-red-500 flex gap-2">
                            <a class="cursor-pointer" @click="remove(item.id)"><svg class="w-[15px]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash2-icon lucide-trash-2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg></a>
                            <a class="cursor-pointer" @click="edit(item)"><svg class="w-[15px]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-pen-icon lucide-square-pen"><path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"/></svg></a>
                        </td>
                    </tr>
                </template>
                </tbody>
            </table>
        </div>
       
        <!-- Grupo  Impacto -->
        <div class="bg-gray-50 border p-4 rounded shadow-sm" 
            x-data="propertyForm({{ $product->id }}, 'Impact')" 
            x-init="init()">

            <div class="flex items-center justify-between mb-2">
                <span class="font-semibold">Impacto</span>
                <button type="button" @click="toggleForm()" class="text-gray-600 text-sm hover:underline"><svg class="w-[15px]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-plus-icon lucide-square-plus"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M8 12h8"/><path d="M12 8v8"/></svg></button>
            </div>

           
            <div x-show="showForm" class="mb-4">
                <div class="grid grid-cols-grid-cols-1 md:grid-cols-5 gap-6">
                    <div>
                        <label class="block font-semibold mb-1">Propriedade</label>
                        <input type="text" x-model="form.name" class="w-full border px-3 py-1 rounded">
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">Norma</label>
                        <input type="text" x-model="form.standard" class="w-full border px-3 py-1 rounded">
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">Unidade</label>
                        <input type="text" x-model="form.unit" class="w-full border px-3 py-1 rounded">
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">Valor</label>
                        <input type="text" x-model="form.value" class="w-full border px-3 py-1 rounded">
                    </div>
                    <div>
                        <button type="button" @click="save()" class="bg-gray-600 text-white px-4 py-1 mt-5 rounded">Salvar</button>
                    </div>
                </div>
            </div>

            <table class="w-full text-left text-sm">
                <thead>
                <tr>
                    <th class="border-b p-1">Propriedade</th>
                    <th class="border-b p-1">Norma</th>
                    <th class="border-b p-1">Unidade</th>
                    <th class="border-b p-1">Valor</th>
                    <th class="border-b p-1">Ações</th>
                </tr>
                </thead>
                <tbody>
                <template x-for="item in list" :key="item.id">
                    <tr class='hover:bg-[#e7e7e7]'>
                        <td class="p-1" x-text="item.name"></td>
                        <td class="p-1" x-text="item.standard"></td>
                        <td class="p-1" x-text="item.unit"></td>
                        <td class="p-1" x-text="item.value"></td>
                        <td class="p-1 text-red-500 flex gap-2">
                            <a class="cursor-pointer" @click="remove(item.id)"><svg class="w-[15px]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash2-icon lucide-trash-2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg></a>
                            <a class="cursor-pointer" @click="edit(item)"><svg class="w-[15px]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-pen-icon lucide-square-pen"><path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"/></svg></a>
                        </td>
                    </tr>
                </template>
                </tbody>
            </table>
        </div>

        <!-- Grupo Térmicas-->
        <div class="bg-gray-50 border p-4 rounded shadow-sm" 
            x-data="propertyForm({{ $product->id }}, 'Thermal')" 
            x-init="init()">

            <div class="flex items-center justify-between mb-2">
                <span class="font-semibold">Térmicas</span>
                <button type="button" @click="toggleForm()" class="text-gray-600 text-sm hover:underline"><svg class="w-[15px]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-plus-icon lucide-square-plus"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M8 12h8"/><path d="M12 8v8"/></svg></button>
            </div>

           
            <div x-show="showForm" class="mb-4">
                <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
                    <div>
                        <label class="block font-semibold mb-1">Propriedade</label>
                        <input type="text" x-model="form.name" class="w-full border px-3 py-1 rounded">
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">Norma</label>
                        <input type="text" x-model="form.standard" class="w-full border px-3 py-1 rounded">
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">Unidade</label>
                        <input type="text" x-model="form.unit" class="w-full border px-3 py-1 rounded">
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">Valor</label>
                        <input type="text" x-model="form.value" class="w-full border px-3 py-1 rounded">
                    </div>
                    <div>
                        <button type="button" @click="save()" class="bg-gray-600 text-white px-4 py-1 mt-5 rounded">Salvar</button>
                    </div>
                </div>
            </div>

            <table class="w-full text-left text-sm">
                <thead>
                <tr>
                    <th class="border-b p-1">Propriedade</th>
                    <th class="border-b p-1">Norma</th>
                    <th class="border-b p-1">Unidade</th>
                    <th class="border-b p-1">Valor</th>
                    <th class="border-b p-1">Ações</th>
                </tr>
                </thead>
                <tbody>
                <template x-for="item in list" :key="item.id">
                    <tr class='hover:bg-[#e7e7e7]'>
                        <td class="p-1" x-text="item.name"></td>
                        <td class="p-1" x-text="item.standard"></td>
                        <td class="p-1" x-text="item.unit"></td>
                        <td class="p-1" x-text="item.value"></td>
                        <td class="p-1 text-red-500 flex gap-2">
                            <a class="cursor-pointer" @click="remove(item.id)"><svg class="w-[15px]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash2-icon lucide-trash-2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg></a>
                            <a class="cursor-pointer" @click="edit(item)"><svg class="w-[15px]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-pen-icon lucide-square-pen"><path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"/></svg></a>
                        </td>
                    </tr>
                </template>
                </tbody>
            </table>
        </div>


        <!-- Grupo outros-->
        <div class="bg-gray-50 border p-4 rounded shadow-sm" 
            x-data="propertyForm({{ $product->id }}, 'Other')" 
            x-init="init()">

            <div class="flex items-center justify-between mb-2">
                <span class="font-semibold">Outros</span>
                <button type="button" @click="toggleForm()" class="text-gray-600 text-sm hover:underline"><svg class="w-[15px]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-plus-icon lucide-square-plus"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M8 12h8"/><path d="M12 8v8"/></svg></button>
            </div>

           
            <div x-show="showForm" class="mb-4">
                <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
                    <div>
                        <label class="block font-semibold mb-1">Propriedade</label>
                        <input type="text" x-model="form.name" class="w-full border px-3 py-1 rounded">
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">Norma</label>
                        <input type="text" x-model="form.standard" class="w-full border px-3 py-1 rounded">
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">Unidade</label>
                        <input type="text" x-model="form.unit" class="w-full border px-3 py-1 rounded">
                    </div>
                    <div>
                        <label class="block font-semibold mb-1">Valor</label>
                        <input type="text" x-model="form.value" class="w-full border px-3 py-1 rounded">
                    </div>
                    <div>
                        <button type="button" @click="save()" class="bg-gray-600 text-white px-4 py-1 mt-5 rounded">Salvar</button>
                    </div>
                </div>
            </div>

            <table class="w-full text-left text-sm">
                <thead>
                <tr>
                    <th class="border-b p-1">Propriedade</th>
                    <th class="border-b p-1">Norma</th>
                    <th class="border-b p-1">Unidade</th>
                    <th class="border-b p-1">Valor</th>
                    <th class="border-b p-1">Ações</th>
                </tr>
                </thead>
                <tbody>
                <template x-for="item in list" :key="item.id">
                    <tr class='hover:bg-[#e7e7e7]'>
                        <td class="p-1" x-text="item.name"></td>
                        <td class="p-1" x-text="item.standard"></td>
                        <td class="p-1" x-text="item.unit"></td>
                        <td class="p-1" x-text="item.value"></td>
                         <td class="p-1 text-red-500 flex gap-2">
                            <a class="cursor-pointer" @click="remove(item.id)"><svg class="w-[15px]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash2-icon lucide-trash-2"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg></a>
                            <a class="cursor-pointer" @click="edit(item)"><svg class="w-[15px]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-square-pen-icon lucide-square-pen"><path d="M12 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.375 2.625a1 1 0 0 1 3 3l-9.013 9.014a2 2 0 0 1-.853.505l-2.873.84a.5.5 0 0 1-.62-.62l.84-2.873a2 2 0 0 1 .506-.852z"/></svg></a>
                        </td>
                    </tr>
                </template>
                </tbody>
            </table>
        </div>

        <!-- Você pode repetir esse bloco para: Mecânicas, Impacto, Térmicas, Outros -->
        </div>
        </div>

    <!-- Observação -->
    <div class="mt-6">
    <label class="block font-semibold mb-1">Observação:</label>
    <textarea
        name="observations"
        class="w-full border rounded px-3 py-2"
        rows="6"
    >{{ $product->observations }}</textarea>
    </div>

    <div class="mt-6 text-right">
        <div class="w-full">
            @if($product->pdf_path)
              
                <div class="form-group mt-2">
                    <label for="pdf" class="block text-sm font-medium text-gray-700 mb-1">Anexe novo PDF para alterar</label>
                    <input type="file" name="pdf" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" accept="application/pdf">
                </div>
            @else
                <span class="text-gray-500"></span>
                    <a target="_blank" href="{{ url('catalogo/layout/' . $product->id) }}" class="bg-[#1f2937] w-full inline-flex justify-center items-center px-4 py-2 text-white text-sm font-medium rounded hover:bg-blue-700 transition-colors mb-2 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-file-text-icon lucide-file-text"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M10 9H8"/><path d="M16 13H8"/><path d="M16 17H8"/></svg>
                    PDF padrão do sistema
                    </a>
                <div class="form-group mt-2">
                    <label for="pdf" class="block text-sm font-medium text-gray-700 mb-1">Anexe o PDF customizado</label>
                    <input type="file" name="pdf" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none" accept="application/pdf">
                </div>
            @endif
            
        </div>   
        <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded mt-4">
            Salvar Material
        </button>
    </div>
</div>
</form>

@if($product->pdf_path)
<div class="w-full mx-auto bg-white shadow p-6 rounded-lg mt-2 gap-4 flex justify-center">
    <div>
        <form action="{{ route('admin.products.deletePdf', $product->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir o PDF?')">
            @csrf
            @method('DELETE')
            <button type="submit"
                class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded hover:bg-red-700 transition-colors">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M3 6h18"/>
                    <path d="M8 6v12a2 2 0 0 0 2 2h4a2 2 0 0 0 2-2V6"/>
                    <path d="M10 11v6"/>
                    <path d="M14 11v6"/>
                </svg>
                Excluir PDF customizado
            </button>
        </form>
    </div>
    <div>
        <a href="{{ asset('storage/' . $product->pdf_path) }}" target="_blank"
        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded hover:bg-blue-700 transition-colors mb-2">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/>
                <path d="M14 2v4a2 2 0 0 0 2 2h4"/>
                <path d="M10 9H8"/>
                <path d="M16 13H8"/>
                <path d="M16 17H8"/>
            </svg>
            Ver PDF enexado customizado
        </a>
    </div>
</div>
@endif

<script>
    function deletePdf(productId) {
        if (!confirm('Tem certeza que deseja excluir o PDF?')) return;

        fetch(`/admin/products/${productId}/delete-pdf`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (response.ok) {
                location.reload(); // Recarrega a página para atualizar a view
            } else {
                alert('Erro ao remover PDF.');
            }
        })
        .catch(() => alert('Erro ao remover PDF.'));
    }
    
    function propertyForm(productId, type) {
        return {
            list: [],
            form: {
                name: '',
                standard: '',
                unit: '',
                value: ''
            },
            showForm: false,

            init() {
                this.load();
            },

            toggleForm() {
                this.showForm = !this.showForm;
            },

            load() {
                fetch(`/admin/products/${productId}/properties/${type}`)
                    .then(res => res.json())
                    .then(data => {
                        console.log(`Propriedades ${type}:`, data);
                        this.list = data;
                    })
                    .catch(error => console.error('Erro ao carregar propriedades:', error));
            },

            save() {
                if (this.form.id) {
                    // Editar existente
                    fetch(`/admin/products/${productId}/properties/${this.form.id}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(this.form)
                    })
                    .then(() => {
                        this.form = { name: '', standard: '', unit: '', value: '', id: null };
                        this.load();
                    });
                } else {
                    // Criar novo
                    fetch(`/admin/products/${productId}/properties/${type}/`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(this.form)
                    })
                    .then(() => {
                        this.form = { name: '', standard: '', unit: '', value: '', id: null };
                        this.load();
                    });
                }
            },

            edit(item) {
                this.form = { ...item };
                this.showForm = true;
            },

            remove(id) {
                if (!confirm('Tem certeza que deseja excluir esta propriedade?')) return;

                fetch(`/admin/products/${productId}/properties/${id}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                })
                .then(() => this.load())
                .catch(error => console.error('Erro ao excluir propriedade:', error));
            }
        }
    }
</script>


@endsection
