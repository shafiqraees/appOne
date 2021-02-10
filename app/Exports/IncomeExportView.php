<?php

namespace App\Exports;

use App\Models\UserTransaction;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class IncomeExportView implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('admin.home.income', [
            'data' => UserTransaction::select(DB::raw("SUM(credits) as total_credits"),
                DB::raw('count(*) as trsaction_count'),DB::raw("SUM(amount) as total_amount"),
                DB::raw("SUM(fee) as total_fee"),'created_at'
            )->groupBy('created_at')->orderBy('created_at','desc')->get()
        ]);
    }
}
