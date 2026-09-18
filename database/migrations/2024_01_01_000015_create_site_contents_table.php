<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_contents', function (Blueprint $table) {
            $table->id();
            $table->string('section')->comment('Nama section: hero, about, stats, why_us, cta, contact, footer');
            $table->string('key')->comment('Nama field: title, subtitle, description, dsb');
            $table->text('value')->nullable()->comment('Isi konten');
            $table->string('type')->default('text')->comment('text | textarea | image');
            $table->string('label')->comment('Label yang tampil di form CMS admin');
            $table->integer('sort_order')->default(0);
            $table->timestamps();

            $table->unique(['section', 'key']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_contents');
    }
};
