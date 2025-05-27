<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Product;

class MigrateTypicalApplicationsToProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $products = Product::with('typicalApplications')->get();

        foreach ($products as $product) {
            $textos = $product->typicalApplications->pluck('text')->toArray();
            $product->typical_applications = implode(', ', $textos);
            $product->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::table('products')->update(['typical_applications' => null]);
    }
}
