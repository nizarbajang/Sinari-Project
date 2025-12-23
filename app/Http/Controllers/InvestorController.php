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

        $totalInvestment = Investment::where('user_id', $user->id)->where('status', 'paid')->sum('amount');
        $pendingTransactions = Transaction::where('user_id', $user->id)->where('status', 'pending')->count();
        $investedProjects = Investment::where('user_id', $user->id)->distinct('project_id')->count('project_id');
        // 4. Estimasi keuntungan
        $estimasiKeuntungan = Investment::where('user_id', $user->id)
            ->where('status', 'paid')
            ->with('project')
            ->get()
            ->sum(function ($inv) {
                return ($inv->units * $inv->project->price_per_unit) 
                    * ($inv->project->profit_percentage / 100);
            });

        // 5. Project yang bisa mulai diinvestasikan
        $availableProjects = Project::where('status', 'active')
            ->whereColumn('sold_units', '<', 'total_units')
            ->with('media')
            ->get();
        return view('investor.dashboard', compact(
            'totalInvestment',
            'pendingTransactions',
            'investedProjects',
            'estimasiKeuntungan',
            'availableProjects'
        ));
    }
    public function reportFarmer(){
        $user = Auth::user();

        $projectIds = Investment::where('user_id', $user->id)->where('status', 'paid')
                      ->pluck('project_id');

        $reports = FarmerReport::whereIn('project_id', $projectIds)->with(['project', 'media'])
                   ->latest()->paginate(10);

        return view('investor.indexReport', compact('reports'));
    }


    public function showReport($id){
        $user = Auth::user();

        $report = FarmerReport::with(['project', 'media'])->where('id', $id)->firstOrFail();

        $hasInvestment = Investment::where('user_id', $user->id)->where('project_id', $report->project_id)
                        ->where('status', 'paid')->exists();

        if(!$hasInvestment){
            abort(403, 'Anda tidak memiliki akses ke laporan ini!');
        }

        return view('investor.showReport', compact('report'));
    }
}
