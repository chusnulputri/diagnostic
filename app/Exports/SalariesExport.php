<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class SalariesExport implements FromView
{
    /**
     * @param m_company|Model $company
     * @param array $period format [Carbon, Carbon]
     * @param m_user_company|Model $userCompanies
     */
    public function __construct($company, $periods, $userCompanies) {
        $this->company = $company;
        $this->periods = $periods;
        $this->userCompanies = $userCompanies;
    }

    public function view(): View
    {
        return view('exports.excel.list_salaries', [
            'company' => $this->company,
            'periods' => $this->periods,
            'user_companies' => $this->userCompanies
        ]);
    }
}
