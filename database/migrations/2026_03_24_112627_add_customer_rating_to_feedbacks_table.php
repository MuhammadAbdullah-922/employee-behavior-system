<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('feedbacks', function (Blueprint $table) {

            // Add employee_id if not exists
            if (!Schema::hasColumn('feedbacks', 'employee_id')) {
                $table->foreignId('employee_id')
                      ->constrained('employees')
                      ->onDelete('cascade');
            }

            // Add interaction_id if not exists
            if (!Schema::hasColumn('feedbacks', 'interaction_id')) {
                $table->foreignId('interaction_id')
                      ->constrained('interactions')
                      ->onDelete('cascade');
            }

            // Add customer_rating
            if (!Schema::hasColumn('feedbacks', 'customer_rating')) {
                $table->tinyInteger('customer_rating');
            }

            // Add comments if not exists
            if (!Schema::hasColumn('feedbacks', 'comments')) {
                $table->text('comments')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('feedbacks', function (Blueprint $table) {
            $table->dropColumn(['customer_rating', 'comments']);

            // Only drop foreign keys if they exist
            if (Schema::hasColumn('feedbacks', 'employee_id')) {
                $table->dropForeign(['employee_id']);
                $table->dropColumn('employee_id');
            }

            if (Schema::hasColumn('feedbacks', 'interaction_id')) {
                $table->dropForeign(['interaction_id']);
                $table->dropColumn('interaction_id');
            }
        });
    }
};