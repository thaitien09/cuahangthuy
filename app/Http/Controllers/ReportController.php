<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        // Doanh thu theo ngày (chỉ tính đơn hàng đã giao thành công)
        $dailyRevenue = DB::table('orders')
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_amount) as revenue'),
                DB::raw('COUNT(id) as order_count')
            )
            ->where('status', 'Giao hàng thành công')
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->get();

        // Doanh thu theo tháng (chỉ tính đơn hàng đã giao thành công)
        $monthlyRevenue = DB::table('orders')
            ->select(
                DB::raw('YEAR(created_at) as year, MONTH(created_at) as month'),
                DB::raw('SUM(total_amount) as revenue'),
                DB::raw('COUNT(id) as order_count')
            )
            ->where('status', 'Giao hàng thành công')
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        // Doanh thu theo năm (chỉ tính đơn hàng đã giao thành công)
        $yearlyRevenue = DB::table('orders')
            ->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('SUM(total_amount) as revenue'),
                DB::raw('COUNT(id) as order_count')
            )
            ->where('status', 'Giao hàng thành công')
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->get();

        // Lợi nhuận từ giá nhập & giá bán (chỉ tính đơn hàng đã giao thành công)
        $profit = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'Giao hàng thành công') // Chỉ lấy đơn hàng đã giao thành công
            ->selectRaw('SUM((products.sale_price - products.purchase_price) * order_items.quantity) as profit')
            ->first();

        // Doanh thu theo sản phẩm (chỉ tính đơn hàng đã giao thành công)
        $productRevenue = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'Giao hàng thành công') // Chỉ tính sản phẩm từ đơn hàng đã giao thành công
            ->select(
                'products.name', 
                DB::raw('SUM(order_items.quantity) as total_sold'), 
                DB::raw('SUM(order_items.quantity * products.sale_price) as revenue'),
                DB::raw('SUM((products.sale_price - products.purchase_price) * order_items.quantity) as profit')
            )
            ->groupBy('products.name')
            ->orderBy('revenue', 'desc')
            ->get();

        // Sản phẩm bán chạy nhất
        $bestSellingProduct = $productRevenue->first();

        // Sản phẩm bán chậm nhất
        $leastSellingProduct = $productRevenue->last();

        // Lấy sản phẩm có điểm đánh giá trung bình cao nhất
        $topRatedProduct = DB::table('products')
            ->join('comments', 'products.id', '=', 'comments.product_id')
            ->select('products.id', 'products.name', DB::raw('AVG(comments.rating) as avg_rating'))
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('avg_rating')
            ->first();

        return view('admin.reports.index', compact(
            'dailyRevenue', 'monthlyRevenue', 'yearlyRevenue', 'profit',
            'productRevenue', 'bestSellingProduct', 'leastSellingProduct',
            'topRatedProduct'
        ));
    }
}
