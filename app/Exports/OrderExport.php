<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class OrderExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */

    private $data;

    public function __construct($data)
    {
        // dd($data);
        $this->day_one = $data['from_data'];
        $this->dat_two = $data['to_date'];
    }

    public function view(): View
    {
        // dd($data);
        return view('excel_download', [
            'invoices' => Order::with(['orderitems', 'orderitems.FetchBook'])->whereDate('created_at', '>=', $this->day_one)
            ->whereDate('created_at', '<=', $this->dat_two)
            ->get()
        ]);
    }
}
