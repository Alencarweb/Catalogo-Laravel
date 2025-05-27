<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use PDF; 

class PublicCatalogController extends Controller
{
    public function show($id)
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

    public function generatePdf($id)
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

        $pdf = PDF::loadView('catalogo.ficha_tecnica', compact('product', 'automotive_specifications'));
        
        $pdf->setPaper('a4');
        $pdf->setOptions([
            'defaultFont' => 'Arial',
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true
        ]);
        
        $filename = 'ficha_tecnica_' . $product->code . '.pdf';
        
        return $pdf->download($filename);
    }
}
