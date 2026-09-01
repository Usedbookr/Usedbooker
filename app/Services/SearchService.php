<?php

namespace App\Services;


use App\Models\Books;
use App\Models\Category;
use App\Models\Book;

/**
 * Class SearchService.
 */
class SearchService
{
    public function make_filer_search( $arr_data = [] )
	{
        $book_details = Books::with(['varients', 'binding', 'review'])->where('status', 1);

        $arr_condition_check = $arr_language_check = [];

        if(isset($arr_data['book_condition']) && $arr_data['book_condition']!="")
        {
            $arr_condition_check = explode(',',$arr_data['book_condition']);
        }
        if(isset($arr_data['language']) && $arr_data['language']!="")
        {
            $arr_language_check = explode(',',$arr_data['language']);
        }
        if(isset($arr_data['rating_value']) && $arr_data['rating_value']!="")
        {
            $arr_rating_value_check = explode(',',$arr_data['rating_value']);
        }
        
        if(isset($arr_data['stock_check']) && $arr_data['stock_check']!="")
        {
            $arr_stock_check = $arr_data['stock_check'];
        }

        // dd($arr_data);
        
        if ($book_details) {
            if(isset($arr_data['category_id']) && $arr_data['category_id'] != "")
            {
                $cat_chec = Category::where('id', $arr_data['category_id'])->first();
                // dd($cat_chec);
                if($cat_chec->level == 1)
                {
                    $category1      = $arr_data['category_id'];
                    $book_details = $book_details->where('category_id', $category1);
                }
                else if($cat_chec->level == 2)
                {
                    $category1      = $arr_data['category_id'];
                    $book_details = $book_details->where('subcategory_id', $category1);
                }
                else
                {
                    $category1      = $arr_data['category_id'];
                    $book_details = $book_details->where('childcategory_id', $category1);
                }
            }
            if(isset($arr_data['book_condition']) && $arr_data['book_condition'] != "")
            {
                
                $book_condition      = $arr_condition_check;
                // dd($book_condition);
                $book_details = $book_details->whereHas('varients', function ($query) use ($book_condition){
                    $query->whereIn('bookconditions', $book_condition);
                });
            }
            
            if(isset($arr_data['language']) && $arr_data['language'] != "")
            {
                $language_check      = $arr_language_check;
                $book_details = $book_details->whereIn('language', $language_check);
            }
            
            if(isset($arr_data['h_rate_min_val']) && $arr_data['h_rate_max_val'] != "")
            {
                // $language_check      = $arr_data['language'];
                $book_details = $book_details->whereBetween('selling_price', array($arr_data['h_rate_min_val'], $arr_data['h_rate_max_val']));
            }
            if(isset($arr_data['min_dis_value']) && $arr_data['max_dis_value'] != "")
            {
                $min_dis_value      = $arr_data['max_dis_value'];
                // dd($min_dis_value);
                $book_details = $book_details->whereBetween('discount', array($arr_data['min_dis_value'], $arr_data['max_dis_value']));
            }
            if(isset($arr_data['rating_value']) && $arr_data['rating_value'] != "")
            {
                $rating      = $arr_rating_value_check;
                $book_details = $book_details->whereHas('review', function ($query) use ($rating){
                    $query->whereIn('rating', $rating);
                });
            }
            
            if(isset($arr_data['stock_check']) && $arr_data['stock_check'] != "")
            {
                $stock_check      = $arr_data['stock_check'];
                // dd($stock_check);
                $book_details = $book_details->whereHas('varients', function ($query) use ($stock_check){
                    $query->where('stock', '!=', 0);
                });
            }
            
            if(isset($arr_data['sort_books']) && $arr_data['sort_books'] != "")
            {
                
                $sort_by      = $arr_data['sort_books'];
                // dd($sort_by);
                if ($sort_by == "alphp_a") {
                    // dd("1");
                    $book_details = $book_details->orderBy('name', 'ASC');
                    // $books = $books->orderBy('name', 'ASC')->get();
                }
                else if ($sort_by == "alphp_z")
                {
                    // dd("2");
                    $book_details = $book_details->orderBy('name', 'DESC');
                    // $books = $books->orderBy('name', 'DESC')->get();
                }
                else if ($sort_by == "low_to_hight")
                {
                    // dd("3");
                    $book_details = $book_details->orderBy('selling_price', 'ASC');
                    // $books = $books->orderBy('selling_price', 'ASC')->get();
                }
                else if ($sort_by == "hight_to_low")
                {
                    // dd("4");
                    $book_details = $book_details->orderBy('selling_price', 'DESC');
                    // $books = $books->orderBy('selling_price', 'DESC')->get();
                }
                else if ($sort_by == "latest")
                {
                    // dd("5");
                    $book_details = $book_details->latest();
                    // $books = $books->latest()->get();
                }
                else
                {
                    // dd("6");
                    $book_details = $book_details;
                    // $books = $books->get();
                }
                // dd($book_details);
            }
            $book_details1 = $book_details->get();
            $book_details = $book_details->paginate(52);
            // $book_details1 = $book_details;

        }
        $data['book_details'] = $book_details;
        $data['book_details1'] = $book_details1;
        return $data;
        // dd($book_details);
    }
}
