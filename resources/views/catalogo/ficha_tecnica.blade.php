<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Ficha Técnica - {{ $product->code }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.3;
            color: #333;
            max-width: 800px;
            margin: 0 auto;
            padding: 10px;
            font-size: 12px;
        }
        .footer {
            width: 350px;
            text-align: center;
            margin: 20px auto;
        }
        h1 {
            color: #000;
            font-size: 16px;
            border-bottom: 1px solid #000;
            padding-bottom: 5px;
            margin-bottom: 10px;
        }
        
        .product-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
        }
        
        .product-name {
            font-weight: bold;
            font-size: 13px;
        }
        
        .product-color {
            font-weight: bold;
        }
        p {
            margin: 0;
        }
        .section {
            margin-bottom: 10px;
        }
        
        .section-title {
            font-weight: bold;
            margin-bottom: 5px;
            font-size: 12px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 8px 0;
            font-size: 11px;
        }
        
        th, td {
            border: 1px solid #ddd;
            padding: 4px;
            text-align: left;
        }
        
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        
        .note {
            font-style: italic;
            margin-top: 10px;
            font-size: 10px;
            line-height: 1.2;
        }
        
        .footer {
            margin-top: 15px;
            font-size: 10px;
            line-height: 1.2;
        }
        
        .print-button {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 8px 15px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 12px;
            margin: 10px 0;
            cursor: pointer;
            border-radius: 3px;
        }
        
        @media print {
            body {
                padding: 0;
                margin: 0;
                font-size: 10pt;
                line-height: 1.2;
            }
            
            .print-button {
                display: none;
            }
            
            h1 {
                font-size: 14pt;
                margin-top: 0;
            }
            
            table {
                font-size: 9pt;
                page-break-inside: avoid;
            }
            
            .section {
                margin-bottom: 8pt;
            }
            
            .note, .footer {
                font-size: 8pt;
            }
            
            @page {
                margin: 0.5cm;
            }
        }
    </style>
</head>
<body>

    <h1>FICHA TÉCNICA DE PRODUTO</h1>
    <div class="product-header">
        <span class="product-name">Produto: {{ $product->code }}</span>
        <span class="product-color">Cor: {{ $product->color }}</span>
    </div>

    <div class="section">
        <div class="section-title">Descrição:</div>
        <p>{{ $product->description }}</p>
    </div>

    <div class="section">
        <div class="section-title">Aplicações Tipicas:</div>
        <p>{{ $product->typical_applications ?? '-' }}</p>
    </div>

    <div class="section">
        <div class="section-title">Especificações Automotivas:</div>
        <p>
            @if(count($automotive_specifications) > 0)
                {{ implode(', ', $automotive_specifications) }}
            @else
                -
            @endif
        </p>
    </div>

    <div class="section">
        <div class="section-title">Propriedades:</div>
        <table>
            <thead>
                <tr>
                    <th>Propriedades</th>
                    <th>Método</th>
                    <th>Unidade</th>
                    <th>Valores</th>
                </tr>
            </thead>
            <tbody>
                @foreach ([
                    'Físicas' => $product->physicalProperties,
                    'Mecânicas' => $product->mechanicalProperties,
                    'Impacto' => $product->impactProperties,
                    'Térmicas' => $product->thermalProperties,
                    'Outros' => $product->otherProperties,
                ] as $group => $properties)
                    <tr><td colspan="4" style="font-weight: bold; font-size: 11px;">{{ $group }}</td></tr>
                    @forelse ($properties as $property)
                        <tr>
                            <td>{{ $property->name }}</td>
                            <td>{{ $property->standard }}</td>
                            <td>{{ $property->unit }}</td>
                            <td>{{ $property->value }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4">Nenhuma propriedade cadastrada.</td></tr>
                    @endforelse
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="note">
        <p><strong>Observação:</strong> {{ $product->observations ?? 'Valores típicos, não devem ser utilizados como especificação...' }}</p>
    </div>

    <div class="footer">
        <p>Revisão: {{ $product->updated_at->locale('pt_BR')->format('M/Y') }} | CPE – Compostos Plásticos de Engenharia</p>
        <p>Rua Manoel Pinto de Carvalho, 229/283 - Bairro Limão - São Paulo/SP - CEP: 02712-120</p>
        <p>Tel.: +55 11 2142-2355</p>
    </div>

    <button class="print-button" onclick="window.print()">Imprimir Ficha Técnica</button>
    <a href="{{ route('catalogo.produto.pdf', $product->id) }}" class="print-button" style="margin-left: 10px; text-decoration: none;">Baixar PDF</a>

    <script>
        if(window.location.search.includes('?print')) {
            window.print();
        }
       
    </script>
</body>
</html>
