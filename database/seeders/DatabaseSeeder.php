<?php

namespace Database\Seeders;

use App\Models\FarmerReport;
use App\Models\User;
use App\Models\Project;
use App\Models\Investment;
use App\Models\ProjectMedia;
use App\Models\ReportMedia;
use App\Models\Transaction;
use App\Models\WithdrawRequest;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       // 2. Projects (10 data)
        Project::factory(10)->create();

        // 3. Transactions (20 data - lebih banyak karena ada 3 tipe)
        Transaction::factory(20)->create();

        // 4. Project Media (10 data)
        ProjectMedia::factory(10)->create();

        // 5. Investments (10 data)
        Investment::factory(10)->create();

        // 6. Withdraw Requests (10 data)
        WithdrawRequest::factory(10)->create();

        // 7. Farmer Reports (10 data)
        FarmerReport::factory(10)->create();

        // 8. Report Media (10 data)
        ReportMedia::factory(10)->create();
    }
}