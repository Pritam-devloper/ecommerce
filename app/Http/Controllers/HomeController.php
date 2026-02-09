<?php
namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $banners = Banner::where('is_active', true)->orderBy('sort_order')->get();
        $categories = Category::where('is_active', true)->whereNull('parent_id')->withCount('products')->get();
        $featured = Product::approved()->active()->featured()->with('seller', 'category')->latest()->take(8)->get();
        $flashSale = Product::approved()->active()->flashSale()->with('seller', 'category')->latest()->take(8)->get();
        $trending = Product::approved()->active()->with('seller', 'category')->orderBy('views', 'desc')->take(8)->get();
        $latest = Product::approved()->active()->with('seller', 'category')->latest()->take(8)->get();

        return view('home', compact('banners', 'categories', 'featured', 'flashSale', 'trending', 'latest'));
    }

    public function category(Category $category)
    {
        $query = Product::approved()->active()->where('category_id', $category->id)->with('seller', 'category');

        if (request('sort')) {
            $query = match (request('sort')) {
                'price_low' => $query->orderBy('price'),
                'price_high' => $query->orderByDesc('price'),
                'newest' => $query->latest(),
                'popular' => $query->orderByDesc('views'),
                default => $query->latest(),
            };
        }

        if (request('min_price')) $query->where('price', '>=', request('min_price'));
        if (request('max_price')) $query->where('price', '<=', request('max_price'));
        if (request('brand')) $query->where('brand', request('brand'));
        if (request('rating')) $query->whereHas('reviews', fn($q) => $q->selectRaw('avg(rating) as avg_rating')->havingRaw('avg_rating >= ?', [request('rating')]));

        $products = $query->paginate(12)->appends(request()->query());
        $brands = Product::approved()->active()->where('category_id', $category->id)->whereNotNull('brand')->distinct()->pluck('brand');

        return view('category', compact('category', 'products', 'brands'));
    }

    public function search()
    {
        $q = request('q');
        $products = Product::approved()->active()
            ->where(fn($query) => $query->where('name', 'like', "%{$q}%")->orWhere('description', 'like', "%{$q}%")->orWhere('brand', 'like', "%{$q}%"))
            ->with('seller', 'category')
            ->paginate(12)->appends(['q' => $q]);

        return view('search', compact('products', 'q'));
    }

    public function product(Product $product)
    {
        $product->increment('views');
        $product->load('seller.user', 'category', 'reviews.user');
        $related = Product::approved()->active()->where('category_id', $product->category_id)->where('id', '!=', $product->id)->take(4)->get();

        return view('product', compact('product', 'related'));
    }
}
