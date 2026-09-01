<?php

namespace App\Exports;

use App\Models\Books;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class BookExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */

    private $data;

    public function __construct()
    {
        
    }

    public function view(): View
    {
        // dd($data);
        return view('book_download', [
            'invoices' => Books::with(['varients'])->get()
        ]);
    }
}
