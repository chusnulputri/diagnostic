<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class SalaryExport implements FromView
{
    public function __construct($data) {
        $this->data = $data;
    }

    public function view(): View
    {
        return view('exports.excel.salary_export', [
            'salary' => $this->data
        ]);
    }
}
