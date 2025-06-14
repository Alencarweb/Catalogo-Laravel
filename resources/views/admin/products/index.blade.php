@extends('admin.layouts.admin')

@section('title', 'Produtos')

@section('content')
<div class="py-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-2">
        <h1 class="text-2xl font-semibold text-gray-900 mb-4 sm:mb-0">Produtos</h1>
    </div>

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

    <div 
        x-data="productTable()" 
        x-init="fetchProducts()" 
        class="w-full mx-auto bg-white shadow p-6 rounded-lg"
    >
        <div class="flex flex-col sm:flex-row justify-between items-center mb-4">
            <input 
                x-model="search" 
                @input="filterProducts" 
                type="text" 
                placeholder="Buscar produto..." 
                class="border rounded px-3 py-2 w-full sm:w-64 mb-2 sm:mb-0"
            >
            <button onclick="openCreateProductModal()" class="bg-green-600 text-white px-4 py-2 rounded mb-4">
                Novo Produto
            </button>
        </div>
        <div class="overflow-x-auto shadow-md sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Código</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descrição</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <template x-for="(product, index) in paginatedProducts()" :key="product.id">
                        <tr class="hover:bg-gray-50">
                            <td class="px-2 py-1 whitespace-nowrap text-sm text-gray-500" x-text="(currentPage - 1) * perPage + index + 1"></td>
                            <td class="px-2 py-1 whitespace-nowrap text-sm text-gray-900" x-text="product.code"></td>
                            <td class="px-2 py-1 whitespace-nowrap text-sm text-gray-900" x-text="product.color"></td>
                            <td class="px-2 py-1 text-sm text-gray-900 max-w-xs truncate" x-text="product.description"></td>
                            <td class="px-2 py-1 whitespace-nowrap text-center text-sm font-medium">
                                <div class="flex flex-col sm:flex-row justify-center gap-2">
                                    <a :href="`/admin/products/${product.id}/edit`" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded text-white bg-blue-600 hover:bg-blue-700">
                                        Editar
                                    </a>
                                    <button @click="deleteProduct(product.id)" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded text-white bg-red-600 hover:bg-red-700">
                                        Excluir
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
        <!-- Paginação -->
        <div class="mt-4 flex justify-center items-center gap-2">
            <button @click="prevPage" :disabled="currentPage === 1" class="px-3 py-1 bg-gray-200 rounded" :class="{'opacity-50': currentPage === 1}">&lt;</button>
            <template x-for="page in totalPages()" :key="page">
                <button @click="goToPage(page)" x-text="page" class="px-3 py-1 rounded" :class="{'bg-blue-500 text-white': currentPage === page, 'bg-gray-200': currentPage !== page}"></button>
            </template>
            <button @click="nextPage" :disabled="currentPage === totalPages()" class="px-3 py-1 bg-gray-200 rounded" :class="{'opacity-50': currentPage === totalPages()}">&gt;</button>
        </div>
    </div>
</div>
<div id="createProductModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50 hidden">
    <div class="bg-white p-6 rounded shadow-lg w-full max-w-md">
        <h2 class="text-lg font-bold mb-4">Criar Novo Produto</h2>
        <label class="block mb-2 font-medium">Nome/Código do Produto</label>
        <input type="text" id="newProductName" class="w-full border px-3 py-2 rounded mb-4" placeholder="Digite o código do produto">
        <div class="flex justify-end gap-2">
            <button onclick="closeCreateProductModal()" class="px-4 py-2 rounded bg-gray-300">Cancelar</button>
            <button onclick="createProduct()" class="px-4 py-2 rounded bg-green-600 text-white">Criar</button>
        </div>
    </div>
</div>

<script>
function productTable() {
    return {
        products: [],
        filtered: [],
        search: '',
        currentPage: 1,
        perPage: 15,
        fetchProducts() {
            fetch('api/products')
                .then(res => res.json())
                .then(data => {
                    this.products = data;
                    this.filtered = data;
                });
        },
        filterProducts() {
            const term = this.search.toLowerCase();
            this.filtered = this.products.filter(p =>
                p.code.toLowerCase().includes(term) ||
                p.color.toLowerCase().includes(term) ||
                p.description.toLowerCase().includes(term)
            );
            this.currentPage = 1;
        },
        paginatedProducts() {
            const start = (this.currentPage - 1) * this.perPage;
            return this.filtered.slice(start, start + this.perPage);
        },
        totalPages() {
            return Math.ceil(this.filtered.length / this.perPage) || 1;
        },
        goToPage(page) {
            this.currentPage = page;
        },
        prevPage() {
            if (this.currentPage > 1) this.currentPage--;
        },
        nextPage() {
            if (this.currentPage < this.totalPages()) this.currentPage++;
        },
        deleteProduct(id) {
            if (confirm('Tem certeza que deseja excluir este produto?')) {
                fetch(`/admin/products/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                }).then(() => this.fetchProducts());
            }
        }
    }
}
// add product modal functions
function openCreateProductModal() {
    document.getElementById('createProductModal').classList.remove('hidden');
}
function closeCreateProductModal() {
    document.getElementById('createProductModal').classList.add('hidden');
}
function createProduct() {
    const code = document.getElementById('newProductName').value.trim();
    if (!code) {
        alert('Informe o nome/código do produto.');
        return;
    }
    fetch("{{ route('admin.products.store') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: JSON.stringify({ code })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success && data.id) {
            window.location.href = `/admin/products/${data.id}/edit?success=Produto criado com sucesso!`;
        } else if(data.errors) {
            alert(Object.values(data.errors).join('\n'));
        } else {
            alert('Erro ao criar produto.');
        }
    })
    .catch(() => alert('Erro ao criar produto.'));
}
</script>
@endsection
