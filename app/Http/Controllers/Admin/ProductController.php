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

        $product = Product::create($data);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'id' => $product->id]);
        }

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
            'pdf' => 'nullable|file|mimes:pdf|max:2048',
        ]);
    
        $data = $request->all();
        $data['enabled'] = $request->has('enabled');

        if ($request->hasFile('pdf')) {
            $pdfPath = $request->file('pdf')->store('products/pdfs', 'public');
            $data['pdf_path'] = $pdfPath;
        }

        $product->update($data);
    
        return redirect()->route('admin.products.edit', $product->id)
            ->with('success', 'Produto atualizado com sucesso!');

    }

    public function deletePdf(Product $product)
    {
        if ($product->pdf_path && \Storage::disk('public')->exists($product->pdf_path)) {
            \Storage::disk('public')->delete($product->pdf_path);
        }

        $product->update(['pdf_path' => null]);

        return redirect()->route('admin.products.edit', $product->id)
            ->with('success', 'PDF removido com sucesso!');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Produto deletado com sucesso!');
    }
    public function apiDestroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return response()->json(['success' => true]);
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

    public function updateProperty(Request $request, $productId, $propertyId)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'standard' => 'nullable|string',
            'unit' => 'nullable|string',
            'value' => 'required|string',
        ]);

        $property = \App\Models\Property::where('product_id', $productId)
            ->where('id', $propertyId)
            ->firstOrFail();

        $property->update($validated);

        return response()->json(['success' => true]);
    }
    public function deleteProperty($productId, $propertyId)
    {
        Property::where('product_id', $productId)
                ->where('id', $propertyId)
                ->delete();

        return response()->json(['success' => true]);
    }

}
