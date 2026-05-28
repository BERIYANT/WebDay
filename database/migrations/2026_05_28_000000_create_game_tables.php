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
        // 1. Challenges table
        Schema::create('challenges', function (Blueprint $table) {
            $table->id();
            $table->string('category'); // e.g. 'Health & Fitness', 'Journaling', 'Productivity', 'Self Improvement'
            $table->string('name');
            $table->text('description');
            $table->string('difficulty'); // 'Easy', 'Medium', 'Hard'
            $table->integer('points_reward');
            $table->integer('time_estimate'); // in minutes
            $table->boolean('is_premium')->default(false);
            $table->string('youtube_link')->nullable();
            $table->timestamps();
        });

        // 2. User Challenges pivot/progress table
        Schema::create('user_challenges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('challenge_id')->constrained()->onDelete('cascade');
            $table->string('status')->default('started'); // 'started', 'completed'
            $table->integer('progress')->default(0); // e.g., 0 to 100 representing percentage watched/completed
            $table->integer('watched_seconds')->default(0);
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });

        // 3. Journals table
        Schema::create('journals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('content');
            $table->string('mood'); // e.g. 'happy', 'neutral', 'sad', 'stressed', 'energetic'
            $table->timestamps();
        });

        // 4. Community Posts table
        Schema::create('community_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('content');
            $table->integer('likes_count')->default(0);
            $table->timestamps();
        });

        // 5. Community Comments table
        Schema::create('community_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('post_id')->constrained('community_posts')->onDelete('cascade');
            $table->text('content');
            $table->timestamps();
        });

        // 6. Community Likes table (to prevent double likes)
        Schema::create('post_likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('post_id')->constrained('community_posts')->onDelete('cascade');
            $table->timestamps();
        });

        // 7. Partners (Accountability Partner) table
        Schema::create('partners', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id_1')->constrained('users')->onDelete('cascade');
            $table->foreignId('user_id_2')->constrained('users')->onDelete('cascade');
            $table->string('status')->default('accepted'); // 'pending', 'accepted'
            $table->timestamps();
        });

        // 8. Partner Messages (Accountability Chat) table
        Schema::create('partner_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sender_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('receiver_id')->constrained('users')->onDelete('cascade');
            $table->text('message');
            $table->timestamps();
        });

        // 9. Claims/Rewards table
        Schema::create('rewards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('reward_type'); // 'premium_1m', 'theme_dark', 'badge_special'
            $table->timestamp('claimed_at');
            $table->timestamps();
        });

        // 10. Transactions table (Simulated payments)
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('plan'); // '1m', '6m', '1y'
            $table->integer('price');
            $table->string('payment_method'); // 'qris', 'shopee', 'dana'
            $table->string('status')->default('pending'); // 'pending', 'completed'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
        Schema::dropIfExists('rewards');
        Schema::dropIfExists('partner_messages');
        Schema::dropIfExists('partners');
        Schema::dropIfExists('post_likes');
        Schema::dropIfExists('community_comments');
        Schema::dropIfExists('community_posts');
        Schema::dropIfExists('journals');
        Schema::dropIfExists('user_challenges');
        Schema::dropIfExists('challenges');
    }
};
