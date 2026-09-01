<?php

namespace App\Helpers;

use App\Models\Book;

class ShippingHelper
{
    /*
    |--------------------------------------------------------------------------
    | Shipping Configuration
    |--------------------------------------------------------------------------
    */

    public const FREE_SHIPPING_THRESHOLD = 599;

    public const DEFAULT_BOOK_WEIGHT = 250;       // grams
    public const TEXTBOOK_DEFAULT_WEIGHT = 600;   // grams

    public const HEAVY_WEIGHT_THRESHOLD = 500;   // grams
    public const HEAVY_BOOK_SURCHARGE = 29;

    public const COD_CHARGE = 39;

    public const SHIPPING_UPTO_500 = 49;
    public const SHIPPING_501_TO_1000 = 69;
    public const SHIPPING_ABOVE_1000 = 89;


    /**
     * Calculate complete shipping details.
     *
     * $cartItems = AddCart collection
     * $cartValue = product subtotal
     * $paymentMethod = COD / prepaid
     */
    public static function calculate(
        $cartItems,
        float $cartValue = 0,
        ?string $paymentMethod = null
    ): array {

        $totalWeight = 0;

        $heavyBookCount = 0;

        $items = [];


        foreach ($cartItems as $cart) {

            $book = Book::with('categories')->find($cart->book_id);

            if (!$book) {
                continue;
            }


            $quantity = max(1, (int) $cart->quantity);


            $actualWeight = null;

            if (
                isset($book->book_weight) &&
                $book->book_weight !== null &&
                $book->book_weight !== '' &&
                is_numeric($book->book_weight) &&
                (float) $book->book_weight > 0
            ) {
                $actualWeight = (float) $book->book_weight;
            }


            $isTextbook = false;

            if (
                $book->categories &&
                strtolower(trim($book->categories->name ?? '')) === 'textbooks'
            ) {
                $isTextbook = true;
            }


            if ($actualWeight !== null) {

                $weightUsed = $actualWeight;

                $weightType = 'Actual';

            } elseif ($isTextbook) {

                $weightUsed = self::TEXTBOOK_DEFAULT_WEIGHT;

                $weightType = 'Assumed';

            } else {

                $weightUsed = self::DEFAULT_BOOK_WEIGHT;

                $weightType = 'Assumed';
            }

            $itemTotalWeight = $weightUsed * $quantity;

            $totalWeight += $itemTotalWeight;


            $isHeavy = false;

            if (
                $actualWeight !== null &&
                $actualWeight > self::HEAVY_WEIGHT_THRESHOLD
            ) {
                $isHeavy = true;

                $heavyBookCount += $quantity;
            }


            $items[] = [
                'cart_id' => $cart->id,
                'book_id' => $cart->book_id,
                'book_name' => $cart->name,

                'quantity' => $quantity,

                'actual_weight' => $actualWeight,

                'weight_used' => $weightUsed,

                'weight_type' => $weightType,

                'item_total_weight' => $itemTotalWeight,

                'is_textbook' => $isTextbook,

                'is_heavy' => $isHeavy,
            ];
        }


        if ($totalWeight <= 500) {

            $standardShipping = self::SHIPPING_UPTO_500;

        } elseif ($totalWeight <= 1000) {

            $standardShipping = self::SHIPPING_501_TO_1000;

        } else {

            $standardShipping = self::SHIPPING_ABOVE_1000;
        }



        $freeShipping = $cartValue > self::FREE_SHIPPING_THRESHOLD;


        $appliedStandardShipping = $freeShipping
            ? 0
            : $standardShipping;


        $heavySurcharge =
            $heavyBookCount * self::HEAVY_BOOK_SURCHARGE;

        $isCod = false;

        if ($paymentMethod !== null) {

            $paymentMethodUpper = strtoupper(
                trim($paymentMethod)
            );

            if (
                in_array(
                    $paymentMethodUpper,
                    [
                        'COD',
                        'CASH ON DELIVERY',
                        'CASH_ON_DELIVERY'
                    ],
                    true
                )
            ) {
                $isCod = true;
            }
        }


        $codCharge = $isCod
            ? self::COD_CHARGE
            : 0;


        $finalShipping =
            $appliedStandardShipping
            + $heavySurcharge
            + $codCharge;


        return [

            'items' => $items,

            'total_weight' => round($totalWeight, 2),

            'standard_shipping' => $standardShipping,

            'free_shipping' => $freeShipping,

            'applied_standard_shipping' => $appliedStandardShipping,

            'heavy_book_count' => $heavyBookCount,

            'heavy_surcharge' => $heavySurcharge,

            'is_cod' => $isCod,

            'cod_charge' => $codCharge,

            'final_shipping' => $finalShipping,
        ];
    }
}