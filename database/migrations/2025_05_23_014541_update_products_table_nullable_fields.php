<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProductsTableNullableFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
          
            $table->string('code')->nullable()->change();
            $table->string('color')->nullable();
            $table->string('image_url')->nullable();
            $table->text('description')->nullable();
            $table->longText('observations')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            // Revertendo as alterações
            $table->string('code')->nullable(false)->change();
        });
    }
}
