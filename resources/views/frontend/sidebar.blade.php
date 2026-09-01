<?php

$name = Route::currentRouteName();
$categories_level = "";
if ($name == "index.categories" || $name == "categories.search") {
    
    
    if(isset($_REQUEST['category_id']) && $_REQUEST['category_id'] != "")
    {  
        $search_category_ids = $_REQUEST['category_id'];
        $cat_id = App\Models\Category::where('id', $search_category_ids)->first();
        $categories_level = $cat_id->level;
        $categories_id = $cat_id->id;
    }
    else if(isset($categories) && $categories['level'] != "")
    {
        $categories_level = $categories['level'];
        $categories_id = $categories['id'];
    }
    else
    {
        $categories_level = "";
    }
    // dd($categories, $categories_id);
    
    if ($categories_level == 1) {
        $sub_categories = \App\Models\Category::with(['parent'])->where('parent_id', $categories_id)->where('status', 1)->get();
        $leavel_of_status = 1;
        $amount         = \App\Models\Books::where('category_id', $categories_id)->select(\DB::raw('MIN(selling_price) AS MinPrice, MAX(selling_price) AS MaxPrice'))->get();
        $discount       = \App\Models\Books::where('category_id', $categories_id)->select(\DB::raw('MIN(discount) AS MinDiscount, MAX(discount) AS MaxDiscount'))->get();
        // dd($sub_categories;
    }
    else if ($categories_level == 2) {
        $sub_categories = \App\Models\Category::with(['parent'])->where('parent_id', $categories_id)->where('status', 1)->get();
        $leavel_of_status = 2;
        
        $amount         = \App\Models\Books::where('subcategory_id', $categories_id)->select(\DB::raw('MIN(selling_price) AS MinPrice, MAX(selling_price) AS MaxPrice'))->get();
        $discount       = \App\Models\Books::where('subcategory_id', $categories_id)->select(\DB::raw('MIN(discount) AS MinDiscount, MAX(discount) AS MaxDiscount'))->get();
    }
    else if ($categories_level == 3) {
        $sub_categories = \App\Models\Category::with(['parent'])->where('id', $categories_id)->where('status', 1)->get();
        // dd($sub_categories);
        $leavel_of_status = 3;
        $amount         = \App\Models\Books::where('childcategory_id', $categories_id)->select(\DB::raw('MIN(selling_price) AS MinPrice, MAX(selling_price) AS MaxPrice'))->get();
        $discount       = \App\Models\Books::where('childcategory_id', $categories_id)->select(\DB::raw('MIN(discount) AS MinDiscount, MAX(discount) AS MaxDiscount'))->get();
    }
    else
    {
        $sub_categories = \App\Models\Category::with(['books'])->where('level', 3)->where('status', 1)->get();  
        $leavel_of_status = 4;
        $amount         = \App\Models\Books::select(\DB::raw('MIN(selling_price) AS MinPrice, MAX(selling_price) AS MaxPrice'))->get();
        $discount       = \App\Models\Books::select(\DB::raw('MIN(discount) AS MinDiscount, MAX(discount) AS MaxDiscount'))->get();
    }
}
else
{
    $sub_categories = \App\Models\Category::with(['books'])->where('level', 3)->where('status', 1)->get();  
    $leavel_of_status = 4;
    $amount         = \App\Models\Books::select(\DB::raw('MIN(selling_price) AS MinPrice, MAX(selling_price) AS MaxPrice'))->get();
    $discount       = \App\Models\Books::select(\DB::raw('MIN(discount) AS MinDiscount, MAX(discount) AS MaxDiscount'))->get();
}

// if(isset($_REQUEST['category_id']) && $_REQUEST['category_id'] != "")
// {  
//     $search_category_ids = $_REQUEST['category_id'];
//     $amount         = \App\Models\Books::where('childcategory_id', $search_category_ids)->select(\DB::raw('MIN(selling_price) AS MinPrice, MAX(selling_price) AS MaxPrice'))->get();
//     $discount       = \App\Models\Books::where('childcategory_id', $search_category_ids)->select(\DB::raw('MIN(discount) AS MinDiscount, MAX(discount) AS MaxDiscount'))->get();
    
// }
// dd($amount);
$bookcondition  = \App\Models\BookCondition::with(['varients'])->where('status', 1)->get();
$binding        = \App\Models\Binding::with(['varients'])->where('status', 1)->get();
$language       = \App\Models\Language::where('status', 1)->get();
// dd($amount['0']['MaxPrice']);
if($amount)
{
    $amount = $amount->toArray();
}
if($discount)
{
    $discount = $discount->toArray();
}
// dd();

