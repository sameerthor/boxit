<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExampleExportView implements FromView
{
    private $data;
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        $tabledata = $this->data;
        return view('concrete_sheet', compact('tabledata'));
    }
}