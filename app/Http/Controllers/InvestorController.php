<?php

namespace App\Http\Controllers;

use App\Models\FarmerReport;
use App\Models\Project;
use App\Models\Investment;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvestorController extends Controller
{
    public function index(){
        $user = Auth::user();
        
        // Ambil data investasi milik user
        $investments = $user->investments()->with('project')->get();

        // 1. Total Investasi Aktif (paid)
        $totalInvested = $investments->where('status', 'paid')->sum('amount');

        // 2. Dana Menunggu Pembayaran (pending)
        $pendingAmount = $investments->where('status', 'pending')->sum('amount');
        
        // 3. Estimasi Profit (Contoh Perhitungan Sederhana)
        // Diperlukan tabel 'Profit' atau 'Balance' nyata untuk data akurat.
        $estimatedProfit = $investments
            ->where('status', 'paid')
            ->sum(function ($investment) {
                // Estimasi Profit = Amount * Profit Share Proyek
                $profitPercentage = $investment->project->profit_percentage / 100;
                return $investment->amount * $profitPercentage;
            });
            
        // 4. Proyek Terbaru
        $latestProjects = Project::where('status', 'active')
            ->whereRaw('total_units > sold_units')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();
        
        return view('investor.dashboard', compact(
            'totalInvested',
            'pendingAmount',
            'estimatedProfit',
            'latestProjects'
        ));
    }
    public function reportFarmer(Project $project){
        $hasActiveInvesment = $project->investments()->where('user_id', Auth::id())
        ->whereIn('status', ['paid', 'pending'])->exists();

        if(!$hasActiveInvesment){
            return redirect()->route('investments.history')->with('error','Anda hanya dapat melihat laporan proyek yang sedang anda investasikan atau lunas.');
        }

        $reports = $project->farmerReports()->with('farmer')->latest('created_at')->get();

        return view('investor.reportIndex', compact('project', 'reports'));
    }


    public function showReport(Project $project, FarmerReport $report){
        // 1. Otorisasi: Pastikan laporan ini milik proyek yang benar
        if ($report->project_id !== $project->id) {
            abort(404, 'Laporan tidak ditemukan untuk proyek ini.');
        }

        // 2. Otorisasi: Verifikasi kepemilikan investasi (wajib diulang karena Route Model Binding hanya memverifikasi ID)
        $hasActiveInvestment = $project->investments()
            ->where('user_id', Auth::id())
            ->whereIn('status', ['paid', 'running'])
            ->exists();

        if (!$hasActiveInvestment) {
            return redirect()->route('investor.investments.history')->with('error', 'Anda tidak berhak melihat detail laporan ini.');
        }
        
        // Load media terkait
        $report->load('media'); 

        return view('investor.showReports', compact('project', 'report'));
    }
}
