<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
        <url>
            <loc>{{ url('/') }}</loc>
            <lastmod>2024-05-06T11:37:51+00:00</lastmod>
            <changefreq>daily</changefreq>
            <priority>0.8</priority>
        </url>
        <url>
            <loc>{{ url('/') }}/about-us</loc>
            <lastmod>2024-05-06T11:37:51+00:00</lastmod>
            <changefreq>daily</changefreq>
            <priority>0.8</priority>
        </url>
        <url>
            <loc>{{ url('/') }}/contact-us</loc>
            <lastmod>2024-05-06T11:37:51+00:00</lastmod>
            <changefreq>daily</changefreq>
            <priority>0.8</priority>
        </url>
        <url>
            <loc>{{ url('/') }}/new-arrivals</loc>
            <lastmod>2024-05-06T11:37:51+00:00</lastmod>
            <changefreq>daily</changefreq>
            <priority>0.8</priority>
        </url>
        <url>
            <loc>{{ url('/') }}/authors</loc>
            <lastmod>2024-05-06T11:37:51+00:00</lastmod>
            <changefreq>daily</changefreq>
            <priority>0.8</priority>
        </url>
        <url>
            <loc>{{ url('/') }}/faq</loc>
            <lastmod>2024-05-06T11:37:51+00:00</lastmod>
            <changefreq>daily</changefreq>
            <priority>0.8</priority>
        </url>
        <url>
            <loc>{{ url('/') }}/terms-and-conditions</loc>
            <lastmod>2024-05-06T11:37:51+00:00</lastmod>
            <changefreq>daily</changefreq>
            <priority>0.8</priority>
        </url>
        <url>
            <loc>{{ url('/') }}/privacy-policy</loc>
            <lastmod>2024-05-06T11:37:51+00:00</lastmod>
            <changefreq>daily</changefreq>
            <priority>0.8</priority>
        </url>
        <url>
            <loc>{{ url('/') }}/view-cart</loc>
            <lastmod>2024-05-06T11:37:51+00:00</lastmod>
            <changefreq>daily</changefreq>
            <priority>0.8</priority>
        </url>
        <url>
            <loc>{{ url('/') }}/view-wishlist</loc>
            <lastmod>2024-05-06T11:37:51+00:00</lastmod>
            <changefreq>daily</changefreq>
            <priority>0.8</priority>
        </url>
    @foreach ($posts as $post)
        <url>
            <loc>{{ url('/') }}/buy-second-hand-books-usedbooks/{{ $post->categories->url_slug }}/{{ $post->url_slug }}</loc>
            <lastmod>{{ $post->created_at->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>daily</changefreq>
            <priority>0.8</priority>
        </url>
    @endforeach
    @foreach ($category as $cagy)
        <url>
            <loc>{{ url('/') }}/buy-second-hand-books-usedbooks/categories/{{ $cagy->url_slug }}</loc>
            <lastmod>{{ $post->created_at->tz('UTC')->toAtomString() }}</lastmod>
            <changefreq>daily</changefreq>
            <priority>0.8</priority>
        </url>
    @endforeach
    
</urlset>