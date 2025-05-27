<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = json_decode(file_get_contents(database_path('json/product.json')), true);
        // Descomente esta linha para depurar o conteúdo do JSON
        // dd($json);
        
        $product = Product::create([
            'code' => $json['Produto'],
            'color' => $json['Cor'],
            'image_url' => $json['imagem'],
            'description' => $json['Descricao'],
            'observations' => $json['Observacoes'],
        ]);

        $product->typicalApplications()->create([
            'application' => $json['AplicacoesTipicas']
        ]);

        foreach (explode(',', $json['EspecificacoesAutomotivas']) as $spec) {
            $product->automotiveSpecifications()->create([
                'specification' => trim($spec)
            ]);
        }

        foreach ($json['Propriedades'] as $type => $items) {
            // Limitando o tamanho do tipo para evitar truncamento
            $typeValue = substr(ucfirst($type), 0, 10); // Ajuste o número conforme necessário
            
            foreach ($items as $item) {
                $product->properties()->create([
                    'type' => $typeValue,
                    'name' => $item['Propriedade'],
                    'standard' => $item['Norma'] ?? null,
                    'unit' => $item['Unidade'] ?? null,
                    'value' => $item['Valor']
                ]);
            }
        }
    }

}
