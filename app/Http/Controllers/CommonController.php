<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Category;
use App\Models\Binding;
use App\Models\BookCondition;
use App\Models\Payment;
use App\Models\Order;

class CommonController extends Controller
{
    public function subcategories(Request $request)
    {
        $data['subcategory'] = Category::Where('parent_id',$request->id)->get();
        return response()->json($data);
    }
    
    public function childcategories(Request $request)
    {
        $data['childcategory'] = Category::Where('parent_id',$request->id)->get();
        return response()->json($data);
    }
    
    public function bindings(Request $request)
    {
        $data['bindings'] = Binding::Where('status',1)->get();
        return response()->json($data);
    }
    
    public function bookconditions(Request $request)
    {
        $data['condition_types'] = BookCondition::Where('status',1)->get();
        return response()->json($data);
    }


}
 