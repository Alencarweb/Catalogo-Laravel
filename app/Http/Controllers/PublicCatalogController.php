<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class PublicCatalogController extends Controller
{
    public function index()
    {
        $products = Product::where('enabled', true)
            ->with([
                'physicalProperties',
                'mechanicalProperties',
                'thermalProperties',
                'impactProperties',
                'otherProperties',
                'automotiveSpecifications'
            ])
            ->get();
            
        return response()->json($products);
    }

    public function show_layout($id)
    {
        $product = Product::with([
            'physicalProperties',
            'mechanicalProperties',
            'thermalProperties',
            'impactProperties',
            'otherProperties'
        ])->findOrFail($id);

        if (!$product->enabled) {
            abort(403, 'Produto não habilitado para exibição pública.');
        }

        $automotive_specifications = $product->automotiveSpecifications->pluck('specification')->toArray();

        return view('catalogo.ficha_tecnica', compact('product','automotive_specifications'));
    }
}
