<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\Log;

class FeedController extends Controller
{
    // public function googleShoppingFeed()
    // {
    //     // Max processing limits optimized
    //     @set_time_limit(0);
    //     @ini_set('memory_limit', '512M');

    //     return new StreamedResponse(function () {
            
    //         // Clean previous buffer noise leaks completely
    //         while (ob_get_level() > 0) {
    //             ob_end_clean();
    //         }

    //         // Start pure XML generation buffer sequence
    //         ob_start();

    //         // Strict Header Echo formatting with double quotes
    //         echo '<?xml version="1.0" encoding="UTF-8"?' . ">\n";
    //         echo '<rss xmlns:g="http://base.google.com/ns/1.0" version="2.0">' . "\n";
    //         echo "    <channel>" . "\n";
    //         echo "        <title>" . htmlspecialchars(config('tracking.business_rules.default_brand', 'UsedBookr'), ENT_XML1, 'UTF-8') . " - Product Feed</title>" . "\n";
    //         echo "        <link>" . url('/') . "</link>" . "\n";
    //         echo "        <description>Buy used books online at best prices</description>" . "\n";

    //         // 17,000 data streams chunks processing securely
    //         Book::where('status', 1)
    //             ->with('varients')
    //             ->orderBy('id')
    //             ->chunkById(150, function ($books) {

    //                 foreach ($books as $book) {
    //                     try {
    //                         $first_variant = $book->varients ? $book->varients->first() : null;

    //                         $stock_number = $first_variant ? (int) ($first_variant->stock ?? 0) : 0;
    //                         $selling_price = $first_variant ? (float) ($first_variant->price ?? 0) : 0;
                            
    //                         $original_price = isset($book->original_price) && !empty($book->original_price) 
    //                             ? (float) $book->original_price 
    //                             : $selling_price;

    //                         $variant_condition = $first_variant ? ($first_variant->bookconditions ?? 'Used') : 'Used';
    //                         $book_condition = (strtolower(trim($variant_condition)) === 'new') ? 'new' : 'used';

    //                         // Safe Image Array Extraction Handling
    //                         $image_file = '';
    //                         if ($first_variant && !empty($first_variant->images)) {
    //                             $images = json_decode($first_variant->images, true);
    //                             $image_file = (is_array($images) && count($images)) ? $images[0] : $first_variant->images;
    //                         }

    //                         if (empty($image_file) && isset($book->image) && !empty($book->image)) {
    //                             $image_file = $book->image;
    //                         }

    //                         $final_image_url = !empty($image_file) ? asset('public/images/' . $image_file) : asset('public/no-image.png');
    //                         $final_image_url = htmlspecialchars($final_image_url, ENT_XML1, 'UTF-8');

    //                         // CRITICAL FIX: Strip down completely any nested tags & wrap properly
    //                         $title = trim(strip_tags($book->name ?? 'Used Book'));
    //                         $description = !empty($book->description) ? trim(strip_tags($book->description)) : 'Buy used book ' . $title;
    //                         $brand = trim(strip_tags($book->publisher ?? $book->author ?? 'UsedBookr'));

    //                         $link_url = htmlspecialchars(url('/product/' . ($book->url_slug ?? $book->id)), ENT_XML1, 'UTF-8');

    //                         // Structure elements explicit markup print pipeline
    //                         echo "        <item>" . "\n";
    //                         echo "            <g:id>" . $book->id . "</g:id>" . "\n";
    //                         echo "            <g:title><![CDATA[" . $title . "]]></g:title>" . "\n";
    //                         echo "            <g:description><![CDATA[" . $description . "]]></g:description>" . "\n";
    //                         echo "            <g:link>" . $link_url . "</g:link>" . "\n";
    //                         echo "            <g:image_link>" . $final_image_url . "</g:image_link>" . "\n";
    //                         echo "            <g:price>" . number_format($original_price, 2, '.', '') . " INR</g:price>" . "\n";

    //                         if ($selling_price > 0 && $selling_price < $original_price) {
    //                             echo "            <g:sale_price>" . number_format($selling_price, 2, '.', '') . " INR</g:sale_price>" . "\n";
    //                         }

