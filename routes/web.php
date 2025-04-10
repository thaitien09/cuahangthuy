<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AdminCommentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CustomerServiceController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AdminArticleController;  // Đảm bảo sử dụng controller mới

// Route cho quản lý bài viết trong admin
Route::get('/admin/articles', [AdminArticleController::class, 'index'])->name('admin.articles.index');  // Hiển thị danh sách bài viết
Route::get('/admin/articles/create', [AdminArticleController::class, 'create'])->name('admin.articles.create');  // Form tạo bài viết mới
Route::post('/admin/articles', [AdminArticleController::class, 'store'])->name('admin.articles.store');  // Lưu bài viết mới
Route::get('/admin/articles/{article}/edit', [AdminArticleController::class, 'edit'])->name('admin.articles.edit');  // Form sửa bài viết
Route::put('/admin/articles/{article}', [AdminArticleController::class, 'update'])->name('admin.articles.update');
Route::delete('/admin/articles/{article}', [AdminArticleController::class, 'destroy'])->name('admin.articles.destroy');  // Xóa bài viết
Route::get('/articles/{slug}', [ArticleController::class, 'show'])->name('article.show');

Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');


Route::patch('/admin/transactions/{id}/status', [TransactionController::class, 'updateStatus'])->name('admin.transactions.updateStatus');
Route::get('/admin/transactions/{id}', [TransactionController::class, 'show'])->name('admin.transactions.show');

Route::get('/admin/transactions', [TransactionController::class, 'index'])->name('admin.transactions.index');


Route::get('/register', [AuthController::class, 'showRegister'])->name('register');

Route::post('/register', [AuthController::class, 'register'])->name('register.post'); // Xử lý form đăng ký

// Route cho trang danh sách dịch vụ
Route::get('/service', [CustomerServiceController::class, 'index'])->name('services.index');
Route::post('/services/{id}/purchase', [CustomerServiceController::class, 'purchase'])->name('services.purchase');

// Routes cho đăng nhập Google
Route::get('auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [AuthController::class, 'handleGoogleCallback']);






Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('/admin/inventory', [InventoryController::class, 'index'])->name('inventory.index');
Route::get('/admin/inventory/create', [InventoryController::class, 'create'])->name('inventory.create');
Route::post('/admin/inventory', [InventoryController::class, 'store'])->name('inventory.store');
Route::get('/admin/inventory/{id}/edit', [InventoryController::class, 'edit'])->name('inventory.edit');
Route::delete('/admin/inventory/{id}', [InventoryController::class, 'destroy'])->name('inventory.destroy');
Route::post('/admin/inventory/{id}/update', [InventoryController::class, 'update'])->name('inventory.update');
// Kiểm tra route trong web.php
Route::get('/order/show/{id}', [OrderController::class, 'show'])->name('order.show');

Route::get('/order', [OrderController::class, 'index'])->name('order.index');
Route::get('/order/place', [OrderController::class, 'showPlaceForm'])->name('order.place');
Route::post('/order/place', [OrderController::class, 'placeOrder'])->name('order.place.submit');

Route::get('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index'); // To view the cart
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');   // To add product to the cart
Route::delete('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');
Route::delete('/cart/{cart_id}', [CartController::class, 'remove'])->name('cart.remove');



Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/products/filter', [HomeController::class, 'filter']);



Route::get('/', [HomeController::class, 'index']);

// Routes full chức năng người dùng
Route::resource('users', UserController::class);
// Quản lýlý danh mục
// Hiển thị danh sách danh mục
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
// Hiển thị form thêm danh mục
Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
// Xử lý thêm danh mục mới
Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
// Hiển thị thông tin danh mục
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
// Hiển thị form sửa danh mục
Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
// Xử lý cập nhật danh mục (dùng POST thay vì PUT)
Route::post('/categories/{category}/update', [CategoryController::class, 'update'])->name('categories.update');
// Xóa danh mục (dùng POST thay vì DELETE)
Route::post('/categories/{category}/delete', [CategoryController::class, 'destroy'])->name('categories.destroy');

//Quản lý sản phẩm
// Hiển thị danh sách sản phẩm
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
// Hiển thị form thêm sản phẩm
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
// Xử lý thêm sản phẩm mới
Route::post('/products', [ProductController::class, 'store'])->name('products.store');
// Hiển thị thông tin sản phẩm
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
// Hiển thị form sửa sản phẩm
Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
// Xử lý cập nhật sản phẩm (dùng POST thay vì PUT)
Route::post('/products/{product}/update', [ProductController::class, 'update'])->name('products.update');
// Xóa sản phẩm (dùng POST thay vì DELETE)
Route::post('/products/{product}/delete', [ProductController::class, 'destroy'])->name('products.destroy');

Route::resource('types', TypeController::class);





//Trang khách hàng
Route::get('/products/{id}', function ($id) {
    // Truy vấn sản phẩm theo ID
    $product = DB::table('products')->where('id', $id)->first();
    
    // Kiểm tra nếu sản phẩm không tồn tại
    if (!$product) {
        abort(404); // Nếu không có sản phẩm, trả về lỗi 404
    }

    // Trả về view chi tiết sản phẩm
    return view('products.show', compact('product'));
})->name('products.show');


Route::get('/about', function () {
    return view('about');
});


// Route cho trang Recharge
Route::get('/recharge', function () {
    return view('recharge');
})->name('recharge');

// Route cho đăng nhập và đăng xuất
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// Route cho trang quản trị viên
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
// Route xử lý lưu người dùng
});

// Route cho hồ sơ người dùng
Route::middleware('auth')->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});



// trang quản lý đơn hàng
Route::get('/admin/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
Route::get('/admin/orders/{id}', [AdminOrderController::class, 'show'])->name('admin.orders.show');
Route::post('/admin/orders/update-status', [AdminOrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
Route::delete('/admin/orders/{id}', [AdminOrderController::class, 'destroy'])->name('admin.orders.destroy');



Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
Route::get('/admin/reports', [ReportController::class, 'index'])->name('admin.reports.index');
Route::post('/comments/reply', [CommentController::class, 'reply'])->name('comments.reply');
Route::get('/comments/load-more', [CommentController::class, 'loadMore'])->name('comments.load-more');


Route::prefix('admin')->group(function () {
    Route::get('/comments', [AdminCommentController::class, 'index'])->name('admin.comments.index');
    Route::delete('/comments/{id}', [AdminCommentController::class, 'destroy'])->name('admin.comments.destroy');
    Route::post('/admin/comments/hide/{id}', [CommentController::class, 'hideComment'])->name('admin.comments.hide');
});

// quản lý hỗ trợ khách hàng 
Route::get('/admin/support', [SupportController::class, 'index'])->name('admin.support.index');
Route::post('/admin/support/update', [SupportController::class, 'update'])->name('admin.support.update');


// quản lý dịch vụ
Route::get('/admin/services', [ServiceController::class, 'index'])->name('admin.services.index');
Route::get('/admin/services/create', [ServiceController::class, 'create'])->name('admin.services.create');
Route::post('/admin/services/store', [ServiceController::class, 'store'])->name('admin.services.store');
Route::get('/admin/services/edit/{id}', [ServiceController::class, 'edit'])->name('admin.services.edit');
Route::post('/admin/services/update/{id}', [ServiceController::class, 'update'])->name('admin.services.update');
Route::post('/admin/services/delete/{id}', [ServiceController::class, 'destroy'])->name('admin.services.destroy');