$search_category_ids = "";
$search_condition_ids = "";
$search_language_ids = "";
$search_binding_ids = "";
$search_review = "";
$search_max_dis_value = $discount['0']['MaxDiscount'] ?? '0';
$search_min_dis_value = $discount['0']['MinDiscount'] ?? '0';
$search_h_rate_max_val = $amount['0']['MaxPrice'] ?? '0';
$search_h_rate_min_val = $amount['0']['MinPrice'] ?? '0';
// dd($search_h_rate_max_val);
if(isset($_REQUEST['category_id']) && $_REQUEST['category_id'] != "")
{  
    $search_category_ids = $_REQUEST['category_id'];
}
if(isset($_REQUEST['book_condition']) && $_REQUEST['book_condition'] != "")
{  
    $search_condition_ids = explode(',', $_REQUEST['book_condition']);
    // dd($search_condition_ids);
}
if(isset($_REQUEST['language']) && $_REQUEST['language'] != "")
{  
    $search_language_ids = explode(',', $_REQUEST['language']);
    // dd($search_language_ids);
    // $search_language_ids = $_REQUEST['language'];
}
if(isset($_REQUEST['binding']) && $_REQUEST['binding'] != "")
{  
    $search_binding_ids = $_REQUEST['binding'];
}
if(isset($_REQUEST['rating_value']) && $_REQUEST['rating_value'] != "")
{  
    $search_rating_ids = explode(',', $_REQUEST['rating_value']);
    // $search_review = $_REQUEST['rating_value'];
}
if(isset($_REQUEST['h_rate_min_val']) && $_REQUEST['h_rate_min_val'] != "" && $_REQUEST['h_rate_min_val'] != "false")
{  
    $search_h_rate_min_val = $_REQUEST['h_rate_min_val'];
    $search_h_rate_min_val = round($search_h_rate_min_val, 2);
}
if(isset($_REQUEST['h_rate_max_val']) && $_REQUEST['h_rate_max_val'] != "" && $_REQUEST['h_rate_max_val'] != "false")
{  
    $search_h_rate_max_val = $_REQUEST['h_rate_max_val'];
    $search_h_rate_max_val = round($search_h_rate_max_val, 2);
}
if(isset($_REQUEST['min_dis_value']) && $_REQUEST['min_dis_value'] != "" && $_REQUEST['min_dis_value'] != "false")
{  
    $search_min_dis_value = $_REQUEST['min_dis_value'];
    $search_min_dis_value = round($search_min_dis_value, 2);
}
if(isset($_REQUEST['max_dis_value']) && $_REQUEST['max_dis_value'] != "" && $_REQUEST['max_dis_value'] != "false")
{  
    $search_max_dis_value = $_REQUEST['max_dis_value'];
    $search_max_dis_value = round($search_max_dis_value, 2);
}
if($search_min_dis_value > 0)
{
    $search_min_dis_value = $search_min_dis_value;
}
else
{
    $search_min_dis_value = 0;
}
// dd($search_min_dis_value);
?>

