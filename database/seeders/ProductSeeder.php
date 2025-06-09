<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Property;
use App\Models\AutomotiveSpecification;

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

        $product = Product::create([
            'code' => $json['Produto'],
            'color' => $json['Cor'],
            'description' => $json['Descricao'],
            'observations' => $json['Observacoes'],
            'keywords' => $json['keywords'] ?? null,
            'resin' => $json['resin'] ?? null,
            'typical_applications' => $json['AplicacoesTipicas'] ?? null,
            'image_url' => $json['imagem'] ?? null,
            'carga' => $json['carga'] ?? null,
        ]);

        // Especificações automotivas (relacionamento)
        if (!empty($json['EspecificacoesAutomotivas'])) {
            $specs = array_map('trim', explode(',', $json['EspecificacoesAutomotivas']));
            foreach ($specs as $spec) {
                $product->automotiveSpecifications()->create([
                    'specification' => $spec,
                ]);
            }
        }

        // Propriedades técnicas (relacionamento)
        foreach ($json['Propriedades'] as $group => $properties) {
            foreach ($properties as $property) {
                Property::firstOrCreate([
                    'product_id' => $product->id,
                    'type' => $group,
                    'name' => $property['Propriedade'],
                    'standard' => $property['Norma'],
                    'unit' => $property['Unidade'],
                ], [
                    'value' => $property['Valor'],
                ]);
            }
        }
    }
}
