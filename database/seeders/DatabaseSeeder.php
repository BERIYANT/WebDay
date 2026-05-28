<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Challenge;
use App\Models\CommunityPost;
use App\Models\CommunityComment;
use App\Models\PostLike;
use App\Models\Partner;
use App\Models\PartnerMessage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Core Challenges
        $challenges = [
            // Category: Health & Fitness
            [
                'category' => 'Health & Fitness',
                'name' => 'Home Full Body Workout',
                'description' => 'Latihan fisik seluruh tubuh tanpa alat untuk meningkatkan kebugaran dan metabolisme tubuh.',
                'difficulty' => 'Medium',
                'points_reward' => 30,
                'time_estimate' => 15,
                'is_premium' => false,
                'youtube_link' => 'https://youtu.be/pi5WhX24uS4?si=2s-wUZU5JuHkIxu-'
            ],
            [
                'category' => 'Health & Fitness',
                'name' => 'Jalan Kaki 30 Menit',
                'description' => 'Jalan kaki secara konsisten selama 30 menit. Sangat baik untuk kesehatan kardiovaskular dan menjernihkan pikiran.',
                'difficulty' => 'Easy',
                'points_reward' => 15,
                'time_estimate' => 30,
                'is_premium' => false,
                'youtube_link' => null
            ],
            [
                'category' => 'Health & Fitness',
                'name' => 'Hidrasi Tubuh (Minum Air)',
                'description' => 'Minum minimal 8 gelas (2 Liter) air putih hari ini untuk menjaga hidrasi dan fokus mental.',
                'difficulty' => 'Easy',
                'points_reward' => 10,
                'time_estimate' => 5,
                'is_premium' => false,
                'youtube_link' => null
            ],
            [
                'category' => 'Health & Fitness',
                'name' => 'Stretching Pagi Hari',
                'description' => 'Peregangan otot ringan selama 10 menit setelah bangun tidur untuk melancarkan peredaran darah.',
                'difficulty' => 'Easy',
                'points_reward' => 15,
                'time_estimate' => 10,
                'is_premium' => false,
                'youtube_link' => null
            ],
            [
                'category' => 'Health & Fitness',
                'name' => 'Yoga Untuk Relaksasi',
                'description' => 'Melatih pernapasan, kelenturan tubuh, dan meredakan stres melalui gerakan yoga dasar.',
                'difficulty' => 'Medium',
                'points_reward' => 25,
                'time_estimate' => 20,
                'is_premium' => false,
                'youtube_link' => null
            ],

            // Category: Journaling
            [
                'category' => 'Journaling',
                'name' => 'Menulis Jurnal Harian',
                'description' => 'Tuliskan aktivitas, pikiran, dan perasaanmu hari ini untuk melatih self-awareness.',
                'difficulty' => 'Easy',
                'points_reward' => 15,
                'time_estimate' => 10,
                'is_premium' => false,
                'youtube_link' => null
            ],
            [
                'category' => 'Journaling',
                'name' => 'Gratitude Journal (Beryukur)',
                'description' => 'Tulis minimal 3 hal yang sangat kamu syukuri hari ini. Menghargai hal kecil membantu meningkatkan kebahagiaan. Tonton video gratitude berikut.',
                'difficulty' => 'Easy',
                'points_reward' => 20,
                'time_estimate' => 10,
                'is_premium' => true,
                'youtube_link' => 'https://youtu.be/xFYJk1hsJaU?si=GRsfXtfktHwtaC9c'
            ],
            [
                'category' => 'Journaling',
                'name' => 'Mood Tracker',
                'description' => 'Catat dan refleksikan pola emosi kamu hari ini untuk kecerdasan emosional yang lebih baik.',
                'difficulty' => 'Easy',
                'points_reward' => 10,
                'time_estimate' => 2,
                'is_premium' => false,
                'youtube_link' => null
            ],

            // Category: Productivity
            [
                'category' => 'Productivity',
                'name' => 'Deep Work (Fokus Belajar)',
                'description' => 'Fokus penuh pada tugas atau belajar tanpa gangguan notifikasi handphone selama 45 menit.',
                'difficulty' => 'Hard',
                'points_reward' => 40,
                'time_estimate' => 45,
                'is_premium' => false,
                'youtube_link' => null
            ],
            [
                'category' => 'Productivity',
                'name' => 'Membaca Buku 10 Halaman',
                'description' => 'Membaca buku non-fiksi atau pengembangan diri minimal 10 halaman hari ini.',
                'difficulty' => 'Medium',
                'points_reward' => 20,
                'time_estimate' => 15,
                'is_premium' => false,
                'youtube_link' => null
            ],
            [
                'category' => 'Productivity',
                'name' => 'Menyusun To-Do List Harian',
                'description' => 'Rencanakan 3 tugas prioritas di pagi hari dan selesaikan semuanya sebelum malam tiba.',
                'difficulty' => 'Easy',
                'points_reward' => 15,
                'time_estimate' => 10,
                'is_premium' => false,
                'youtube_link' => null
            ],

            // Category: Self Improvement
            [
                'category' => 'Self Improvement',
                'name' => 'Latihan Public Speaking',
                'description' => 'Latih teknik berbicara di depan cermin atau kamera selama 15 menit menggunakan panduan video public speaking berikut.',
                'difficulty' => 'Hard',
                'points_reward' => 35,
                'time_estimate' => 15,
                'is_premium' => true,
                'youtube_link' => 'https://youtu.be/-2NnNomW68k?si=ZytgRr3vxwX6B7vW'
            ],
            [
                'category' => 'Self Improvement',
                'name' => 'Self Reflection & Meditasi',
                'description' => 'Duduk hening selama 20 menit, refleksikan pencapaian, pelajaran berharga, dan hal yang perlu ditingkatkan.',
                'difficulty' => 'Medium',
                'points_reward' => 25,
                'time_estimate' => 20,
                'is_premium' => false,
                'youtube_link' => null
            ],
            [
                'category' => 'Self Improvement',
                'name' => 'Mempelajari Skill Baru',
                'description' => 'Tingkatkan kompetensi dengan mempelajari coding challenge, bahasa asing, atau desain grafis selama 60 menit.',
                'difficulty' => 'Hard',
                'points_reward' => 50,
                'time_estimate' => 60,
                'is_premium' => true,
                'youtube_link' => null
            ],
        ];

        foreach ($challenges as $item) {
            Challenge::create($item);
        }

        // 2. Create Authentic Premium & Challenger Users
        $dummyUsersData = [
            ['name' => 'salma', 'email' => 'salma@webday.com', 'points' => 720, 'streak' => 8, 'is_premium' => true],
            ['name' => 'rafiqoh', 'email' => 'rafiqoh@webday.com', 'points' => 530, 'streak' => 5, 'is_premium' => true],
            ['name' => 'nurul', 'email' => 'nurul@webday.com', 'points' => 450, 'streak' => 6, 'is_premium' => false],
            ['name' => 'anargya', 'email' => 'anargya@webday.com', 'points' => 380, 'streak' => 4, 'is_premium' => false],
            ['name' => 'almira', 'email' => 'almira@webday.com', 'points' => 290, 'streak' => 3, 'is_premium' => false],
            ['name' => 'putri', 'email' => 'putri@webday.com', 'points' => 190, 'streak' => 2, 'is_premium' => false],
            ['name' => 'putra', 'email' => 'putra@webday.com', 'points' => 95, 'streak' => 1, 'is_premium' => false],
            ['name' => 'aji', 'email' => 'aji@webday.com', 'points' => 650, 'streak' => 12, 'is_premium' => true],
            ['name' => 'ilham', 'email' => 'ilham@webday.com', 'points' => 420, 'streak' => 5, 'is_premium' => false],
            ['name' => 'aninda', 'email' => 'aninda@webday.com', 'points' => 310, 'streak' => 3, 'is_premium' => false],
            ['name' => 'nathania', 'email' => 'nathania@webday.com', 'points' => 1050, 'streak' => 15, 'is_premium' => true],
        ];

        $users = [];
        foreach ($dummyUsersData as $data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make('password'),
                'points' => $data['points'],
                'streak' => $data['streak'],
                'is_premium' => $data['is_premium'],
                'premium_until' => $data['is_premium'] ? Carbon::now()->addDays(30) : null,
                'theme_dark_unlocked' => $data['points'] >= 500, // high points users already unlocked themes
                'badge_unlocked' => $data['points'] >= 500,
                'selected_badge' => $data['points'] >= 1000 ? 'Legend' : ($data['points'] >= 500 ? 'Master' : ($data['points'] >= 250 ? 'Warrior' : ($data['points'] >= 100 ? 'Challenger' : 'Beginner'))),
                'selected_theme' => 'light'
            ]);
            $users[$data['name']] = $user;
        }

        // 3. Create Default Logged In Test User
        $testUser = User::create([
            'name' => 'almira', // using Almira from user request list as name or default
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
            'points' => 480, // close to 500 points so the user can easily reach 500 and test the point swap!
            'streak' => 4,
            'last_login_date' => Carbon::now()->subDay(),
            'is_premium' => false,
            'premium_until' => null,
            'theme_dark_unlocked' => false,
            'badge_unlocked' => false,
            'selected_badge' => 'Warrior',
            'selected_theme' => 'light'
        ]);

        // 4. Set up Progress Partner accountability link (Mutual Follow)
        // Link testUser with "nurul" to follow each other
        Partner::create([
            'user_id_1' => $testUser->id,
            'user_id_2' => $users['nurul']->id,
            'status' => 'following'
        ]);
        Partner::create([
            'user_id_1' => $users['nurul']->id,
            'user_id_2' => $testUser->id,
            'status' => 'following'
        ]);

        // Send some initial messages to populate partner chat history
        PartnerMessage::create([
            'sender_id' => $users['nurul']->id,
            'receiver_id' => $testUser->id,
            'message' => 'Halo Almira! Semangat ya challenge hari ini! Kemarin aku sudah selesaikan workout lho.'
        ]);
        PartnerMessage::create([
            'sender_id' => $testUser->id,
            'receiver_id' => $users['nurul']->id,
            'message' => 'Wah hebat Nurul! Makasih ya. Aku hari ini mau selesaikan gratitude journal dan public speaking. Yuk bareng!'
        ]);
        PartnerMessage::create([
            'sender_id' => $users['nurul']->id,
            'receiver_id' => $testUser->id,
            'message' => 'Siaap! Dikit lagi poin kamu 500 tuh, bisa tukar premium 1 bulan gratis. Semangatt!'
        ]);

        // 5. Create Community Posts & Conversations
        $postsData = [
            [
                'author' => 'salma',
                'content' => 'Alhamdulillah, hari ini streak ke-8! Rasanya badan jadi jauh lebih segar setelah rutin ikutan Home Full Body Workout tiap pagi. Siapa lagi yang hari ini udah workout?',
                'likes' => 12,
                'comments' => [
                    ['author' => 'rafiqoh', 'text' => 'Hebat banget kak Salma! Aku juga baru beres workout tadi, kaki pegel tapi nagih bgt!'],
                    ['author' => 'aji', 'text' => 'Mantap! Konsistensi adalah kunci. Jangan lupa stretching setelahnya ya biar ga cedera.']
                ]
            ],
            [
                'author' => 'aji',
                'content' => 'Tips produktivitas hari ini: coba terapkan teknik Deep Work selama 45 menit tanpa menyentuh HP sama sekali. Hasilnya luar biasa, kerjaan yang biasanya kelar 2 jam bisa beres dalam 45 menit!',
                'likes' => 18,
                'comments' => [
                    ['author' => 'aninda', 'text' => 'Bener banget kak! Distraksi HP itu emang silent killer produktivitas.'],
                    ['author' => 'nathania', 'text' => 'Setuju bgt. Aku biasanya pake aplikasi forest / mode fokus bawaan hp biar ga gatel pengen buka instagram.']
                ]
            ],
            [
                'author' => 'nathania',
                'content' => 'Baru saja menyelesaikan latihan Public Speaking hari ini. Sangat terbantu dengan materi video di challenge premium. Sekarang jadi lebih percaya diri buat presentasi besok di kampus! 🔥',
                'likes' => 25,
                'comments' => [
                    ['author' => 'salma', 'text' => 'Keren banget Nathania! Semoga presentasi besok lancar jaya ya!'],
                    ['author' => 'rafiqoh', 'text' => 'Duh pengen banget unlock premium juga biar bisa nonton video latihan public speakingnya. Kurang dikit lagi poin aku 500!']
                ]
            ],
            [
                'author' => 'rafiqoh',
                'content' => 'Merenung hari ini di gratitude journal. Menyadari bahwa bersyukur atas hal-hal kecil seperti udara pagi yang bersih dan kopi hangat bisa mengubah mood seharian jadi positif banget. Semangat beraktivitas teman-teman!',
                'likes' => 15,
                'comments' => [
                    ['author' => 'nurul', 'text' => 'Adem banget bacanya. Memang bersyukur itu booster kebahagiaan instan.'],
                    ['author' => 'anargya', 'text' => 'Betul kak Rafiqoh, bersyukur bikin hati tenang. Have a nice day!']
                ]
            ],
        ];

        foreach ($postsData as $pData) {
            $author = $users[$pData['author']];
            $post = CommunityPost::create([
                'user_id' => $author->id,
                'content' => $pData['content'],
                'likes_count' => $pData['likes'],
                'created_at' => Carbon::now()->subHours(rand(1, 24))
            ]);

            // Add likes records
            $likeUsers = array_slice($users, 0, min($pData['likes'], count($users)));
            foreach ($likeUsers as $lUser) {
                PostLike::create([
                    'user_id' => $lUser->id,
                    'post_id' => $post->id
                ]);
            }

            // Add Comments
            foreach ($pData['comments'] as $cData) {
                $cAuthor = $users[$cData['author']] ?? $testUser;
                CommunityComment::create([
                    'user_id' => $cAuthor->id,
                    'post_id' => $post->id,
                    'content' => $cData['text'],
                    'created_at' => Carbon::now()->subMinutes(rand(5, 120))
                ]);
            }
        }
    }
}