<div class="col-lg-3">
    @section('css')
    <style>
      .product-list-sidebar  .price-input {
        width: 100%;
        display: flex;
        margin: 30px 0 35px;
      }
      .product-list-sidebar  .price-input .field {
        display: flex;
        width: 100%;
        height: 45px;
        align-items: center;
      }
      .product-list-sidebar  .field input {
        width: 100%;
        height: 100%;
        outline: none;
        font-size: 14px;
        margin-left: 12px;
        border-radius: 5px;
        color: #555;
        text-align: center;
        border: 1px solid #D9D9D9;
        -moz-appearance: textfield;
      }
      .product-list-sidebar  input[type="number"]::-webkit-outer-spin-button,
      .product-list-sidebar  input[type="number"]::-webkit-inner-spin-button {
        -webkit-appearance: none;
      }
      .product-list-sidebar  .price-input .separator {
        width: 130px;
        display: flex;
        font-size: 19px;
        color: #555;
        align-items: center;
        justify-content: center;
      }
      .product-list-sidebar  .slider {
        height: 5px;
        position: relative;
        background: #D9D9D9;
        border-radius: 5px;
      }
      .product-list-sidebar  .slider .progress {
        height: 100%;
        left: 25%;
        right: 25%;
        position: absolute;
        border-radius: 5px;
        background: #241D60;
      }
      .product-list-sidebar  .range-input {
        position: relative;
      }
      .product-list-sidebar  .range-input input {
        position: absolute;
        width: 100%;
        height: 5px;
        top: -5px;
        background: none;
        pointer-events: none;
        -webkit-appearance: none;
        -moz-appearance: none;
      }
      .product-list-sidebar  input[type="range"]::-webkit-slider-thumb {
        height: 17px;
        width: 17px;
        border-radius: 50%;
        background: #241D60;
        pointer-events: auto;
        -webkit-appearance: none;
        box-shadow: 0 0 6px rgba(0, 0, 0, 0.05);
      }
      .product-list-sidebar  input[type="range"]::-moz-range-thumb {
        height: 17px;
        width: 17px;
        border: none;
        border-radius: 50%;
        background: #241D60;
        pointer-events: auto;
        -moz-appearance: none;
        box-shadow: 0 0 6px rgba(0, 0, 0, 0.05);
      }


      .product-list-sidebar  .price-input1 {
        width: 100%;
        display: flex;
        margin: 30px 0 35px;
      }
      .product-list-sidebar  .price-input1 .field {
        display: flex;
        width: 100%;
        height: 45px;
        align-items: center;
      }
      .product-list-sidebar  .field input {
        width: 100%;
        height: 100%;
        outline: none;
        font-size: 14px;
        margin-left: 12px;
        border-radius: 5px;
        color: #555;
        text-align: center;
        border: 1px solid #D9D9D9;
        -moz-appearance: textfield;
      }
      .product-list-sidebar  input[type="number"]::-webkit-outer-spin-button,
      .product-list-sidebar  input[type="number"]::-webkit-inner-spin-button {
        -webkit-appearance: none;
      }
      .product-list-sidebar .price-input1 .separator {
        width: 130px;
        display: flex;
        font-size: 19px;
        color: #555;
        align-items: center;
        justify-content: center;
      }
      .product-list-sidebar  .slider1 {
        height: 5px;
        position: relative;
        background: #D9D9D9;
        border-radius: 5px;
      }
      .product-list-sidebar  .slider1 .progress1 {
        height: 100%;
        left: 25%;
        right: 25%;
        position: absolute;
        border-radius: 5px;
        background: #241D60;
      }
      .product-list-sidebar  .range-input1 {
        position: relative;
      }
      .product-list-sidebar  .range-input1 input {
        position: absolute;
        width: 100%;
        height: 5px;
        top: -5px;
        background: none;
        pointer-events: none;
        -webkit-appearance: none;
        -moz-appearance: none;
      }
      .product-list-sidebar .range-input1 input[type="range"]::-webkit-slider-thumb {
        height: 17px;
        width: 17px;
        border-radius: 50%;
        background: #241D60;
        pointer-events: auto;
        -webkit-appearance: none;
        box-shadow: 0 0 6px rgba(0, 0, 0, 0.05);
      }
      .product-list-sidebar .range-input1 input[type="range"]::-moz-range-thumb {
        height: 17px;
        width: 17px;
        border: none;
        right: 5px;
        border-radius: 50%;
        background: #241D60;
        pointer-events: auto;
        -moz-appearance: none;
        box-shadow: 0 0 6px rgba(0, 0, 0, 0.05);
      }
        .product-list-sidebar .range-input1 .h_rate_max_val {
            position: absolute;
            width: 100%;
            height: 5px;
            top: -5px;
            right: -5px;
            background: none;
            pointer-events: none;
            -webkit-appearance: none;
            -moz-appearance: none;
        }
        .product-list-sidebar .range-input1 .h_rate_min_val {
            position: absolute;
            width: 100%;
            height: 5px;
            top: -5px;
            right: 10px;
            background: none;
            pointer-events: none;
            -webkit-appearance: none;
            -moz-appearance: none;
        }
