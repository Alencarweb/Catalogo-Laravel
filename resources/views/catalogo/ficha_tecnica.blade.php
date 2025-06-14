<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Ficha Técnica - {{ $product->code }}</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <link rel="stylesheet" href="{{ asset('conf/pdf.css') }}">
</head>
<body>
<div id="content">
    <div  style="margin:15px;height: 945px;" class="main-content">
        <div class="product-header">
            <span class="product-name">{{ $product->code }}</span>
            <span class="product-color">Cor: {{ $product->color }}</span>
        </div>
        <div class="col-3">
            <div class="section">
                <div class="section-title">Descrição</div>
                <p>{{ $product->description }}</p>
            </div>

            <div class="section">
                <div class="section-title">Aplicações Tipicas</div>
                <p>{{ $product->typical_applications ?? '-' }}</p>
            </div>

            <div class="section">
                <div class="section-title">Normas</div>
                <p>
                    @if(count($automotive_specifications) > 0)
                        {{ implode(', ', $automotive_specifications) }}
                    @else
                        -
                    @endif
                </p>
            </div>
        </div>

        <h1 style="margin-top: 0px;">Detalhes Técnicos</h1>

        <div class="section">
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
                        <tr><td colspan="4" style="background-color: #f2f2f2;font-weight: bold; font-size: 11px;">{{ $group }}</td></tr>
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
    </div>
    <div class="rev">Revisão: {{ \Carbon\Carbon::parse($product->updated_at)->translatedFormat('F/Y') }}</div>
    <footer class="footer-layout pdf-footer">
        <div>
             <img src="{{ asset('conf/cpe-logo.svg') }}"> 

            <div style="margin-top: 10px;font-size: 12px;width: 120px;line-height: 20px;">Compostos Plásticos de Engenharia</div>
        </div>
        <div>
            <div class="col">
                <img src="{{ asset('conf/phone.svg') }}"> 
                <div> (11) 2142-2355</div>
            </div>
            <div class="col">
                <img src="{{ asset('conf/mail.svg') }}"> 
                <div>contato@cpe.ind.br</div>
            </div>
        </div>
        <div>
            <div class="col" style="align-items: flex-start;">
               <img src="{{ asset('conf/local.svg') }}"> 
               <div>R. Manoel Pinto de Carvalho, 229 Jardim Pereira Leite – São Paulo – SP CEP: 02712-120</div>

            </div>
        </div>
    </footer>
</div>
<br>
<br>
<button onclick="gerarPDF()">Baixar PDF</button>

     
<script>
    function gerarPDF() {
           
            const elemento = document.getElementById('content');
            
            // Usando html2canvas para capturar o elemento como imagem
            html2canvas(elemento, {
                scale: 2, // Aumenta a qualidade
                useCORS: true, // Permite carregar imagens de outros domínios
                logging: false // Desativa logs no console
            }).then(canvas => {
                // Dimensões do canvas
                const imgData = canvas.toDataURL('image/png');
                const imgWidth = 210; 
                const pageHeight = 295; 
                const imgHeight = canvas.height * imgWidth / canvas.width;
                
                
                const { jsPDF } = window.jspdf;
                const pdf = new jsPDF('p', 'mm', 'a4');
                
                let heightLeft = imgHeight;
                let position = 0;
                let page = 1;
               
                pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
                heightLeft -= pageHeight;
                
                while (heightLeft >= 0) {
                    position = heightLeft - imgHeight;
                    pdf.addPage();
                    pdf.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
                    heightLeft -= pageHeight;
                    page++;
                }
                
                pdf.save('{{ \Illuminate\Support\Str::slug($product->code) }}.pdf');
            });
    }
</script>

</body>
</html>
