<?php

namespace App\Exports;

use App\Models\Category;
use App\Models\Language;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class ExportCategories implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */

    private $data;

    public function __construct($data)
    {
        $this->categories       = $data['categories'];
    }

    public function view(): View
    {
        $categories   = $this->categories;

        if ($categories) {
            if ($categories == "Category") {
                $categories_type = Category::where('level', 1);
            }
            else if ($categories == "SubCategory") {
                $categories_type = Category::where('level', 2);
            }
            else if ($categories == "ChildCategory") {
                $categories_type = Category::where('level', 3);
            }
            else if ($categories == "Language") {
                $categories_type = Language::where('status', 1);
            }
        }
        
        return view('categories_type', [
            'invoices' => $categories_type->get()
        ]);
    }
}