</style>
@stop
    <div class="offcanvas offcanvas-start offcanvas-collapse w-md-50 categorey-offcanvas" tabindex="-1" id="offcanvasCategory" aria-labelledby="offcanvasCategoryLabel">
        <div class="offcanvas-header d-lg-none">
            <h5 class="offcanvas-title" id="offcanvasCategoryLabel">Filters</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>

        <div class="offcanvas-body ps-lg-2 pt-lg-0">
            <div class="categorey-filter-box">
                <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Categories
                        </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                        <div class="accordion-body" style="height: 400px;overflow-x: hidden;">
                            <div class="row gy-3">
                                @if($leavel_of_status == 1)
                                @if(count($sub_categories) > 0)
                                @foreach($sub_categories as $sub_category)
                                
                                @if(isset($sub_category->parent))
                                @foreach($sub_category->parent as $category)
                                <?php
                                    // dd($categories_level);
                                    // $count_book = \App\Models\Books::where('childcategory_id', $category->id)->whereIn('id', $expertusersid_arr)->get();
                                    if ($categories_level == 1 || $categories_level == 2 || $categories_level == 3) {
                                        $count_book = \App\Models\Books::where('childcategory_id', $category->id)->where('status', 1)->get();
                                    }
                                    else
                                    {
                                        $count_book = \App\Models\Books::where('childcategory_id', $category->id)->whereIn('id', $expertusersid_arr)->get();
                                    }
                                    // dd($count_book);
                                ?>
                                <div class="col-lg-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="category_check" onchange="search_expert()" value="{{ $category->id }}" @if($search_category_ids == $category->id) checked @endif>
                                        <label class="form-check-label">
                                            {{ $category->name }} <span>({{ count($count_book)}})</span>
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                                @endif
                                @endforeach
                                @endif
                                @elseif($leavel_of_status == 2)
                                @if(count($sub_categories) > 0)
                                @foreach($sub_categories as $category)
                                
                                <?php
                                    if ($categories_level == 1 || $categories_level == 2 || $categories_level == 3) {
                                        $count_book = \App\Models\Books::where('childcategory_id', $category->id)->get();
                                    }
                                    else
                                    {
                                        $count_book = \App\Models\Books::where('childcategory_id', $category->id)->whereIn('id', $expertusersid_arr)->get();
                                    }
                                    
                                ?>
                                <div class="col-lg-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="category_check" onchange="search_expert()" value="{{ $category->id }}" @if($search_category_ids == $category->id) checked @endif>
                                        <label class="form-check-label">
                                            {{ $category->name }} <span>({{ count($count_book)}})</span>
                                        </label>
                                    </div>
                                </div>
                                
                                @endforeach
                                @endif
                                @elseif($leavel_of_status == 3)
                                
                                @if(count($sub_categories) > 0)
                                @foreach($sub_categories as $category)
                                @if($search_category_ids == $category->id)
                                <?php
                                    $count_book = \App\Models\Books::where('childcategory_id', $category->id)->whereIn('id', $expertusersid_arr)->get();
                                ?>
                                <div class="col-lg-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="category_check" onchange="search_expert()" value="{{ $category->id }}" @if($search_category_ids == $category->id) checked @endif>
                                        <label class="form-check-label">
                                            {{ $category->name }} <span>({{ count($count_book)}})</span>
                                        </label>
                                    </div>
                                </div>
                                @endif
                                @if($search_category_ids == "")
                                <?php
                                    if ($categories_level == 1 || $categories_level == 2 || $categories_level == 3) {
                                        $count_book = \App\Models\Books::where('childcategory_id', $category->id)->get();
                                    }
                                    else
                                    {
                                        $count_book = \App\Models\Books::where('childcategory_id', $category->id)->whereIn('id', $expertusersid_arr)->get();
                                    }
                                    // dd($leavel_of_status);
                                ?>
                                <div class="col-lg-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="category_check" onchange="search_expert()" value="{{ $category->id }}" @if($leavel_of_status == 3) checked @endif>
                                        <label class="form-check-label" >
                                            {{ $category->name }} <span>({{ count($count_book)}})</span>
                                        </label>
                                    </div>
                                </div>
                                @endif
                                @endforeach
                                @endif
                                @else
                                @if(count($sub_categories) > 0)
                                @foreach($sub_categories as $category)
                                @if($search_category_ids == $category->id)
                                <?php
                                    if ($categories_level == 1 || $categories_level == 2 || $categories_level == 3) {
                                        $count_book = \App\Models\Books::where('childcategory_id', $category->id)->get();
                                    }
                                    else
                                    {
                                        $count_book = \App\Models\Books::where('childcategory_id', $category->id)->whereIn('id', $expertusersid_arr)->get();
                                    }
                                    // dd($category);
                                ?>
                                <div class="col-lg-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="category_check" onchange="search_expert()" value="{{ $category->id }}" @if($search_category_ids == $category->id) checked @endif>
                                        <label class="form-check-label">
                                            {{ $category->name }} <span>({{ count($count_book)}})</span>
                                        </label>
                                    </div>
                                </div>
                                @endif
                                @if($search_category_ids == "")
                                <?php
                                    if ($categories_level == 1 || $categories_level == 2 || $categories_level == 3) {
                                        $count_book = \App\Models\Books::where('childcategory_id', $category->id)->get();
                                    }
                                    else
                                    {
                                        $count_book = \App\Models\Books::where('childcategory_id', $category->id)->whereIn('id', $expertusersid_arr)->get();
                                    }
                                    // $count_book = \App\Models\Books::where('childcategory_id', $category->id)->whereIn('id', $expertusersid_arr)->get();
                                    // dd($category);
                                ?>
                                <div class="col-lg-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="category_check" onchange="search_expert()" value="{{ $category->id }}">
                                        <label class="form-check-label" >
                                            {{ $category->name }} <span>({{ count($count_book)}})</span>
                                        </label>
                                    </div>
                                </div>
                                @endif
                                @endforeach
                                @endif
                                @endif
                                
                            </div>
                        </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                            Condition
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                            <div class="row gy-3">
                                <div class="col-lg-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="condition_check[]" onchange="search_expert()" value="New" @if(isset($search_condition_ids) && is_array($search_condition_ids) && in_array("New",$search_condition_ids)) checked="" @endif>
                                        <label class="form-check-label">
                                        New 
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="condition_check[]" onchange="search_expert()" value="Almost New" @if(isset($search_condition_ids) && is_array($search_condition_ids) && in_array("Almost New",$search_condition_ids)) checked="" @endif>
                                        <label class="form-check-label">
                                        Almost New 
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="condition_check[]" onchange="search_expert()" value="Very Good" @if(isset($search_condition_ids) && is_array($search_condition_ids) && in_array("Very Good",$search_condition_ids)) checked="" @endif>
                                        <label class="form-check-label">
                                        Very Good 
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="condition_check[]" onchange="search_expert()" value="Good" @if(isset($search_condition_ids) && is_array($search_condition_ids) && in_array("Good",$search_condition_ids)) checked="" @endif>
                                        <label class="form-check-label">
                                        Good 
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="condition_check[]" onchange="search_expert()" value="Ok to Read" @if(isset($search_condition_ids) && is_array($search_condition_ids) && in_array("Ok to Read",$search_condition_ids)) checked="" @endif>
                                        <label class="form-check-label">
                                        Ok to Read 
                                        </label>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                        </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                            Languages
                        </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div class="row gy-3">
                                @if(count($language) > 0)
                                @foreach($language as $value)
                                
                                <div class="col-lg-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="language_check[]" onchange="search_expert()" value="{{ $value->name }}" @if(isset($search_language_ids) && is_array($search_language_ids) && in_array($value->name, $search_language_ids)) checked="" @endif>
                                        <label class="form-check-label">
                                        {{$value->name}} 
                                        </label>
                                    </div>
                                </div>
                                
                                @endforeach
                                @endif
                            </div>
                        </div>
                        </div>
                    </div>
                    {{-- <div class="accordion-item">
                        <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                            Billing Type
                        </button>
                        </h2>
                        <div id="collapseFour" class="accordion-collapse collapse @if($search_binding_ids) show @endif" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <div class="row gy-3">
                                @if(count($binding) > 0)
                                @foreach($binding as $value1)
                                <div class="col-lg-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="binding_check" onchange="search_expert()" value="{{ $value1->name }}" @if($search_language_ids == $value->name) checked @endif>
                                        <label class="form-check-label" >
                                        {{ $value1->name }} 
                                        </label>
                                    </div>
                                </div>
                                @endforeach
                                @endif
                                </div>
                        </div>
                        </div>
                    </div> --}}

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="true" aria-controls="collapseFive">
                           Discount
                          </button>
                        </h2>
                        <div id="collapseFive" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                          <div class="accordion-body">
                              <div class="product-list-sidebar">
                                <p class="discount-text" style="margin-bottom: 20px;">Discount is between: <span id="slider-range-value3">{{ round($search_min_dis_value) }}</span>% - <span id="slider-range-value4">{{ round($search_max_dis_value) }}</span>%</p>
                                <div class="price-input" style="display:none;">
                                  <div class="field">
                                    <input type="number" class="input-min" value="{{$search_min_dis_value}}">
                                  </div>
                                  <div class="separator">-</div>
                                  <div class="field">
                                    <input type="number" class="input-max" value="{{$search_max_dis_value}}">
                                  </div>
                                </div>
                                <div class="slider">
                                  <div class="progress"></div>
                                </div>
                                <div class="range-input">
                                  <input type="range" class="range-min" min="0" id="min_dis_value" max="{{ $discount['0']['MaxDiscount'] }}" value="{{$search_min_dis_value}}" step="1" onchange="search_expert()">
                                  <input type="range" class="range-max" min="0" id="max_dis_value" max="{{ $discount['0']['MaxDiscount'] }}" value="{{$search_max_dis_value}}" step="1" onchange="search_expert()">
                                </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      
                      <div class="accordion-item">
                        <h2 class="accordion-header">
                          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="true" aria-controls="collapseSix">
                            Price
                          </button>
                        </h2>
                        <div id="collapseSix" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                          <div class="accordion-body">
                            <div class="product-list-sidebar">
                                <p class="discount-text" style="margin-bottom: 20px;">Price is between: <span id="slider-range-value1">{{ $search_h_rate_min_val }}</span>₹ - <span id="slider-range-value2">{{ $search_h_rate_max_val }}</span>₹</p>
                                <div class="price-input1" style="display: none;">
                                  <div class="field">
                                    <input type="hidden" class="input-min1" value="{{$search_h_rate_min_val}}">
                                  </div>
                                  <div class="separator">-</div>
                                  <div class="field">
                                    <input type="hidden" class="input-max1" value="{{$search_h_rate_max_val}}">
                                  </div>
                                </div>
                                <div class="slider1">
                                  <div class="progress1"></div>
                                </div>
                                <div class="range-input1">
                                  <input type="range" class="range-min1 h_rate_min_val" min="0" id="h_rate_min_val" max="{{ $amount['0']['MaxPrice'] }}" value="{{$search_h_rate_min_val}}" step="1" onchange="search_expert()">
                                  <input type="range" class="range-max1 h_rate_max_val" min="0" id="h_rate_max_val" max="{{ $amount['0']['MaxPrice'] }}" value="{{$search_h_rate_max_val}}" step="1" onchange="search_expert()">
                                </div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="accordion-item">
                        <h2 class="accordion-header">
                          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeven" aria-expanded="true" aria-controls="collapseSeven">
                            Rating
                          </button>
                        </h2>
                        <div id="collapseSeven" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                          <div class="accordion-body">
                            <div class="row gy-3">
                                      
                                <div class="col-lg-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="5.0" name="rating_value[]" onchange="search_expert()" @if(isset($search_rating_ids) && is_array($search_rating_ids) && in_array("5.0", $search_rating_ids)) checked="" @endif>
                                        <label class="form-check-label" >
                                            <span class="star-rating">
                                                <i class="bi bi-star-fill fill-bg"></i>
                                                <i class="bi bi-star-fill fill-bg"></i>
                                                <i class="bi bi-star-fill fill-bg"></i>
                                                <i class="bi bi-star-fill fill-bg"></i>
                                                <i class="bi bi-star-fill fill-bg"></i>
                                                <span>5.0</span>
                                            </span> 
                                          
                                        </label>
                                      </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="4.0" name="rating_value[]" onchange="search_expert()" @if(isset($search_rating_ids) && is_array($search_rating_ids) && in_array("4.0", $search_rating_ids)) checked="" @endif>
                                        <label class="form-check-label" >
                                            <span class="star-rating">
                                                <i class="bi bi-star-fill fill-bg"></i>
                                                <i class="bi bi-star-fill fill-bg"></i>
                                                <i class="bi bi-star-fill fill-bg"></i>
                                                <i class="bi bi-star-fill fill-bg"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <span>4.0</span>
                                            </span> 
                                            
                                        </label>
                                      </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="3.0" name="rating_value[]" onchange="search_expert()" @if(isset($search_rating_ids) && is_array($search_rating_ids) && in_array("3.0", $search_rating_ids)) checked="" @endif>
                                        <label class="form-check-label" >
                                            <span class="star-rating">
                                                <i class="bi bi-star-fill fill-bg"></i>
                                                <i class="bi bi-star-fill fill-bg"></i>
                                                <i class="bi bi-star-fill fill-bg"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                 <span>3.0</span>
                                            </span> 
                                           
                                        </label>
                                      </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="2.0" name="rating_value[]" onchange="search_expert()" @if(isset($search_rating_ids) && is_array($search_rating_ids) && in_array("2.0", $search_rating_ids)) checked="" @endif>
                                        <label class="form-check-label" >
                                            <span class="star-rating">
                                                <i class="bi bi-star-fill fill-bg"></i>
                                                <i class="bi bi-star-fill fill-bg"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <span>2.0</span>
                                            </span> 
                                           
                                        </label>
                                      </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="1.0" name="rating_value[]" onchange="search_expert()" @if(isset($search_rating_ids) && is_array($search_rating_ids) && in_array("1.0", $search_rating_ids)) checked="" @endif>
                                        <label class="form-check-label" >
                                            <span class="star-rating">
                                                <i class="bi bi-star-fill fill-bg"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <i class="bi bi-star-fill"></i>
                                                <span>1.0</span>
                                            </span> 
                                           
                                        </label>
                                      </div>
                                </div>
                               </div>
                          </div>
                        </div>
                      </div>
                      <div class="row" style="justify-content: center;">
                          <a href="{{ route('categories.search') }}" style="border: 1px solid #FFD731 !important;background: #FFD731;font-size: 15px;font-weight: 600;color: #30844A;border-radius: 30px;padding: 12px 70px;box-shadow: 1px 2px 6px 0px #00000040;width: 200px;margin: 10px 0px;">Reset</a> 
                      </div>
                    <!-- Search Conditons -->
                    
                    <!-- Search Conditons -->
                    
                </div>
            </div>
            </div>
        </div>

    
