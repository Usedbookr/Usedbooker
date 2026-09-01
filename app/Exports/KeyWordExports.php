<?php

namespace App\Exports;

use App\Models\Search;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class KeyWordExports implements FromView
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

        return view('key_word', [
            'invoices' => Search::get()
        ]);

    }
}
