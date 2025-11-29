<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Project;
use App\Models\Investment;
use App\Models\Transaction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Pastikan tabel kosong sebelum seeding (opsional, tergantung kebutuhan)
        // DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        // User::truncate();
        // Project::truncate();
        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');


        // 1. Seed USERS (Admin, Investor, Farmer spesifik, dan Investor/Farmer acak)
        $admin = User::factory()->admin()->create(['name' => 'Admin Utama', 'email' => 'admin@test.com']);
        $investor1 = User::factory()->investor()->create(['name' => 'Investor Kaya', 'email' => 'investor@test.com']);
        $farmer1 = User::factory()->farmer()->create(['name' => 'Peternak Hebat', 'email' => 'farmer@test.com']);
        
        // Tambahkan 10 user acak lainnya (investor atau farmer)
        User::factory(10)->create(); 

        // ---------------------------------------------------------------------

        // 2. Seed PROJECTS
        // Asumsi admin dan farmer sudah ada
        $projects = Project::factory(5)
            ->recycle([$admin, $farmer1]) // Agar project menggunakan admin/farmer yang sudah dibuat
            ->create();

        // ---------------------------------------------------------------------
        
        // 3. Seed INVESTMENTS & TRANSACTIONS
        // Ambil semua investor untuk investasi
        $investors = User::where('role', 'investor')->get();
        $investors->each(function ($investor) use ($projects) {
            
            // Setiap investor berinvestasi di 1-3 proyek
            $projects->random(rand(1, 3))->each(function ($project) use ($investor) {
                $units = rand(5, 20); // Jumlah unit investasi
                $amount = $units * $project->price_per_unit;

                // Buat Transaksi Investasi (Status Success)
                $transaction = Transaction::create([
                    'user_id' => $investor->id,
                    'project_id' => $project->id,
                    'type' => 'invest',
                    'amount' => $amount,
                    'payment_method' => 'Bank Transfer',
                    'status' => 'success',
                ]);

                // Buat Catatan Investasi
                Investment::create([
                    'user_id' => $investor->id,
                    'project_id' => $project->id,
                    'units' => $units,
                    'amount' => $amount,
                    'status' => 'paid',
                    'transaction_id' => $transaction->id,
                ]);

                // Update sold_units proyek
                // New way menggunakan update (Query Builder)
                \App\Models\Project::where('id', $project->id)
                ->increment('sold_units', $units);

            });
        });

        // ---------------------------------------------------------------------

        // 4. Seed FARMER REPORTS & MEDIA (untuk 3 proyek acak)
        $projects->take(3)->each(function ($project) use ($farmer1) {
            
            // Buat 5 laporan untuk proyek ini
            $reports = $project->reports()->createMany(
                \App\Models\FarmerReport::factory(5)->make([
                    'farmer_id' => $project->farmer_id,
                ])->toArray()
            );

            // Tambahkan media ke setiap laporan
            $reports->each(function ($report) {
                \App\Models\ReportMedia::factory(2)->create([
                    'report_id' => $report->id,
                ]);
            });
        });

        // 5. Seed WITHDRAW REQUESTS (Contoh)
        \App\Models\WithdrawRequest::factory(3)->create([
            'user_id' => $investor1->id,
        ]);

        // 6. Seed PROJECT MEDIA
        $projects->each(function ($project) {
            \App\Models\ProjectMedia::factory(3)->create([
                'project_id' => $project->id,
            ]);
        });
        
    }
}