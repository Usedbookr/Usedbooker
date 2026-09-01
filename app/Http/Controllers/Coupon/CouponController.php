<?php

namespace App\Http\Controllers\Coupon;

use App\Exports\CouponsExport;
use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\BookCondition;
use App\Models\Books;
use App\Models\Category;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class CouponController extends Controller
{
    // ==========================
    // All Coupons
    // ==========================
    public function All()
    {
        $coupons = Coupon::latest()->get();

        return view('backend.coupon.all', compact('coupons'));
    }

    // ==========================
    // Add Coupon Page
    // ==========================
    public function Add()
    {
        $categories = Category::where('level',1)->where('status', 1)
            ->latest()
            ->get();

        $products = Books::latest()->get();
        $authors = Books::select('author')
            ->whereNotNull('author')
            ->where('author', '!=', '')
            ->distinct()
            ->pluck('author');
        $book_conditions = BookCondition::latest()->get();

        $child_categories = Category::where('level', 3)
            ->where('status', 1)
            ->where('level',3)
            ->get();

        return view(
            'backend.coupon.add',
            compact(
                'categories',
                'products',
                'authors',
                'book_conditions',
                'child_categories'
            )
        );
    }

    // ==========================
    // Store Coupon
    // ==========================
    public function Store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:coupons,name',
            'amount' => 'required|numeric|min:0',
            'details' => 'required|numeric|min:0',
            'limit_user' => 'required|numeric|min:1',
            'coupon_limit_user' => 'nullable|numeric|min:1',
            'maxi_discount' => 'nullable|numeric|min:0',
            'amounttype' => 'required',
            'status' => 'required',
            'first_time_buyer' => 'nullable|in:1',
        ]);

        Coupon::create([
            'name' => strtoupper($request->name),
            'amount' => $request->amount,
            'amounttype' => $request->amounttype,
            'details' => $request->details,
            'status' => $request->status,
            'limit_user' => $request->limit_user,
            'coupon_limit_user' => $request->coupon_limit_user ?? 1,
            'maxi_discount' => $request->maxi_discount ?? 0,
            'category_id' => $request->category_id,
            'exclusion_category_id' => $request->exclusion_category_id ?? 0,
            'subcategory_id' => $request->subcategory_id,
            'childcategory_id' => $request->childcategory_id,
            'is_free_shipping' => $request->it_free_ship ? 1 : 0,
            'coupon_name' => $request->coupon_name,
            'first_time_buyer' => $request->first_time_buyer ? 1 : 0,
            'is_accept_other_coupons' => $request->is_accept_other_coupons ? 1 : 0,
            'product_ids' => $request->product_ids
                ? json_encode($request->product_ids)
                : null,

            'exclusion_product_ids' => $request->exclusion_product_ids
                ? json_encode($request->exclusion_product_ids)
                : null,

            'author_ids' => $request->author_ids
                ? json_encode($request->author_ids)
                : null,

            'book_condition_ids' => !empty($request->book_condition_ids)
                ? json_encode($request->book_condition_ids)
                : null,
            'description' => $request->description,

            'all_time' => $request->all_time ? 1 : 0,

            'start_date' => $request->all_time
                ? null
                : Carbon::parse($request->start_date),

            'end_date' => $request->all_time
                ? null
                : Carbon::parse($request->end_date),
            'created_by' => Auth::id(),
            'created_at' => Carbon::now(),
        ]);

        $notification = [
            'message' => 'Coupon Added Successfully',
            'alert-type' => 'success'
        ];

        return redirect()
            ->route('coupons.all')
            ->with($notification);
    }

    // ==========================
    // Edit Coupon
    // ==========================
    public function Edit($id)
    {
        $edit = Coupon::findOrFail($id);
        $categories = Category::where('level',1)->where('status', 1)
            ->latest()
            ->get();
        $products = Books::latest()->get();
        $authors = Books::select('author')
            ->whereNotNull('author')
            ->where('author', '!=', '')
            ->distinct()
            ->pluck('author');
        $book_conditions = BookCondition::latest()->get();

        $child_categories = Category::where('level', 3)
            ->where('level',3)
            ->where('status', 1)
            ->get();

        return view(
            'backend.coupon.edit',
            compact(
                'edit',
                'categories',
                'products',
                'authors',
                'book_conditions',
                'child_categories'
            )
        );
    }

    public function Update(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:coupons,name,' . $request->id,
            'amount' => 'required|numeric|min:0',
            'details' => 'required|numeric|min:0',
            'limit_user' => 'required|numeric|min:1',
            'coupon_limit_user' => 'nullable|numeric|min:1',
            'maxi_discount' => 'nullable|numeric|min:0',
            'amounttype' => 'required',
            'status' => 'required',
        ]);

        $coupon = Coupon::findOrFail($request->id);

        $coupon->update([
            'name' => strtoupper($request->name),
            'amount' => $request->amount,
            'amounttype' => $request->amounttype,
            'details' => $request->details,
            'status' => $request->status,
            'limit_user' => $request->limit_user,
            'coupon_limit_user' => $request->coupon_limit_user ?? 1,
            'maxi_discount' => $request->maxi_discount ?? 0,
            'category_id' => $request->category_id,
            'exclusion_category_id' => $request->exclusion_category_id ?? 0,
            'subcategory_id' => $request->subcategory_id,
            'childcategory_id' => $request->childcategory_id,
            'is_free_shipping' => $request->it_free_ship ? 1 : 0,
            'coupon_name' => $request->coupon_name,
            'is_accept_other_coupons' => $request->it_use_other_coupons ? 1 : 0,
            'product_ids' => $request->product_ids
                ? json_encode($request->product_ids)
                : null,

            'exclusion_product_ids' => $request->exclusion_product_ids
                ? json_encode($request->exclusion_product_ids)
                : null,

            'author_ids' => $request->author_ids
                ? json_encode($request->author_ids)
                : null,

            'book_condition_ids' => !empty($request->book_condition_ids)
                ? json_encode($request->book_condition_ids)
                : null,
            'description' => $request->description,
            'all_time' => $request->all_time ? 1 : 0,
            'start_date' => $request->all_time
                ? null
                : Carbon::parse($request->start_date),

            'end_date' => $request->all_time
                ? null
                : Carbon::parse($request->end_date),
            'updated_by' => Auth::id(),
            'updated_at' => Carbon::now(),
        ]);

        $notification = [
            'message' => 'Coupon Updated Successfully',
            'alert-type' => 'success'
        ];

        return redirect()
            ->route('coupons.all')
            ->with($notification);
    }

    // ==========================
    // Delete Coupon
    // ==========================
    public function Delete($id)
    {
        Coupon::findOrFail($id)->delete();

        $notification = [
            'message' => 'Coupon Deleted Successfully',
            'alert-type' => 'success'
        ];

        return redirect()
            ->back()
            ->with($notification);
    }

    public function Download()
    {
        return Excel::download(new CouponsExport, 'coupons.xlsx');
    }
}