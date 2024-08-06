<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\AutoPost;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('auto_posts')->truncate();
        Schema::table('auto_posts', function (Blueprint $table) {
            $table->dropColumn('end_at');
            $table->dropColumn('start_at');
            $table->dropColumn('time_at');

            $table->date('scheduled_start_date')->after('post_id');
            $table->date('scheduled_end_date')->after('scheduled_start_date');
            $table->time('start_time')->after('scheduled_end_date');
            $table->time('end_time')->after('start_time');
            $table->unsignedInteger('posts_quantity')->after('end_time');
            $table->enum('schedule_type', ['random', 'days', 'time'])->after('posts_quantity');

            $table->morphs('task');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('auto_posts', function (Blueprint $table) {
            $table->date('start_at')->after('post_id');
            $table->date('end_at')->after('start_at');
            $table->time('time_at')->after('end_at');

            $table->dropColumn('scheduled_start_date');
            $table->dropColumn('scheduled_end_date');
            $table->dropColumn('start_time');
            $table->dropColumn('end_time');
            $table->dropColumn('posts_quantity');
            $table->dropColumn('schedule_type');
        });
    }
};
