{!! '<' . '?xml version="1.0" encoding="UTF-8"?' . '>' !!}
<rss xmlns:g="http://base.google.com/ns/1.0" version="2.0">
<channel>

<title>{{ config('tracking.business_rules.default_brand', 'UsedBookr') }} - Product Feed</title>
<link>{{ url('/') }}</link>
<description>Buy used books online at best prices</description>

@foreach($books as $book)

@php

$first_variant = $book->varients->first();

$stock_number = $first_variant ? (int) $first_variant->stock : 0;
$selling_price = $first_variant ? (float) $first_variant->price : 0;

$original_price = !empty($book->original_price)
    ? (float) $book->original_price
    : $selling_price;

$variant_condition = $first_variant
    ? ($first_variant->bookconditions ?? 'Used')
    : 'Used';

$book_condition = strtolower(trim($variant_condition)) === 'new'
    ? 'new'
    : 'used';

$image_file = '';

if ($first_variant && !empty($first_variant->images)) {

    $images = json_decode($first_variant->images, true);

    if (is_array($images) && count($images)) {
        $image_file = $images[0];
    } else {
        $image_file = $first_variant->images;
    }
}

if (empty($image_file) && !empty($book->image)) {
    $image_file = $book->image;
}

$final_image_url = !empty($image_file)
    ? asset('public/images/' . $image_file)
    : asset('public/no-image.png');

@endphp

<item>

<g:id>{{ $book->id }}</g:id>

<g:title><![CDATA[{{ $book->name }}]]></g:title>

<g:description><![CDATA[
{{ !empty($book->description)
    ? strip_tags($book->description)
    : 'Buy used book ' . $book->name
}}
]]></g:description>

<g:link>{{ url('/product/' . ($book->url_slug ?? $book->id)) }}</g:link>

<g:image_link>{{ $final_image_url }}</g:image_link>

<g:price>{{ number_format($original_price, 2, '.', '') }} INR</g:price>

@if($selling_price > 0 && $selling_price < $original_price)
<g:sale_price>{{ number_format($selling_price, 2, '.', '') }} INR</g:sale_price>
@endif

<g:condition>{{ $book_condition }}</g:condition>

<g:availability>
{{ $stock_number > 0 ? 'in_stock' : 'out_of_stock' }}
</g:availability>

<g:brand>
{{ $book->publisher ?? $book->author ?? 'UsedBookr' }}
</g:brand>

<g:google_product_category>922</g:google_product_category>

@if(!empty($book->isbn) && strlen(trim($book->isbn)) >= 10)
<g:identifier_exists>yes</g:identifier_exists>
<g:isbn>{{ trim($book->isbn) }}</g:isbn>
@else
<g:identifier_exists>no</g:identifier_exists>
@endif

</item>

@endforeach

</channel>
</rss>