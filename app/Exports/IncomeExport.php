<?php

namespace App\Exports;

use App\Models\UserTransaction;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
class IncomeExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection(): View
    {
        return UserTransaction::all();

    }
}
