<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\WithdrawRequest;
use Illuminate\Http\Request;

class AdminFinanceController extends Controller
{
    public function index(){
        $totalInvest = Transaction::where('type', 'amount')->where('status', 'success')->sum('amount');
        $totalProfitShared = Transaction::where('type', 'profit')->where('status', 'success')
                            ->sum('amount');

        $pendingWithdraw = WithdrawRequest::where('status', 'pending')->count();
        $approvedWithdraw = WithdrawRequest::where('status', 'approved')->sum('amount');

        $recentTransaction = Transaction::with(['project'])->latest()->paginate(10);

        return view('admin.finance', compact('totalInvest', 'totalProfitShared', 'pendingWithdraw', 'approvedWithdraw','recentTransaction'));
    }
    public function withdrawRequests(){
        $withdraws = WithdrawRequest::latest()->paginate(10);
        return view('admin.withdrawFinance', compact('withdraws'));
    }

    public function approveWithdraw($id){
        $withdraw = WithdrawRequest::findOrFail($id);
        $withdraw->update(['status', 'approved']);

        return back()->with('success', 'Withdraw Berhasil di Setujui.');
    }

    public function rejectWithdraw($id){
        $withdraw = WithdrawRequest::findOrFail($id);
        $withdraw->update(['status' => 'rejected']);

        return back()->with('success', 'Withdraw berhasil ditolak.');
    }
}
