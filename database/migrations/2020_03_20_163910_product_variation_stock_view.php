<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProductVariationStockView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Illuminate\Support\Facades\DB::statement("
            CREATE OR REPLACE VIEW product_variation_stock_view AS
            SELECT 
                product_variations.product_id AS product_id,
                product_variations.id AS product_variation_id,
                COALESCE(SUM(stocks.quantity) - COALESCE(SUM(product_variation_order.quantity), 0), 0) as stock,
                case when COALESCE(SUM(stocks.quantity) - COALESCE(SUM(product_variation_order.quantity), 0), 0) > 0
                    then true
                    else false
                end in_stock
            FROM product_variations
            LEFT JOIN(
                SELECT 
                    stocks.product_variation_id AS id,
                    SUM(stocks.quantity) as quantity
                FROM stocks
                GROUP BY stocks.product_variation_id
            ) AS stocks USING(id)
            LEFT JOIN(
                SELECT
                    product_variation_order.product_variation_id AS id,
                    SUM(product_variation_order.quantity) as quantity
                FROM product_variation_order
                GROUP BY product_variation_order.product_variation_id
            ) AS product_variation_order USING(id)
            GROUP BY product_variations.id
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS product_variation_stock_view");
    }
}
