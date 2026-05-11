<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * جدول العقارات - يُنشأ أخيراً لأنه يعتمد على جدولَي السماسرة والملاك
     */
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();

            // المفاتيح الخارجية
            $table->foreignId('broker_id')->constrained('brokers')->cascadeOnDelete();
            $table->foreignId('owner_id')->constrained('owners')->cascadeOnDelete();

            // نوع العقار
            $table->enum('type', ['شقة', 'فيلا', 'محل', 'مكتب', 'أرض']);

            // الموقع
            $table->string('governorate');  // المحافظة
            $table->string('district');     // الحي / المنطقة
            $table->string('street')->nullable(); // الشارع

            // مواصفات العقار
            $table->decimal('area_sqm', 10, 2);             // المساحة بالمتر المربع
            $table->integer('floor')->nullable();            // الطابق
            $table->integer('bedrooms')->nullable();         // عدد غرف النوم
            $table->integer('bathrooms')->nullable();        // عدد الحمامات

            // السعر وطريقة العرض
            $table->decimal('price', 15, 2);
            $table->enum('offer_type', ['بيع', 'إيجار']);
            $table->enum('status', ['متاح', 'مباع', 'مؤجر'])->default('متاح');

            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
