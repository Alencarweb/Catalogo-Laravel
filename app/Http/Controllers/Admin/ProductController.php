<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Property;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:255|unique:products,code',
            'color' => 'nullable|string|max:255',
            'image_url' => 'nullable|url',
            'resin' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'enabled' => 'nullable',
            'observations' => 'nullable|string',
        ]);
    
        $data = $request->all();
        $data['enabled'] = $request->has('enabled'); 
    
        Product::create($data);
    
        return redirect()->route('admin.products.index')
            ->with('success', 'Produto criado com sucesso!');
    }

    public function edit(Product $product)
    {
        $specifications = $product->automotiveSpecifications; 
        return view('admin.products.edit', compact('product', 'specifications'));
    }
    
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'code' => 'required|string|max:255|unique:products,code,' . $product->id,
            'color' => 'nullable|string|max:255',
            'image_url' => 'nullable|url',
            'resin' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'typical_applications' => 'nullable|string',
            'enabled' => 'nullable',
            'observations' => 'nullable|string',
            'carga' => 'nullable|string',
            'keywords' => 'nullable|string',
        ]);
    
        $data = $request->all();
        $data['enabled'] = $request->has('enabled');
    
        $product->update($data);
    
        return redirect()->route('admin.products.edit', $product->id)
            ->with('success', 'Produto atualizado com sucesso!');

    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Produto deletado com sucesso!');
    }

    public function listProperties($productId, $type)
    {
        return Property::where('product_id', $productId)
                    ->where('type', $type)
                    ->get();
    }

    public function storeProperty(Request $request, $productId, $type)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'standard' => 'nullable|string',
            'unit' => 'nullable|string',
            'value' => 'required|string',
        ]);

        $validated['product_id'] = $productId;
        $validated['type'] = $type;

        return Property::create($validated);
    }

    public function deleteProperty($productId, $propertyId)
    {
        Property::where('product_id', $productId)
                ->where('id', $propertyId)
                ->delete();

        return response()->json(['success' => true]);
    }

}
