<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{

    private $prefix;

    public function __construct()
    {
        $this->prefix = env('DB_PREFIX', '');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("{$this->prefix}products", function (Blueprint $table) {
            $table->string('id', 11)->primary();;
            $table->string('sku');
            $table->string('name');
            $table->unsignedMediumInteger('quantity')->default(0);
            $table->unsignedInteger('type_id');
            $table->decimal('weight', 8, 3)->nullable();
            $table->string('unit', 10)->nullable();
            $table->text('description')->nullable();
            $table->string('brand_id', 36);
            $table->boolean('enabled')->default(0);
            $table->boolean('active')->default(0);
            $table->boolean('warranty')->default(0);
            $table->boolean('service')->default(0);
            $table->unsignedInteger('equipment_id')->nullable(true);
            $table->timestamps();

            $table
                ->foreign('type_id')
                ->references('id')
                ->on("{$this->prefix}product_types")
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table
                ->foreign('brand_id')
                ->references('id')
                ->on("{$this->prefix}brands")
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table
                ->foreign('equipment_id')
                ->references('id')
                ->on("{$this->prefix}equipments")
                ->onUpdate('cascade')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("{$this->prefix}products");
    }

}
