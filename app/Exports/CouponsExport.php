<?php

namespace App\Exports;

use App\Models\Author;
use App\Models\Book;
use App\Models\BookCondition;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CouponsExport implements
    FromCollection,
    WithHeadings,
    ShouldAutoSize,
    WithStyles
{
    public function collection()
    {
        return Coupon::get()->map(function ($coupon) {

            // Author Names
            $authorNames = '-';
            if (!empty($coupon->author_ids)) {

                $authorIds = is_array($coupon->author_ids)
                    ? $coupon->author_ids
                    : json_decode($coupon->author_ids, true);

                if (!empty($authorIds)) {
                    $authorNames = Author::where('id', $authorIds)
                        ->pluck('author')
                        ->implode(', ');
                }
            }

            // Product Names
            $productNames = '-';
            if (!empty($coupon->product_ids)) {

                $productIds = is_array($coupon->product_ids)
                    ? $coupon->product_ids
                    : json_decode($coupon->product_ids, true);

                if (!empty($productIds)) {
                    $productNames = Book::whereIn('id', $productIds)
                        ->pluck('name')
                        ->implode(', ');
                }
            }

            // Book Condition Names
            $bookConditionNames = '-';
            if (!empty($coupon->book_condition_ids)) {

                $conditionIds = is_array($coupon->book_condition_ids)
                    ? $coupon->book_condition_ids
                    : json_decode($coupon->book_condition_ids, true);

                if (!empty($conditionIds)) {
                    $bookConditionNames = BookCondition::where('id', $conditionIds)
                        ->pluck('name')
                        ->implode(', ');
                }
            }

            // Exclusion Product Names
            $exclusionProducts = '-';
            if (!empty($coupon->exclusion_product_ids)) {

                $exclusionIds = is_array($coupon->exclusion_product_ids)
                    ? $coupon->exclusion_product_ids
                    : json_decode($coupon->exclusion_product_ids, true);

                if (!empty($exclusionIds)) {
                    $exclusionProducts = Book::whereIn('id', $exclusionIds)
                        ->pluck('name')
                        ->implode(', ');
                }
            }

            return [
                'ID'                     => $coupon->id,
                'Coupon Code'           => $coupon->name,
                'Coupon Name'           => $coupon->coupon_name,
                'Free Shipping'         => $coupon->is_free_shipping ? 'Yes' : 'No',
                'Accept Other Coupons'  => $coupon->is_accept_other_coupons ? 'Yes' : 'No',
                'Amount'                => $coupon->amount,
                'Maximum Discount'      => $coupon->maxi_discount,
                'Amount Type'           => $coupon->amounttype,
                'Coupon Limit User'     => $coupon->coupon_limit_user,

                // Actual Names
                'Products'              => $productNames,
                'Authors'               => $authorNames,
                'Book Conditions'       => $bookConditionNames,
                'Category'              => optional(Category::find($coupon->category_id))->category_name ?? '-',
                'Sub Category'          => optional(Category::find($coupon->subcategory_id))->subcategory_name ?? '-',
                'Child Category'        => optional(Category::find($coupon->childcategory_id))->childcategory_name ?? '-',
                'Exclusion Category'    => optional(Category::find($coupon->exclusion_category_id))->category_name ?? '-',
                'Excluded Products'     => $exclusionProducts,

                'Description'           => $coupon->description,
                'All Time'              => $coupon->all_time ? 'Yes' : 'No',
                'Start Date'            => $coupon->start_date,
                'End Date'              => $coupon->end_date,
                'Details'               => $coupon->details,
                'Status'                => $coupon->status ? 'Active' : 'Inactive',
                'Limit User'            => $coupon->limit_user,

                // User Names
                'Created By'            => optional(User::find($coupon->created_by))->name ?? '-',
                'Updated By'            => optional(User::find($coupon->updated_by))->name ?? '-',

                'Created At'            => $coupon->created_at,
                'Updated At'            => $coupon->updated_at,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Coupon Code',
            'Coupon Name',
            'Free Shipping',
            'Accept Other Coupons',
            'Amount',
            'Maximum Discount',
            'Amount Type',
            'Coupon Limit User',
            'Products',
            'Authors',
            'Book Conditions',
            'Category',
            'Sub Category',
            'Child Category',
            'Exclusion Category',
            'Excluded Products',
            'Description',
            'All Time',
            'Start Date',
            'End Date',
            'Details',
            'Status',
            'Limit User',
            'Created By',
            'Updated By',
            'Created At',
            'Updated At'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:AB1')->getFont()->setBold(true);
        $sheet->getStyle('A1:AB1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle(
            $sheet->calculateWorksheetDimension()
        )->getAlignment()->setWrapText(true);

        $sheet->getStyle(
            $sheet->calculateWorksheetDimension()
        )->getAlignment()->setVertical('center');

        return [];
    }
}