    //                         echo "            <g:condition>" . $book_condition . "</g:condition>" . "\n";
    //                         echo "            <g:availability>" . ($stock_number > 0 ? 'in_stock' : 'out_of_stock') . "</g:availability>" . "\n";
    //                         echo "            <g:brand><![CDATA[" . $brand . "]]></g:brand>" . "\n";
    //                         echo "            <g:google_product_category>922</g:google_product_category>" . "\n";

    //                         if (isset($book->isbn) && !empty($book->isbn) && strlen(trim($book->isbn)) >= 10) {
    //                             $clean_isbn = preg_replace('/[^0-9X-]/i', '', trim($book->isbn));
    //                             echo "            <g:identifier_exists>yes</g:identifier_exists>" . "\n";
    //                             echo "            <g:isbn>" . htmlspecialchars($clean_isbn, ENT_XML1, 'UTF-8') . "</g:isbn>" . "\n";
    //                         } else {
    //                             echo "            <g:identifier_exists>no</g:identifier_exists>" . "\n";
    //                         }
    //                         echo "        </item>" . "\n";

    //                     } catch (\Exception $e) {
    //                         Log::error("Google Feed Parsing Skipped ID " . $book->id . " - Error: " . $e->getMessage());
    //                         continue;
    //                     }
                        
    //                     unset($book);
    //                 }

    //                 // Flush current batch chunk output cleanly 
    //                 ob_flush();
    //                 flush();
    //             });

    //         echo "    </channel>" . "\n";
    //         echo "</rss>" . "\n";
            
    //         ob_flush();
    //         flush();

