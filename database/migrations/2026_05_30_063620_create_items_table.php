<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->string('item_name');
            $table->enum('category',['makanan', 'atk', 'elektronik', 'logistik', 'lainnya']);
            $table->string('image');
            $table->enum('status', ['good', 'broke', 'maintenance'])->default('good');
            $table->text('desc');
            $table->foreignId('location_id')->nullable()->constrained('locations')->nullOnDelete()->cascadeOnUpdate();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
