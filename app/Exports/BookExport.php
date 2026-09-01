<?php

namespace App\Exports;

use App\Models\Books;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class BookExport implements FromQuery, WithHeadings, WithMapping, WithChunkReading
{
    public function query()
    {
        return Books::query()
            ->with('varients')
            ->orderBy('id');
    }

    /**
     * Excel headings
     */
    public function headings(): array
    {
        return [
            // Book details
            'Book ID',
            'Book Name',
            'Author',
            'Listed By',
            'ISBN',
            'ISBN13',

            'MRP',
            'Selling Price',
            'Discount',

            'Publisher',
            'Date Published',
            'Pages',
            'Dimensions',
            'Language',

            'Category ID',
            'Sub Category ID',
            'Child Category ID',

            'SKU',
            'HSN Code',
            'GST Charge',

            'Section ID',
            'Description',
            'Synopsis',

            'Meta Name',
            'Meta Description',
            'Meta Keyword',
            'URL Slug',

            'Image',
            'Multi Image',

            'Status',

            'Created At',
            'Updated At',

            // Variant details
            'Variant ID',
            'Book Condition',
            'Variant Price',
            'Variant Stock',
            'Book Weight (Gram)',
            'Variant SKU',
            'Variant Images',
            'Variant Created At',
            'Variant Updated At',
        ];
    }

    /**
     * Map book + variants
     */
    public function map($book): array
    {
        /*
        |--------------------------------------------------------------------------
        | No variants
        |--------------------------------------------------------------------------
        */

        if ($book->varients->isEmpty()) {

            return [[
                $book->id,
                $book->name,
                $book->author,
                $book->listed_by,
                $book->isbn,
                $book->isbn13,

                $book->original_price,
                $book->selling_price,
                $book->discount,

                $book->publisher,
                $book->date_published,
                $book->pages,
                $book->dimensions,
                $book->language,

                $book->category_id,
                $book->subcategory_id,
                $book->childcategory_id,

                $book->sku,
                $book->hsn_code,
                $book->gst_charge,

                $book->section_id,
                $book->title_long,
                $book->synopsis,

                $book->meta_name,
                $book->meta_description,
                $book->meta_keyword,
                $book->url_slug,

                $book->image,
                $book->multi_image,

                $book->status,

                $book->created_at,
                $book->updated_at,

                // Variant
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
            ]];
        }

        /*
        |--------------------------------------------------------------------------
        | Book has variants
        |--------------------------------------------------------------------------
        |
        | One variant = one Excel row
        |
        */

        $rows = [];

        foreach ($book->varients as $variant) {

            $rows[] = [
                $book->id,
                $book->name,
                $book->author,
                $book->listed_by,
                $book->isbn,
                $book->isbn13,

                $book->original_price,
                $book->selling_price,
                $book->discount,

                $book->publisher,
                $book->date_published,
                $book->pages,
                $book->dimensions,
                $book->language,

                $book->category_id,
                $book->subcategory_id,
                $book->childcategory_id,

                $book->sku,
                $book->hsn_code,
                $book->gst_charge,

                $book->section_id,
                $book->title_long,
                $book->synopsis,

                $book->meta_name,
                $book->meta_description,
                $book->meta_keyword,
                $book->url_slug,

                $book->image,
                $book->multi_image,

                $book->status,

                $book->created_at,
                $book->updated_at,

                // Variant
                $variant->id,
                $variant->bookconditions,
                $variant->price,
                $variant->stock,
                $variant->book_weight,
                $variant->sku_number,
                $variant->images,
                $variant->created_at,
                $variant->updated_at,
            ];
        }

        return $rows;
    }

    /**
     * Chunk size
     */
    public function chunkSize(): int
    {
        return 100;
    }
}