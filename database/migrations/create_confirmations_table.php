<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('confirmations', function (Blueprint $table): void {
            $table
                ->uuid('id')
                ->index();

            $table->string('target');
            $table->string('secret');
            $table
                ->integer('attempts')
                ->default(0);

            $table
                ->dateTime('confirmed_at')
                ->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('confirmations');
    }
};
