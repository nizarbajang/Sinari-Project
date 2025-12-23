<?php

namespace App\Http\Controllers;

use App\Models\Investment;
use App\Models\Project;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class FarmerController extends Controller
{
    public function dashboard(){
        $farmer = Auth::user();
        $projects = Project::where('farmer_id', $farmer->id)->with(['investments', 'transactions'])
                    ->latest()->paginate(3);
        $farmerProjectIds = $projects->pluck('id');
        
        // Total Dana Terkumpul (dari semua investasi yang berstatus 'paid' atau 'success')
        // Asumsi: Investment mencatat dana yang masuk ke proyek
        $totalCapitalRaised = Investment::whereIn('project_id', $farmerProjectIds)
                                        ->whereIn('status', ['paid', 'success'])
                                        ->sum('amount');
        
        // Total Profit yang Sudah Dibagikan kepada Investor
        // Asumsi: Transaction dengan type 'profit' adalah pembagian hasil
        $totalProfitShared = Transaction::whereIn('project_id', $farmerProjectIds)
                                         ->where('type', 'profit')
                                         ->where('status', 'success')
                                         ->sum('amount');

        // Total Proyek Aktif dan Selesai (Ide Tambahan: Metrik Proyek)
        $projectStatusCounts = Project::where('farmer_id', $farmer->id)
                                      ->selectRaw('status, count(*) as count')
                                      ->groupBy('status')
                                      ->pluck('count', 'status');
        
        // 3. Transaksi Terakhir yang Terkait dengan Proyek Farmer (Ide Tambahan)
        $recentTransactions = Transaction::whereIn('project_id', $farmerProjectIds)
                                         ->latest()
                                         ->take(5)
                                         ->get();
        
        // 4. Kirim data ke view
        return view('farmer.dashboard', compact(
            'farmer',
            'projects',
            'totalCapitalRaised',
            'totalProfitShared',
            'projectStatusCounts',
            'recentTransactions'
        ));
    }
    public function showProject($id){
        $project = Project::with(['farmer', 'investments', 'reports', 'media'])->where('farmer_id', Auth::id())->findOrFail($id);
        return view('farmer.showProject', compact('project'));
    }

}