    //     }, 200, [
    //         'Content-Type'  => 'text/xml; charset=UTF-8',
    //         'Cache-Control' => 'no-cache, no-store, must-revalidate',
    //         'Pragma'        => 'no-cache',
    //         'Expires'       => '0',
    //     ]);
    // }
    
    
    public function googleShoppingFeed()
    {
        // Max processing limits optimized
        @set_time_limit(0);
        @ini_set('memory_limit', '512M');
    
        return new StreamedResponse(function () {
            
            // Clean previous buffer noise leaks completely
            while (ob_get_level() > 0) {
                ob_end_clean();
            }
    
            // Start pure XML generation sequence
            ob_start();
    
            // Strict Header Echo formatting
            echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
            echo '<rss xmlns:g="http://base.google.com/ns/1.0" version="2.0">' . "\n";
            echo "    <channel>" . "\n";
            echo "        <title>" . htmlspecialchars(config('tracking.business_rules.default_brand', 'UsedBookr'), ENT_XML1, 'UTF-8') . " - Product Feed</title>" . "\n";
            echo "        <link>" . url('/') . "</link>" . "\n";
            echo "        <description>Buy used books online at best prices</description>" . "\n";
    
            // Fetching strictly top 5 active records safely
            $books = Book::where('status', 1)
                ->with('varients')
                ->orderBy('id', 'asc')
                ->take(5)
                ->get();
    
            foreach ($books as $book) {
                try {
                    $first_variant = $book->varients ? $book->varients->first() : null;
    
                    $stock_number = $first_variant ? (int) ($first_variant->stock ?? 0) : 0;
                    $selling_price = $first_variant ? (float) ($first_variant->price ?? 0) : 0;
                    
                    $original_price = isset($book->original_price) && !empty($book->original_price) 
                        ? (float) $book->original_price 
                        : $selling_price;
    
                    $variant_condition = $first_variant ? ($first_variant->bookconditions ?? 'Used') : 'Used';
                    $book_condition = (strtolower(trim($variant_condition)) === 'new') ? 'new' : 'used';
    
                    // Safe Image Array Extraction Handling
                    $image_file = '';
                    if ($first_variant && !empty($first_variant->images)) {
                        $images = is_string($first_variant->images) 
                            ? json_decode($first_variant->images, true) 
                            : $first_variant->images;
                            
                        $image_file = is_array($images) && count($images) ? $images[0] : $first_variant->images;
                    }
    
                    if (empty($image_file) && !empty($book->image)) {
                        $image_file = $book->image;
                    }
    
                    $final_image_url = !empty($image_file) 
                        ? asset('public/images/' . $image_file) 
                        : asset('public/no-image.png');
                    $final_image_url = htmlspecialchars($final_image_url, ENT_XML1, 'UTF-8');
    
                    // Clean HTML tags and special entities
                    $title = htmlspecialchars(trim(strip_tags($book->name ?? 'Used Book')), ENT_XML1, 'UTF-8');
                    $description = htmlspecialchars(trim(strip_tags($book->description ?? 'Buy used book ' . $title)), ENT_XML1, 'UTF-8');
                    $brand = htmlspecialchars(trim(strip_tags($book->publisher ?? $book->author ?? 'UsedBookr')), ENT_XML1, 'UTF-8');
    
                    $link_url = htmlspecialchars(url('/product/' . ($book->url_slug ?? $book->id)), ENT_XML1, 'UTF-8');
    
                    // Structure XML item payload
                    echo "        <item>" . "\n";
                    echo "            <g:id>" . $book->id . "</g:id>" . "\n";
                    echo "            <g:title><![CDATA[" . $title . "]]></g:title>" . "\n";
                    echo "            <g:description><![CDATA[" . $description . "]]></g:description>" . "\n";
                    echo "            <g:link>" . $link_url . "</g:link>" . "\n";
                    echo "            <g:image_link>" . $final_image_url . "</g:image_link>" . "\n";
                    echo "            <g:price>" . number_format($original_price, 2, '.', '') . " INR</g:price>" . "\n";
    
                    if ($selling_price > 0 && $selling_price < $original_price) {
                        echo "            <g:sale_price>" . number_format($selling_price, 2, '.', '') . " INR</g:sale_price>" . "\n";
                    }
    
                    echo "            <g:condition>" . $book_condition . "</g:condition>" . "\n";
                    echo "            <g:availability>" . ($stock_number > 0 ? 'in_stock' : 'out_of_stock') . "</g:availability>" . "\n";
                    echo "            <g:brand><![CDATA[" . $brand . "]]></g:brand>" . "\n";
                    echo "            <g:google_product_category>922</g:google_product_category>" . "\n";
    
                    if (!empty($book->isbn) && strlen(trim($book->isbn)) >= 10) {
                        $clean_isbn = preg_replace('/[^0-9X-]/i', '', trim($book->isbn));
                        echo "            <g:identifier_exists>yes</g:identifier_exists>" . "\n";
                        echo "            <g:isbn>" . htmlspecialchars($clean_isbn, ENT_XML1, 'UTF-8') . "</g:isbn>" . "\n";
                    } else {
                        echo "            <g:identifier_exists>no</g:identifier_exists>" . "\n";
                    }
                    echo "        </item>" . "\n";
    
                } catch (\Exception $e) {
                    Log::error("Google Feed Parsing Skipped ID " . $book->id . " - Error: " . $e->getMessage());
                }
            }
    
            echo "    </channel>" . "\n";
            echo "</rss>" . "\n";
            
            if (ob_get_length()) {
                ob_end_flush();
            }
    
        }, 200, [
            'Content-Type'  => 'text/xml; charset=UTF-8',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma'        => 'no-cache',
            'Expires'       => '0',
        ]);
    }
// public function facebookCatalogFeed()
// {
//     @set_time_limit(0);
//     @ini_set('memory_limit', '512M');

//     $limit = 10; 
//     $saleDays = config('services.facebook.sale_days', 90);

//     $saleStart = date('Y-m-d\T00:00:00O'); 
//     $saleEnd   = date('Y-m-d\T23:59:59O', strtotime('+' . $saleDays . ' days')); 
//     $salePriceEffectiveDate = $saleStart . '/' . $saleEnd;

//     if (ob_get_level() > 0) {
//         ob_end_clean();
//     }

//     $output = '<?xml version="1.0" encoding="UTF-8"?' . ">\n";
//     $output .= '<rss xmlns:g="http://base.google.com/ns/1.0" version="2.0">' . "\n";
//     $output .= "    <channel>" . "\n";
//     $output .= "        <title>" . htmlspecialchars(config('tracking.business_rules.default_brand', 'UsedBookr'), ENT_XML1, 'UTF-8') . " - Facebook Product Feed</title>" . "\n";
//     $output .= "        <link>" . url('/') . "</link>" . "\n";
//     $output .= "        <description>Automated Facebook Product Catalog Feed</description>" . "\n";

//     try {
//         $booksQuery = \App\Models\Book::query();
//         if (!class_exists('\App\Models\Book') && class_exists('\App\Book')) {
//             $booksQuery = \App\Book::query();
//         }

//         // FIXED: எந்த ரிலேஷன்ஷிப்பும் (with) இல$allBooks = $booksQuery->orderBy('id')
//                               ->limit($limit)
//                               ->get();

//         foreach ($allBooks as $booksData) {
//             try {
//                 $selling_price = (float) ($booksData->price ?? 0);
//                 $original_price = isset($booksData->original_price) && !empty($booksData->original_price) 
//                     ? (float) $booksData->original_price 
//                     : $selling_price;

//                 $stock_number = (int) ($booksData->stock ?? 1); // ஸ்டாக் இல்லைனா default 1
//                 $book_condition = 'used'; // Default condition

//                 $image_file = $booksData->image ?? '';
//                 $final_image_url = !empty($image_file) ? asset('public/images/' . $image_file) : asset('public/no-image.png');
//                 $final_image_url = htmlspecialchars($final_image_url, ENT_XML1, 'UTF-8');

//                 $title = trim(strip_tags($booksData->name ?? 'Used Book'));
//                 $description = !empty($booksData->description) ? trim(strip_tags($booksData->description)) : 'Buy used book ' . $title;
//                 $brand = trim(strip_tags($booksData->publisher ?? $booksData->author ?? 'UsedBookr'));

//                 $link_url = htmlspecialchars(url('/product/' . ($booksData->url_slug ?? $booksData->id)), ENT_XML1, 'UTF-8');
                
//                 $custom_label_0 = !empty($booksData->author) ? trim($booksData->author) : 'Unknown Author';

//                 $output .= "        <item>" . "\n";
//                 $output .= "            <g:id>UB-" . $booksData->id . "</g:id>" . "\n";
//                 $output .= "            <g:title><![CDATA[" . $title . "]]></g:title>" . "\n";
//                 $output .= "            <g:description><![CDATA[" . $description . "]]></g:description>" . "\n";
//                 $output .= "            <g:link>" . $link_url . "</g:link>" . "\n";
//                 $output .= "            <g:image_link>" . $final_image_url . "</g:image_link>" . "\n";
//                 $output .= "            <g:condition>" . $book_condition . "</g:condition>" . "\n";
//                 $output .= "            <g:availability>" . ($stock_number > 0 ? 'in stock' : 'out of stock') . "</g:availability>" . "\n";
//                 $output .= "            <g:brand><![CDATA[" . $brand . "]]></g:brand>" . "\n";
//                 $output .= "            <g:price>" . number_format($original_price, 2, '.', '') . " INR</g:price>" . "\n";

//                 if ($selling_price > 0 && $selling_price < $original_price) {
//                     $output .= "            <g:sale_price>" . number_format($selling_price, 2, '.', '') . " INR</g:sale_price>" . "\n";
//                     $output .= "            <g:sale_price_effective_date>" . $salePriceEffectiveDate . "</g:sale_price_effective_date>" . "\n";
//                 }

//                 $output .= "            <g:custom_label_0><![CDATA[" . $custom_label_0 . "]]></g:custom_label_0>" . "\n";
//                 $output .= "            <g:fb_product_category><![CDATA[Books]]></g:fb_product_category>" . "\n";
//                 $output .= "            <g:google_product_category>922</g:google_product_category>" . "\n";
//                 $output .= "        </item>" . "\n";

//             } catch (\Exception $e) {
//                 $output .= "        <!-- Item Loop Error: " . htmlspecialchars($e->getMessage()) . " -->\n";
//             }
//         }
//     } catch (\Exception $mainQueryException) {
//         $output .= "        <!-- Main Query Error: " . htmlspecialchars($mainQueryException->getMessage()) . " -->\n";
//     }

//     $output .= "    </channel>" . "\n";
//     $output .= "</rss>" . "\n";

//     return response($output, 200)->header('Content-Type', 'text/xml; charset=UTF-8');
// }
public function facebookCatalogFeed()
{
    @set_time_limit(0);
    @ini_set('memory_limit', '512M');

    $limit = 200; 

    try {
        $booksQuery = \App\Models\Book::query();
        if (!class_exists('\App\Models\Book') && class_exists('\App\Book')) {
            $booksQuery = \App\Book::query();
        }

        $allBooks = $booksQuery->with('categories')->orderBy('id', 'desc')
                                ->where('status',1)
                               ->limit($limit)
                               ->get();
        // dd($allBooks);
        $headers = [
            'id', 
            'title', 
            'category',
            'description', 
            'availability', 
            'condition', 
            'price', 
            'link', 
            'image_link', 
            'brand', 
            'google_product_category', 
            'fb_product_category', 
            'quantity_to_sell_on_facebook', 
            'sale_price'
        ];

        $handle = fopen('php://temp', 'w+');
        
        fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF));
        
