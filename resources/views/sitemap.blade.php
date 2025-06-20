<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"
        xmlns:video="http://www.google.com/schemas/sitemap-video/1.1">
    <url>
        <loc>{{ url('') }}</loc>
        <lastmod>{{now()->toAtomString()}}</lastmod>
        <changefreq>daily</changefreq>
        <priority>1.0</priority>
    </url>
    
    <url>
        <loc>{{ route('business') }}</loc>
        <lastmod>{{now()->toAtomString()}}</lastmod>
        <changefreq>daily</changefreq>
        <priority>0.9</priority>
    </url>
    
    <url>
        <loc>{{ route('register.business') }}</loc>
        <lastmod>{{now()->toAtomString()}}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.9</priority>
    </url>

    @foreach ($businesses as $val)
        <url>
            <loc>{{ route('business-details', $val->slug) }}</loc>
            <lastmod>{{ $val->updated_at->toAtomString()}}</lastmod>
            <changefreq>monthly</changefreq>
            <priority>0.8</priority>
        </url>
    @endforeach
    
    @foreach ($Appointmenters as $val)
        <url>
            <loc>{{ route('expert', $val->slug) }}</loc>
            <lastmod>{{ $val->updated_at->toAtomString()}}</lastmod>
            <changefreq>monthly</changefreq>
            <priority>0.7</priority>
        </url>
    @endforeach

    <url>
        <loc>{{ route('aboutUs') }}</loc>
        <lastmod>{{now()->toAtomString()}}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.1</priority>
    </url>
    
    <url>
        <loc>{{ route('contactUs') }}</loc>
        <lastmod>{{now()->toAtomString()}}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.1</priority>
    </url>
    
    <url>
        <loc>{{ route('termAndCondition') }}</loc>
        <lastmod>{{now()->toAtomString()}}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.1</priority>
    </url>
    
    <url>
        <loc>{{ route('privacyPolicy') }}</loc>
        <lastmod>{{now()->toAtomString()}}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.1</priority>
    </url>
    
    <url>
        <loc>{{ route('CopyRight') }}</loc>
        <lastmod>{{now()->toAtomString()}}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.1</priority>
    </url>
    
    <url>
        <loc>{{ route('faq') }}</loc>
        <lastmod>{{now()->toAtomString()}}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>0.1</priority>
    </url>
    
</urlset>