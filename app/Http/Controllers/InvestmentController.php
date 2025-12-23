<?php

namespace App\Http\Controllers;

use App\Models\Investment;
use App\Models\Project;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InvestmentController extends Controller
{
    public function index(){
       $availableProjects = Project::where('status', 'active')
            ->whereColumn('sold_units', '<', 'total_units')
            ->with('media')
            ->orderBy('created_at', 'desc')
            ->paginate(6); // Paginate untuk membatasi hasil

        return view('investor.indexProjects', compact('availableProjects'));
    }

    public function show(Project $project){
        if($project->status !== 'active' || $project->total_units <= $project->sold_units){
            return redirect()->route('investments.projects.index')->with('error', 'Proyek ini tidak lagi tersedia!');
        }
        $project->load(['media', 'farmer']);
        $availableUnits = $project->total_units - $project->sold_units;
        return view('investor.showProject', compact('project', 'availableUnits'));
    }

    public function store(Request $request, Project $project){
        $availableUnits = $project->total_units - $project->sold_units;

        $request->validate([
            'units' => 'required|integer|min:1|max:' . $availableUnits,
        ]);

        $unitsToInvest = $request->input('units');
        $totalAmount = $unitsToInvest * $project->price_per_unit;
        $user = auth()->user();

        try{
            DB::beginTransaction();
            $transaction = Transaction::create([
                'user_id' => $user->id,
                'project_id' => $project->id,
                'type' => 'invest',
                'amount' => $totalAmount,
                'status' => 'pending'
            ]);

            $investment = Investment::create([
                'user_id' => $user->id,
                'project_id' => $project->id,
                'units' => $unitsToInvest,
                'amount' => $totalAmount,
                'status' => 'pending',
                'transaction_id' => $transaction->id,
            ]);
            DB::commit();
            return redirect()->route('investments.pending', $investment->id)
                    ->with('success', 'Investasi Berhasil diBuat. Lanjutkan ke Pembayaran');

        }catch(\Exception $e){
            DB::rollBack();

    // Atau tampilkan di halaman:
    // return redirect()->back()->with('error', 'Gagal: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Gagal Membuat Investasi');
        }
    }

    public function pending(Investment $investment){
        if($investment->user_id !== auth()->id() || $investment->status !== 'pending'){
            return redirect()->route('investor.investments.history')->with('warning', 'Investasi Tidak diTemukan atau sudah di proses');
        }

        return view('investor.pendingInvestment', compact('investment'));
    }

    public function history(){
            $investments = Investment::with([
                'project',
                'transaction'
            ])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(6);

        return view('investor.historyInvestments', compact('investments'));
    }

    public function cancel(Investment $investment){
        if($investment->user_id !== auth()->id()){
            abort(403, 'Anda Tidak Berhak membatalkan transaksi ini');
        }
        if($investment->status !== 'pending'){
            return redirect()->route('investments.history')->with('error', 'Transaksi sudah di proses dan tidak dapat dibatalkan');
        }
        try{
            DB::beginTransaction();
            $investment->update(['status' => 'cancelled']);

            if($investment->transaction){
                $investment->transaction->update(['status' => 'failed']);
            }
            DB::commit();
            return redirect()->route('investments.history')->with('success', 'Transaksi Investasi Proyek '. $investment->project->title . ' Berhasil di Batalkan');   
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal membatalkan Transaksi');
        }
    }
    public function detail(Investment $investment){
        if($investment->user_id !== auth()->id()){
            abort(403, 'Anda Tidak Berhak melihat detail investasi ini.');
        }
        $investment->load(['project', 'transaction']);
        if($investment->status === 'pending'){
            return redirect()->route('investments.pending', $investment->id)->with('warning', 'Transaksi ini masih dalam proses pembayaran.');
        }
        return view('investor.detail', compact('investment'));
    }
}