        fputcsv($handle, $headers);
        // dd($allBooks);
        foreach ($allBooks as $booksData) {
            // dd();
            try {
                $selling_price = (float) ($booksData->price ?? 0);
                $original_price = isset($booksData->original_price) && !empty($booksData->original_price) 
                    ? (float) $booksData->original_price 
                    : $selling_price;

                $stock_number = (int) ($booksData->stock ?? 1); 
                $availability = ($stock_number > 0) ? 'in stock' : 'out of stock';
                $book_condition = 'new'; 

                $image_file = $booksData->image ?? '';
                // dd($image_file);
                $final_image_url = !empty($image_file) ? asset('public/upload/admin_images/books/' . $image_file) : asset('public/no-image.png');
                $link_url = url('/buy-second-hand-books-usedbooks/' .($booksData->categories->url_slug).'/'. ($booksData->url_slug ?? $booksData->id));
                // dd($link_url,$booksData);
                $title = trim(strip_tags($booksData->name ?? 'Used Book'));
                
                $childcategories = $booksData->childcategories?->name ?? $booksData->subcategories?->name ?? "";
                
                $description = !empty($booksData->description) ? trim(strip_tags($booksData->description)) : 'Buy used book ' . $title;
                
                $brand = trim(strip_tags($booksData->publisher ?? $booksData->author ?? 'UsedBookr'));
                if (empty($brand)) { $brand = 'Generic'; }

                $price_str = number_format($original_price, 2, '.', '') . ' INR';
                $sale_price_str = '';
                if ($selling_price > 0 && $selling_price < $original_price) {
                    $sale_price_str = number_format($selling_price, 2, '.', '') . ' INR';
                }
            // dd($final_image_url);
                fputcsv($handle, [
                    'UB-' . $booksData->id,                     
                    $title, 
                    $childcategories,
                    $description,                              
                    $availability,                              
                    $book_condition,                          
                    $price_str,                                 
                    $link_url,                                  
                    $final_image_url,                          
                    $brand,                                  
                    'Media > Books',                           
                    'Media > Books',                            
                    $stock_number,                          
                    $sale_price_str                   
                ]);

            } catch (\Exception $e) {
                continue; 
            }
        }

        rewind($handle);
        $csvContent = stream_get_contents($handle);
        fclose($handle);

        return response($csvContent, 200, [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="facebook_catalog_10_feed.csv"',
            'Cache-Control'       => 'no-cache, no-store, must-revalidate',
            'Pragma'              => 'no-cache',
            'Expires'             => '0',
        ]);

    } catch (\Exception $mainQueryException) {
        return response('Error generating CSV feed: ' . $mainQueryException->getMessage(), 500);
    }
}

}