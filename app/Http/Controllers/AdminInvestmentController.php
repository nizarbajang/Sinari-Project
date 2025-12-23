<?php

namespace App\Http\Controllers;

use App\Models\Investment;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\NodeVisitor\CommentAnnotatingVisitor;

class AdminInvestmentController extends Controller
{
    public function index(){
        $investments = Investment::with(['investor', 'project', 'transaction'])->latest()->paginate(10);

        return view('admin.indexInvestments', compact('investments'));
    }
    public function detail($id){
        $investment = Investment::findOrFail($id);
        $investment->load(['investor', 'project', 'transaction']);
        return view('admin.showInvestment', compact('investment'));
    }

    public function confirm($id){
        $investments = Investment::findOrFail($id);

        if($investments->status !== 'pending'){
            return back()->with('serror', 'Investasi Ini Sudah di Proses.');
        }
        $project = $investments->project;
        if(!$project){
            return back()->with('error', 'Proyek tidak ditemukan.');
        }
        $availableUnits = $project->total_units - $project->sold_units;

        if($investments->units > $availableUnits){
            return back()->with('error', 'Konfirmasi gagal: Unit proyek sudah penuh');
        }
        try{
            DB::beginTransaction();
            $investments->update([
                'status' => 'paid'
            ]);

            if($investments->transaction->id){
                $investments->transaction->update([
                    'status' => 'success'
                ]);
            }
            $project->increment('sold_units', $investments->units);
            DB::commit();
            return back()->with('success', 'Investasi Berhasil di Konfirmasi.');
        }catch(\Exception $e){
            DB::rollBack();
            return back()->with('error', 'Gagal Mengkonfirmasi investasi: '. $e->getMessage());
        }
    }
    public function cancel($id){
        $investment = Investment::findOrFail($id);

        $investment->update([
            'status' => 'cancceled'
        ]);

        if($investment->transaction_id){
            Transaction::where('id', $investment->transaction_id)->update([
                'status' => 'failed'
            ]);
        }

        return back()->with('success', 'Investasi Berhasil di Batalkan');
    }
}
