<?php

namespace App\Helpers;

use App\Models\Books;
use App\Models\BookVarient;
use Illuminate\Support\Facades\DB;
use VARIANT;

class SkuHelper
{
    /**
     * SKU prefix
     */
    const PREFIX = 'UDB-';

    /**
     * Starting SKU number
     */
    const START_NUMBER = 100000001;


    /**
     * Get all used SKU numbers from books + book_price.
     */
    public static function getUsedNumbers()
    {
        $numbers = collect();

        // Books table SKU
        $bookSkus = Books::whereNotNull('sku')
            ->where('sku', '!=', '')
            ->pluck('sku');

        foreach ($bookSkus as $sku) {

            $number = self::extractNumber($sku);

            if ($number !== null) {
                $numbers->push($number);
            }
        }


        // Book Price table SKU
        $variantSkus = BookVarient::whereNotNull('sku_number')
            ->where('sku_number', '!=', '')
            ->pluck('sku_number');

        foreach ($variantSkus as $sku) {

            $number = self::extractNumber($sku);

            if ($number !== null) {
                $numbers->push($number);
            }
        }


        return $numbers
            ->unique()
            ->sort()
            ->values();
    }


    /**
     * Extract numeric part from UDB SKU.
     */
    public static function extractNumber($sku)
    {
        if (!$sku) {
            return null;
        }

        if (!preg_match('/^UDB-(\d+)$/i', trim($sku), $matches)) {
            return null;
        }

        return (int) $matches[1];
    }


    /**
     * Generate next available UDB SKU.
     */
    public static function generate()
    {
        $usedNumbers = self::getUsedNumbers();

        $number = self::START_NUMBER;

        foreach ($usedNumbers as $usedNumber) {

            if ($usedNumber < $number) {
                continue;
            }

            if ($usedNumber == $number) {
                $number++;
                continue;
            }

            // Gap found
            if ($usedNumber > $number) {
                break;
            }
        }

        return self::PREFIX . $number;
    }


    /**
     * Check whether SKU exists anywhere.
     */
    public static function exists($sku)
    {
        if (!$sku) {
            return false;
        }

        $sku = trim($sku);

        return Books::where('sku', $sku)->exists()
            ||
            BookVarient::where('sku_number', $sku)->exists();
    }


    /**
     * Check valid UDB SKU.
     */
    public static function isValidUdbSku($sku)
    {
        return preg_match(
            '/^UDB-\d{9}$/i',
            trim($sku)
        );
    }


    public static function resolve($sku = null)
    {
        $sku = trim((string) $sku);

        // Empty SKU
        if ($sku === '') {
            return self::generate();
        }


        // Non UDB SKU
        if (!self::isValidUdbSku($sku)) {
            return self::generate();
        }


        // Already exists
        if (self::exists($sku)) {
            throw new \Exception(
                'Duplicate SKU: ' . $sku
            );
        }


        return strtoupper($sku);
    }
}