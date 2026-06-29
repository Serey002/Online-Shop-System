<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'total_price')) {
                $table->decimal('total_price', 10, 2)->nullable()->after('total_amount');
            }

            if (!Schema::hasColumn('orders', 'items_summary')) {
                $table->string('items_summary', 500)->nullable()->after('total_price');
            }

            if (!Schema::hasColumn('orders', 'notes')) {
                $table->string('notes')->nullable()->after('items_summary');
            }
        });

        if (Schema::hasColumn('orders', 'total_amount') && Schema::hasColumn('orders', 'total_price')) {
            DB::table('orders')
                ->whereNull('total_price')
                ->update(['total_price' => DB::raw('total_amount')]);
        }

        Schema::table('reviews', function (Blueprint $table) {
            if (!Schema::hasColumn('reviews', 'user_id')) {
                $table->foreignId('user_id')->nullable()->after('id')->constrained()->cascadeOnDelete();
            }

            if (!Schema::hasColumn('reviews', 'product_id')) {
                $table->foreignId('product_id')->nullable()->after('user_id')->constrained()->cascadeOnDelete();
            }

            if (!Schema::hasColumn('reviews', 'rating')) {
                $table->unsignedTinyInteger('rating')->nullable()->after('product_id');
            }

            if (!Schema::hasColumn('reviews', 'comment')) {
                $table->text('comment')->nullable()->after('rating');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This migration repairs schema drift and intentionally leaves data columns in place.
    }
};
