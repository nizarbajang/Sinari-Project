<?php

namespace App\Http\Controllers;

use App\Models\FarmerReport;
use App\Models\Investment;
use App\Models\Project;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index(){
        $totalActiveProjects = Project::where('status', 'active')->count();
        $totalRegisteredUsers = User::whereIn('role', ['investor', 'farmer'])->count();
        $totalMoneyIn = Transaction::where('type', 'invest')
                                    ->where('status', 'success')
                                    ->sum('amount');
        $recentProjects = Project::with('farmer') // Memuat relasi farmer (User)
                                    ->latest()
                                    ->limit(2)
                                    ->get();
        $investmentsData = $this->getMonthlyInvestmentData();
        return view('admin.dashboard', [
            'totalActiveProjects' => $totalActiveProjects,
            'totalRegisteredUsers' => $totalRegisteredUsers,
            'totalMoneyIn' => $totalMoneyIn,
            'recentProjects' => $recentProjects,
            'investmentsData' => $investmentsData,
        ]);
    }

    public function report(){
        $reports = FarmerReport::with(['project', 'farmer'])->latest()->paginate(10);
        return view('admin.farmerReports', compact('reports'));
    }

    public function show($id){
        $report = FarmerReport::with(['project', 'farmer', 'media'])->findOrFail($id);
        return view('admin.detailReport', compact('report'));
    }

    public function verify($id){
        $report = FarmerReport::findOrFail($id);
        $report->update([
            'notes' => ($report->notes ?? ''). "\n\n[Verified by admin]"
        ]);
        return back()->with('success', 'Laporan berhasil di verifikasi');
    }

    protected function getMonthlyInvestmentData()
    {
        // Ambil data investasi sukses dari 6 bulan terakhir
        $months = 6; 

        $data = Transaction::select(
            DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month_year"),
            DB::raw("DATE_FORMAT(created_at, '%b %Y') as month_name"),
            DB::raw("SUM(amount) as total_invested")
        )
        ->where('type', 'invest')
        ->where('status', 'success')
        ->where('created_at', '>=', now()->subMonths($months))
        ->groupBy('month_year', 'month_name')
        ->orderBy('month_year')
        ->get();

        // Format data untuk Chart JS
        $labels = $data->pluck('month_name')->toArray();
        $totals = $data->pluck('total_invested')->toArray();

        // Contoh padding data untuk 6 bulan terakhir jika ada bulan yang kosong
        // (Logika padding yang lebih kompleks mungkin diperlukan, ini adalah contoh sederhana)

        return [
            'labels' => $labels,
            'data' => $totals,
        ];
    }
}