</div>

<script>
    var expert_search_url = "{{ url('/') }}/search/";
    // alert(category_id);
        
    function search_expert()
    {
        var categories_id = "{{ $categories['id'] ?? '' }}";
        var search_category_234 = "{{ $search_category_ids ?? '' }}";

        var category_id122 = $('input[name="category_check"]:checked').map(function()
            {
                return $(this).val();
            }).get();

        // alert(category_id122);
        if(categories_id)
        {
            var category_id = categories_id;
        }
        else if(search_category_234)
        {
            var category_id = search_category_234;
        }
        if (category_id122) 
        {
            var category_id = category_id122;
        }
        
        var book_condition = $('input[name="condition_check[]"]:checked').map(function()
        {
            return $(this).val();
        }).get();
        var language_check = $('input[name="language_check[]"]:checked').map(function()
        {
            return $(this).val();
        }).get();
        var binding_check = $('input[name="binding_check"]:checked').map(function()
        {
            return $(this).val();
        }).get();
        var rating_value = $('input[name="rating_value[]"]:checked').map(function()
        {
            return $(this).val();
        }).get();
        
        var stock_check = $('input[name="stock_check"]:checked').map(function()
        {
            return $(this).val();
        }).get();

        var h_rate_min_val = $('#h_rate_min_val').val();
        var h_rate_max_val = $('#h_rate_max_val').val();
        var min_dis_value  = $('#min_dis_value').val();
        var max_dis_value  = $('#max_dis_value').val();
        var sort_books     = $('#sort_books').val();
        var stock_check    = stock_check;
        
        // if (h_rate_min_val != 0) {
        //     var h_rate_min_val = $('#h_rate_min_val').val();
        //     var h_rate_max_val = $('#h_rate_max_val').val();
        // }
        // else
        // {
        //     var h_rate_min_val = "";
        //     var h_rate_max_val = "";
        // }
        // alert(book_condition);

        var str_search_request   = "category_id="+category_id+"&book_condition="+book_condition+"&language="+language_check+"&binding="+binding_check+"&h_rate_min_val="+h_rate_min_val+"&h_rate_max_val="+h_rate_max_val+"&min_dis_value="+min_dis_value+"&max_dis_value="+max_dis_value+"&rating_value="+rating_value+"&sort_books="+sort_books+"&stock_check="+stock_check;
        // alert(str_search_request);
        if(str_search_request){
            window.location.href = expert_search_url + '?' + str_search_request;
        }

    }
