<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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

    public function receberEmail(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email',
            'telefone' => 'required|string|max:30',
            'id_produto' => 'required|integer|exists:products,id',
        ]);

        $product = Product::find($request->id_produto);

        $catalogoLink = url("/catalogo/layout/{$product->id}");

        $enviado = false;
        try {
            $mensagem = "
        <p>Obrigado pelo seu interesse!</p>
        <p>Agradecemos por se cadastrar no site da CPE - Compostos Plásticos e Engenharia e pelo seu interesse em nossos produtos.</p>
        <p>Para acessar o nosso catálogo em PDF, basta clicar no botão abaixo:</p>
        <a href=\"{$catalogoLink}\" target=\"_blank\" style=\"background-color: #444444;color: white;font-size: 18px;padding: 5px 25px;width: max-content;border: none;border-radius: 10px;text-decoration:none;display:inline-block;\">Acessar Catálogo</a>
        ";

        Mail::send([], [], function ($message) use ($request, $mensagem) {
            $message->to($request->email)
                    ->subject('Acesso ao Datasheet CPE')
                    ->setBody($mensagem, 'text/html');
        });
            $enviado = true;
        } catch (\Exception $e) {
            $enviado = false;
        }

        return response()->json(['enviado' => $enviado]);
    }

}
