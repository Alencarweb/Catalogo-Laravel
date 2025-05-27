
# Catálogo de Produtos

Um sistema de catálogo de produtos desenvolvido com Laravel, permitindo gerenciar produtos, especificações automotivas e propriedades técnicas.

## Funcionalidades

- **Gerenciamento de Produtos**: Cadastro, edição e exclusão de produtos com suas características
- **Especificações Automotivas**: Associação de especificações técnicas a produtos
- **Propriedades Técnicas**: Cadastro de propriedades físicas, mecânicas, térmicas e de impacto
- **Ficha Técnica**: Geração de fichas técnicas em formato PDF
- **Painel Administrativo**: Interface para gerenciamento de todo o catálogo
- **Catálogo Público**: Visualização pública dos produtos disponíveis

## Requisitos

- PHP 7.3 ou superior
- Composer
- MySQL ou outro banco de dados compatível
- Node.js e NPM (para compilação de assets)

## Instalação

1. Clone o repositório
   ```bash
   git clone [url-do-repositorio]
   cd product-catalog
   ```

2. Instale as dependências do PHP
   ```bash
   composer install
   ```

3. Instale as dependências do JavaScript
   ```bash
   npm install
   ```

4. Copie o arquivo de ambiente e gere a chave da aplicação
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. Configure o banco de dados no arquivo `.env`
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=laravel_catalogo
   DB_USERNAME=root
   DB_PASSWORD=
   ```

6. Execute as migrações e seeders
   ```bash
   php artisan migrate --seed
   ```

7. Compile os assets
   ```bash
   npm run dev
   ```

8. Inicie o servidor de desenvolvimento
   ```bash
   php artisan serve
   ```

## Estrutura do Projeto

- **app/Models**: Contém os modelos do sistema (Product, Property, AutomotiveSpecification)
- **app/Http/Controllers**: Controladores da aplicação
  - **Admin**: Controladores da área administrativa
  - **PublicCatalogController**: Controlador do catálogo público
- **resources/views**: Templates Blade
  - **admin**: Views da área administrativa
  - **catalogo**: Views do catálogo público
  - **products**: Views de produtos

## Geração de PDF

O sistema utiliza a biblioteca `barryvdh/laravel-dompdf` para gerar fichas técnicas em PDF a partir das views Blade.

## Acesso ao Painel Administrativo

Acesse o painel administrativo através da rota `/admin` com as seguintes credenciais:

- **Email**: admin@site.com
- **Senha**: senha123

## Licença

Este projeto está licenciado sob a licença MIT - veja o arquivo LICENSE para mais detalhes.