</script>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const rangeInput = document.querySelectorAll(".range-input input"),
      priceInput = document.querySelectorAll(".price-input input"),
      range = document.querySelector(".slider .progress");
    let priceGap = 1;
    // alert(range);
    function updateRangeStyle(min, max) {
      range.style.left = (min / rangeInput[0].max) * 100 + "%";
      range.style.right = 100 - (max / rangeInput[1].max) * 100 + "%";
    }

    priceInput.forEach((input) => {
      input.addEventListener("input", (e) => {

        let minPrice = parseInt(priceInput[0].value),
          maxPrice = parseInt(priceInput[1].value);

            if (maxPrice - minPrice >= priceGap && maxPrice <= rangeInput[1].max) {
              if (e.target.className === "input-min") {
                rangeInput[0].value = minPrice;
              } else {
                rangeInput[1].value = maxPrice;
              }
              updateRangeStyle(minPrice, maxPrice);
            } else {
              if (e.target.className === "input-min") {
                priceInput[0].value = rangeInput[0].value;
              } else {
                priceInput[1].value = rangeInput[1].value;
              }
            }
      });
    });

    rangeInput.forEach((input) => {
      input.addEventListener("input", (e) => {
        let minVal = parseInt(rangeInput[0].value),
          maxVal = parseInt(rangeInput[1].value);

        if (maxVal - minVal < priceGap) {
          if (e.target.className === "range-min") {
            rangeInput[0].value = maxVal - priceGap;
          } else {
            rangeInput[1].value = minVal + priceGap;
          }
        } else {
          priceInput[0].value = minVal;
          priceInput[1].value = maxVal;
          $("#slider-range-value3").html(minVal);
          $("#slider-range-value4").html(maxVal);
          updateRangeStyle(minVal, maxVal);
          // range.style.left = (minVal / rangeInput[0].max) * 100 + "%";
          // range.style.right = 100 - (maxVal / rangeInput[1].max) * 100 + "%";
        }
      });
    });
    // Initialize range styles and values
    updateRangeStyle(parseInt(priceInput[0].value), parseInt(priceInput[1].value));
    // updateHiddenFields(parseInt(priceInput[0].value), parseInt(priceInput[1].value));
  });
