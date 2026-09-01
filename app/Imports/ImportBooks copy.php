<?php

namespace App\Imports;

use Illuminate\Support\Str;
use App\Models\Books;
use App\Models\BookVarient;
use App\Models\Category;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
// use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Contracts\Queue\ShouldQueue;

class ImportBooks implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    private $data; 

    public function __construct()
    {
        // dd($data);
        
    }

    public function collection(collection $rows)
    {
        // dd($rows[1]);
        foreach ($rows as $key => $value) {
            // dd($value);
            if($value[0] == "Book Id" || $value[1] == "Book Name")
            {
                
            }
            else
            {
                if($value[1])
                {
                    // dd($value);
                    $main_category = Category::where('name', $value[2])->where('level', 1)->first();
                    $sub_category = Category::where('name', $value[3])->where('level', 2)->first();
                    $child_category = Category::where('name', $value[4])->where('level', 3)->first();
                    $original_price = $value[10];
                    $selling_price = $value[11];
                    // dd($original_price,$selling_price);
                    $percent = ($original_price - $selling_price) *100 / $original_price;

                    $book_check = Books::where('book_id', $value[0])->first();
                    if ($book_check) {
                        $book_create                    = Books::find($book_check->id);
                    }
                    else
                    {
                        $book_create                    = new Books();
                    }
                    $book_create->name                  = $value[1];
                    $book_create->category_id           = $main_category->id ?? '0';
                    $book_create->subcategory_id        = $sub_category->id ?? '0';
                    $book_create->childcategory_id      = $child_category->id ?? '0';
                    $book_create->author                = $value[5];
                    $book_create->title_long            = $value[6];
                    $book_create->language              = $value[7];
                    $book_create->isbn13                = $value[8];
                    $book_create->publisher             = $value[9];
                    $book_create->original_price        = $value[10];
                    $book_create->selling_price         = $value[11];
                    $book_create->url_slug              = Str::slug($value[1] . '-' . $value[8]);
                    $book_create->discount              = number_format($percent, 2);
                    if($value[12] != 0)
                    {
                        $book_create->gst_charge        = $value[12];
                    }
                    else
                    {
                        $book_create->gst_charge        = 0;
                    }
                    // $book_create->sku                   = $value[15];
                    $book_create->hsn_code              = $value[13];
                    $book_create->listed_by             = $value[14];
                    if($value[15])
                    {
                        $dateString = convertExcelDate($value[15]);
                        $book_create->date_published    = $dateString;
                    }
                    // dd($value[18]);
                    if($value[18] == "Active")
                    {
                        $book_create->status                = 1;
                    }
                    else
                    {
                        $book_create->status                = 0;
                    }
                    
                    $book_create->dimensions            = $value[16];
                    $book_create->pages                 = $value[17];
                    $book_create->save();

                    if($book_create->id)
                    {

                        $book_update = Books::find($book_create->id);
                        $book_update->book_id = "#UBRB".$book_create->id;
                        $book_update->save();

                        if ($value[19]) {
                            $BookVarient1Check = BookVarient::where('book_id', $book_create->id)->where('bookconditions',$value[19])->first();
                            if ($BookVarient1Check) {
                                $book_arrtibute1                = BookVarient::find($BookVarient1Check->id);
                            }
                            else
                            {
                                $book_arrtibute1                = new BookVarient();
                            }
                            $book_arrtibute1->book_id           = $book_create->id;
                            $book_arrtibute1->bookconditions    = $value[19];
                            $book_arrtibute1->price             = $value[20];
                            $book_arrtibute1->stock             = $value[21];
                            $book_arrtibute1->book_weight       = $value[22];
                            $book_arrtibute1->sku_number        = $value[23];
                            $book_arrtibute1->save();
                        }

                        if ($value[24]) {
                            $BookVarient2Check = BookVarient::where('book_id', $book_create->id)->where('bookconditions',$value[24])->first();
                            if ($BookVarient2Check) {
                                $book_arrtibute2                = BookVarient::find($BookVarient2Check->id);
                            }
                            else
                            {
                                $book_arrtibute2                = new BookVarient();
                            }
                            $book_arrtibute2->book_id           = $book_create->id;
                            $book_arrtibute2->bookconditions    = $value[24];
                            $book_arrtibute2->price             = $value[25];
                            $book_arrtibute2->stock             = $value[26];
                            $book_arrtibute2->book_weight       = $value[27];
                            $book_arrtibute1->sku_number        = $value[28];
                            $book_arrtibute2->save();
                        }
                        

                        if ($value[29]) {
                            $BookVarient3Check = BookVarient::where('book_id', $book_create->id)->where('bookconditions',$value[29])->first();
                            if ($BookVarient3Check) {
                                $book_arrtibute3                = BookVarient::find($BookVarient3Check->id);
                            }
                            else
                            {
                                $book_arrtibute3                = new BookVarient();
                            }
                            $book_arrtibute3->book_id           = $book_create->id;
                            $book_arrtibute3->bookconditions    = $value[29];
                            $book_arrtibute3->price             = $value[30];
                            $book_arrtibute3->stock             = $value[31];
                            $book_arrtibute3->book_weight       = $value[32];
                            $book_arrtibute1->sku_number        = $value[33];
                            $book_arrtibute3->save();
                        }

                        if ($value[34]) {
                            $BookVarient4Check = BookVarient::where('book_id', $book_create->id)->where('bookconditions',$value[34])->first();
                            if ($BookVarient4Check) {
                                $book_arrtibute4                = BookVarient::find($BookVarient4Check->id);
                            }
                            else
                            {
                                $book_arrtibute4                = new BookVarient();
                            }
                            $book_arrtibute4->book_id           = $book_create->id;
                            $book_arrtibute4->bookconditions    = $value[34];
                            $book_arrtibute4->price             = $value[35];
                            $book_arrtibute4->stock             = $value[36];
                            $book_arrtibute4->book_weight       = $value[37];
                            $book_arrtibute1->sku_number        = $value[38];
                            $book_arrtibute4->save();
                        }

                        if ($value[39]) {
                            $BookVarient5Check = BookVarient::where('book_id', $book_create->id)->where('bookconditions',$value[39])->first();
                            if ($BookVarient5Check) {
                                $book_arrtibute5                = BookVarient::find($BookVarient5Check->id);
                            }
                            else
                            {
                                $book_arrtibute5                = new BookVarient();
                            }
                            $book_arrtibute5->book_id           = $book_create->id;
                            $book_arrtibute5->bookconditions    = $value[39];
                            $book_arrtibute5->price             = $value[40];
                            $book_arrtibute5->stock             = $value[41];
                            $book_arrtibute5->book_weight       = $value[42];
                            $book_arrtibute1->sku_number        = $value[43];
                            $book_arrtibute5->save();
                        }

                    }

                }
                
            }
        }
        
    }
}
