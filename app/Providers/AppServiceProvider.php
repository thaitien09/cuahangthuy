<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        $categories = DB::table('categories')->get();
        View::share('categories', $categories);

        // Lấy danh sách loại sản phẩm
        $types = DB::table('types')->get(); // THÊM DÒNG NÀY
        View::share('types', $types);

        // Lấy danh sách sản phẩm
        $products = DB::table('products')->get();
        View::share('products', $products);
        
    }
}