</script>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const rangeInput1 = document.querySelectorAll(".range-input1 input"),
      priceInput1 = document.querySelectorAll(".price-input1 input"),
      range1 = document.querySelector(".slider1 .progress1");
    let priceGap1 = 1;
    // alert(priceGap1);
    function updateRangeStyle1(min, max) {
        // alert(max);
      range1.style.left = (min / rangeInput1[0].max) * 100 + "%";
      range1.style.right = 100 - (max / rangeInput1[1].max) * 100 + "%";
    }

    priceInput1.forEach((input) => {
      input.addEventListener("input", (e) => {
        let minPrice1 = parseInt(priceInput1[0].value),
          maxPrice1 = parseInt(priceInput1[1].value);

        if (maxPrice1 - minPrice1 >= priceGap1 && maxPrice1 <= rangeInput1[1].max) {
          if (e.target.className === "input-min1") {
            rangeInput1[0].value = minPrice;
          } else {
            rangeInput1[1].value = maxPrice;
          }
          updateRangeStyle1(minPrice1, maxPrice1);
        } else {
          if (e.target.className === "input-min1") {
            priceInput1[0].value = rangeInput1[0].value;
          } else {
            priceInput1[1].value = rangeInput1[1].value;
          }
        }

      });
    });

    rangeInput1.forEach((input) => {
      input.addEventListener("input", (e) => {
        let minVal1 = parseInt(rangeInput1[0].value),
          maxVal1 = parseInt(rangeInput1[1].value);

        if (maxVal1 - minVal1 < priceGap1) {
          if (e.target.className === "range-min1") {
            rangeInput1[0].value = maxVal1 - priceGap1;
          } else {
            rangeInput1[1].value = minVal1 + priceGap1;
          }
        } else {
          priceInput1[0].value = minVal1;
          priceInput1[1].value = maxVal1;
          $("#slider-range-value1").html(minVal1);
          $("#slider-range-value2").html(maxVal1);
          updateRangeStyle1(minVal1, maxVal1);
          
        }
      });
    });
    // Initialize range styles and values
    updateRangeStyle1(parseInt(priceInput1[0].value), parseInt(priceInput1[1].value));
    
});
</script>
@section('css')
<style type="text/css">
    .product-list .categorey-filter-box .form-check .form-check-input:checked
    {
        border-color: #241d60;
        background: #241d60;
    }

    .product-list .categorey-filter-box .form-check-input:checked[type=checkbox] {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20'%3e%3cpath fill='none' stroke='%23fff' stroke-linecap='round' stroke-linejoin='round' stroke-width='3' d='m6 10 3 3 6-6'/%3e%3c/svg%3e");
</style>
@stop