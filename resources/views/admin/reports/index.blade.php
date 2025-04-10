@extends('layout')

@section('content')


<!-- Cards Overview -->
<div class="stats-cards">
    <div class="stat-card">
        <div class="card-body">
            <div class="card-icon"><i class="fas fa-money-bill-wave"></i></div>
            <div class="card-content">
                <h4>Tổng Doanh Thu</h4>
                <p class="amount">{{ number_format($dailyRevenue->sum('revenue'), 0, ',', '.') }} VNĐ</p>
            </div>
        </div>
    </div>
    <div class="stat-card">
        <div class="card-body">
            <div class="card-icon"><i class="fas fa-shopping-cart"></i></div>
            <div class="card-content">
                <h4>Tổng Đơn Hàng</h4>
                <p class="amount">{{ $dailyRevenue->sum('order_count') }}</p>
            </div>
        </div>
    </div>
    <div class="stat-card">
        <div class="card-body">
            <div class="card-icon"><i class="fas fa-chart-line"></i></div>
            <div class="card-content">
                <h4>Lợi Nhuận</h4>
                <p class="amount">{{ number_format($profit->profit, 0, ',', '.') }} VNĐ</p>
            </div>
        </div>
    </div>
</div>



    <!-- Main Dashboard Content -->
    <div class="dashboard-content">
        <!-- Left Column -->
        <div class="dashboard-column main-column">
            <!-- Daily Revenue Chart -->
            <div class="dashboard-widget">
                <div class="widget-header">
                    <h3>Doanh Thu Theo Ngày</h3>
                    <div class="widget-actions">
                        <button class="btn-icon"><i class="fas fa-download"></i></button>
                        <button class="btn-icon"><i class="fas fa-ellipsis-v"></i></button>
                    </div>
                </div>
                <div class="widget-body">
                    <div class="chart-container">
                        <canvas id="dailyChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Monthly Revenue Chart -->
            <div class="dashboard-widget">
                <div class="widget-header">
                    <h3>Doanh Thu Theo Tháng</h3>
                    <div class="widget-actions">
                        <button class="btn-icon"><i class="fas fa-download"></i></button>
                        <button class="btn-icon"><i class="fas fa-ellipsis-v"></i></button>
                    </div>
                </div>
                <div class="widget-body">
                    <div class="chart-container">
                        <canvas id="monthlyChart"></canvas>
                    </div>
                </div>
            </div>
            
           <!-- Yearly Revenue Chart -->
<div class="dashboard-widget">
    <div class="widget-header">
        <h3>Doanh Thu Theo Năm</h3>
        <div class="widget-actions">
            <button class="btn-icon"><i class="fas fa-download"></i></button>
            <button class="btn-icon"><i class="fas fa-ellipsis-v"></i></button>
        </div>
    </div>
    <div class="widget-body">
        <div class="chart-container">
            <canvas id="yearlyChart"></canvas>
        </div>
    </div>
</div>
            <!-- Product Revenue Chart -->
            <div class="dashboard-widget">
                <div class="widget-header">
                    <h3>Doanh Thu Theo Sản Phẩm</h3>
                    <div class="widget-actions">
                        <button class="btn-icon"><i class="fas fa-download"></i></button>
                        <button class="btn-icon"><i class="fas fa-ellipsis-v"></i></button>
                    </div>
                </div>
                <div class="widget-body">
                    <div class="chart-container">
                        <canvas id="productChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="dashboard-column side-column">
            <!-- Best & Least Selling Products -->
            <div class="dashboard-widget">
                <div class="widget-header">
                    <h3>Sản Phẩm Nổi Bật</h3>
                    <div class="widget-actions">
                        <button class="btn-icon"><i class="fas fa-ellipsis-v"></i></button>
                    </div>
                </div>
                <div class="widget-body">
                    <div class="highlight-products">
                        <div class="highlight-product best">
                            <div class="highlight-product-title">
                                <i class="fas fa-trophy"></i>
                                <h4>Sản Phẩm Bán Chạy Nhất</h4>
                            </div>
                            <div class="highlight-product-content">
                                <p class="product-name">{{ $bestSellingProduct->name ?? 'Chưa có dữ liệu' }}</p>
                                <p class="product-revenue">{{ number_format($bestSellingProduct->revenue ?? 0, 0, ',', '.') }} VNĐ</p>
                                <div class="product-stats">
                                    <span><i class="fas fa-box"></i> {{ $bestSellingProduct->total_sold ?? 0 }} sản phẩm</span>
                                    <span><i class="fas fa-chart-line"></i> +15.8%</span>
                                </div>
                            </div>
                        </div>
                        <div class="highlight-product least">
                            <div class="highlight-product-title">
                                <i class="fas fa-exclamation-triangle"></i>
                                <h4>Sản Phẩm Bán Chậm Nhất</h4>
                            </div>
                            <div class="highlight-product-content">
                                <p class="product-name">{{ $leastSellingProduct->name ?? 'Chưa có dữ liệu' }}</p>
                                <p class="product-revenue">{{ number_format($leastSellingProduct->revenue ?? 0, 0, ',', '.') }} VNĐ</p>
                                <div class="product-stats">
                                    <span><i class="fas fa-box"></i> {{ $leastSellingProduct->total_sold ?? 0 }} sản phẩm</span>
                                    <span><i class="fas fa-chart-line"></i> -5.3%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        

            <!-- Product Table -->
            <div class="dashboard-widget">
                <div class="widget-header">
                    <h3>Thống Kê Sản Phẩm</h3>
                    <div class="widget-actions">
                        <button class="btn-icon"><i class="fas fa-download"></i></button>
                        <button class="btn-icon"><i class="fas fa-ellipsis-v"></i></button>
                    </div>
                </div>
                <div class="widget-body">
                    <div class="table-responsive">
                        <table class="modern-table">
                            <thead>
                                <tr>
                                    <th>Sản Phẩm</th>
                                    <th>Số Lượng</th>
                                    <th>Doanh Thu</th>
                                    <th>Lợi Nhuận</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($productRevenue as $product)
                                    <tr>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->total_sold }}</td>
                                        <td>{{ number_format($product->revenue, 0, ',', '.') }} VNĐ</td>
                                        <td>{{ number_format($product->profit, 0, ',', '.') }} VNĐ</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
:root {
    --primary-color: #4361ee;
    --secondary-color: #3f37c9;
    --success-color: #4cc9f0;
    --warning-color: #f72585;
    --danger-color: #e63946;
    --light-color: #f8f9fa;
    --dark-color: #212529;
    --text-color: #495057;
    --text-light: #6c757d;
    --border-color: #e9ecef;
    --border-radius: 12px;
    --shadow: 0 2px 10px rgba(0,0,0,0.08);
    --shadow-hover: 0 5px 15px rgba(0,0,0,0.1);
    --transition: all 0.3s ease;
}

body {
    font-family: 'Inter', 'Segoe UI', Roboto, -apple-system, BlinkMacSystemFont, sans-serif;
    background-color: #f7f9fc;
    color: var(--text-color);
    line-height: 1.6;
}

.revenue-dashboard {
    padding: 1.5rem;
    background: #f7f9fc;
    min-height: 100vh;
}

.dashboard-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid var(--border-color);
}

.dashboard-title {
    color: var(--dark-color);
    font-weight: 700;
    font-size: 1.75rem;
    margin: 0;
}

.period-selector {
    display: flex;
    gap: 0.5rem;
    border-radius: var(--border-radius);
    overflow: hidden;
    background-color: #fff;
    box-shadow: var(--shadow);
}

.period-btn {
    padding: 0.5rem 1rem;
    border: none;
    background: none;
    cursor: pointer;
    font-weight: 500;
    color: var(--text-light);
    transition: var(--transition);
}

.period-btn.active {
    background-color: var(--primary-color);
    color: white;
}

.period-btn:hover:not(.active) {
    background-color: var(--border-color);
}

/* Stats Cards */
.stats-cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}

.stat-card {
    background: white;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    transition: var(--transition);
    overflow: hidden;
    border-left: 4px solid var(--primary-color);
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-hover);
}

.stat-card:nth-child(2) {
    border-left-color: var(--success-color);
}

.stat-card:nth-child(3) {
    border-left-color: var(--secondary-color);
}

.stat-card:nth-child(4) {
    border-left-color: var(--warning-color);
}

.card-body {
    padding: 1.5rem;
    display: flex;
    align-items: center;
}

.card-icon {
    width: 3rem;
    height: 3rem;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: rgba(67, 97, 238, 0.1);
    border-radius: 50%;
    margin-right: 1rem;
    color: var(--primary-color);
}

.stat-card:nth-child(2) .card-icon {
    background-color: rgba(76, 201, 240, 0.1);
    color: var(--success-color);
}

.stat-card:nth-child(3) .card-icon {
    background-color: rgba(63, 55, 201, 0.1);
    color: var(--secondary-color);
}

.stat-card:nth-child(4) .card-icon {
    background-color: rgba(247, 37, 133, 0.1);
    color: var(--warning-color);
}

.card-content {
    flex-grow: 1;
}

.card-content h4 {
    margin: 0;
    color: var(--text-light);
    font-size: 0.875rem;
    font-weight: 500;
}

.card-content .amount {
    margin: 0.5rem 0;
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--dark-color);
}

.card-content .change {
    margin: 0;
    font-size: 0.75rem;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.change.positive {
    color: #2ecc71;
}

.change.negative {
    color: #e74c3c;
}

/* Dashboard Layout */
.dashboard-content {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 1.5rem;
}

.dashboard-column {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

/* Dashboard Widgets */
.dashboard-widget {
    background: white;
    border-radius: var(--border-radius);
    box-shadow: var(--shadow);
    overflow: hidden;
}

.widget-header {
    padding: 1rem 1.5rem;
    border-bottom: 1px solid var(--border-color);
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.widget-header h3 {
    margin: 0;
    font-size: 1.125rem;
    font-weight: 600;
    color: var(--dark-color);
}

.widget-actions {
    display: flex;
    gap: 0.5rem;
}

.btn-icon {
    width: 2rem;
    height: 2rem;
    display: flex;
    align-items: center;
    justify-content: center;
    border: none;
    background: none;
    border-radius: 50%;
    cursor: pointer;
    color: var(--text-light);
    transition: var(--transition);
}

.btn-icon:hover {
    background-color: var(--border-color);
    color: var(--dark-color);
}

.widget-body {
    padding: 1.5rem;
}

.chart-container {
    height: 300px;
    position: relative;
}

/* Table Styles */
.table-responsive {
    overflow-x: auto;
}

.modern-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}

.modern-table th {
    background: #f8f9fa;
    color: var(--text-color);
    padding: 0.75rem 1rem;
    font-weight: 600;
    text-align: left;
    border-bottom: 2px solid var(--border-color);
}

.modern-table td {
    padding: 0.75rem 1rem;
    border-bottom: 1px solid var(--border-color);
    color: var(--text-color);
}

.modern-table tr:last-child td {
    border-bottom: none;
}

.modern-table tr:hover td {
    background: #f8f9fa;
}

/* Highlight Products */
.highlight-products {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.highlight-product {
    background: #f8f9fa;
    border-radius: var(--border-radius);
    padding: 1rem;
    border-left: 4px solid var(--primary-color);
}

.highlight-product.best {
    border-left-color: #2ecc71;
}

.highlight-product.least {
    border-left-color: #e74c3c;
}

.highlight-product-title {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 0.5rem;
}

.highlight-product-title i {
    font-size: 1rem;
    color: #2ecc71;
}

.highlight-product.least .highlight-product-title i {
    color: #e74c3c;
}

.highlight-product-title h4 {
    margin: 0;
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--text-color);
}

.highlight-product-content {
    padding-left: 1.5rem;
}

.product-name {
    margin: 0;
    font-weight: 600;
    font-size: 1rem;
    margin-bottom: 0.25rem;
}

.product-revenue {
    margin: 0;
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--dark-color);
    margin-bottom: 0.5rem;
}

.product-stats {
    display: flex;
    gap: 1rem;
    font-size: 0.75rem;
    color: var(--text-light);
}

/* Recent Orders */
.recent-orders {
    display: flex;
    flex-direction: column;
}

.order-item {
    display: grid;
    grid-template-columns: 1fr 1.5fr 1fr 1fr;
    padding: 1rem 0;
    border-bottom: 1px solid var(--border-color);
}

.order-item:last-child {
    border-bottom: none;
}

.order-info, .order-customer, .order-status, .order-amount {
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.order-id, .customer-name, .order-amount p {
    margin: 0;
    font-weight: 600;
    color: var(--dark-color);
    font-size: 0.875rem;
}

.order-date, .customer-email {
    margin: 0;
    color: var(--text-light);
    font-size: 0.75rem;
}

.status {
    display: inline-block;
    padding: 0.25rem 0.5rem;
    border-radius: 1rem;
    font-size: 0.75rem;
    font-weight: 500;
    text-align: center;
    width: fit-content;
}

.status.completed {
    background-color: rgba(46, 204, 113, 0.1);
    color: #2ecc71;
}

.status.pending {
    background-color: rgba(241, 196, 15, 0.1);
    color: #f1c40f;
}

.view-all {
    font-size: 0.875rem;
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 500;
}

/* Responsiveness */
@media (max-width: 1200px) {
    .dashboard-content {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .period-selector {
        display: none;
    }
    
    .order-item {
        grid-template-columns: 1fr 1fr;
        gap: 0.5rem;
    }
}
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    Chart.defaults.font.family = "'Inter', 'Segoe UI', Roboto, -apple-system, BlinkMacSystemFont, sans-serif";
    Chart.defaults.color = '#6c757d';
    
    // Daily Revenue Chart
    const dailyChartCtx = document.getElementById('dailyChart').getContext('2d');
    const dailyGradient = dailyChartCtx.createLinearGradient(0, 0, 0, 300);
    dailyGradient.addColorStop(0, 'rgba(67, 97, 238, 0.3)');
    dailyGradient.addColorStop(1, 'rgba(67, 97, 238, 0)');
    
    new Chart(document.getElementById('dailyChart'), {
        type: 'line',
        data: {
            labels: [@foreach($dailyRevenue as $day)'{{ $day->date }}', @endforeach],
            datasets: [{
                label: 'Doanh Thu',
                data: [@foreach($dailyRevenue as $day){{ $day->revenue }}, @endforeach],
                borderColor: '#4361ee',
                backgroundColor: dailyGradient,
                tension: 0.4,
                borderWidth: 2,
                fill: true,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#4361ee',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#fff',
                    titleColor: '#212529',
                    bodyColor: '#495057',
                    borderColor: '#e9ecef',
                    borderWidth: 1,
                    padding: 12,
                    boxPadding: 6,
                    usePointStyle: true,
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            label += new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(context.parsed.y);
                            return label;
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#e9ecef'
                    },
                    ticks: {
                        callback: function(value) {
                            return new Intl.NumberFormat('vi-VN', { 
                                style: 'currency', 
                                currency: 'VND',
                                notation: 'compact',
                                compactDisplay: 'short'
                            }).format(value);
                        }
                    }
                }
            }
        }
    });

    // Monthly Revenue Chart
    new Chart(document.getElementById('monthlyChart'), {
        type: 'bar',
        data: {
            labels: [@foreach($monthlyRevenue as $month)'Tháng {{ $month->month }}/{{ $month->year }}', @endforeach],
            datasets: [{
                label: 'Doanh Thu',
                data: [@foreach($monthlyRevenue as $month){{ $month->revenue }}, @endforeach],
                backgroundColor: '#4cc9f0',
                borderRadius: 6,
                maxBarThickness: 40
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#fff',
                    titleColor: '#212529',
                    bodyColor: '#495057',
                    borderColor: '#e9ecef',
                    borderWidth: 1,
                    padding: 12,
                    boxPadding: 6,
                    usePointStyle: true,
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            label += new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(context.parsed.y);
                            return label;
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#e9ecef'
                    },
                    ticks: {
                        callback: function(value) {
                            return new Intl.NumberFormat('vi-VN', { 
                                style: 'currency', 
                                currency: 'VND',
                                notation: 'compact',
                                compactDisplay: 'short'
                            }).format(value);
                        }
                    }
                }
            }
        }
    });
// Yearly Revenue Chart (Biểu đồ tròn)
new Chart(document.getElementById('yearlyChart'), {
    type: 'pie', // Biểu đồ tròn
    data: {
        labels: [@foreach($yearlyRevenue as $year)'{{ $year->year }}', @endforeach],
        datasets: [{
            label: 'Doanh Thu',
            data: [@foreach($yearlyRevenue as $year){{ $year->revenue }}, @endforeach],
            backgroundColor: [
                '#4361ee', // Xanh dương
                '#4cc9f0', // Xanh ngọc
                '#f72585', // Hồng đậm
                '#3f37c9', // Tím đậm
                '#7209b7'  // Tím nhạt
            ], // Mảng màu cho từng năm
            borderWidth: 1,
            borderColor: '#fff',
            hoverOffset: 10
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom', // Chú thích ở dưới
                labels: {
                    boxWidth: 12,
                    padding: 15,
                    usePointStyle: true,
                    pointStyle: 'circle'
                }
            },
            tooltip: {
                backgroundColor: '#fff',
                titleColor: '#212529',
                bodyColor: '#495057',
                borderColor: '#e9ecef',
                borderWidth: 1,
                padding: 12,
                boxPadding: 6,
                usePointStyle: true,
                callbacks: {
                    label: function(context) {
                        let label = context.label || '';
                        if (label) {
                            label += ': ';
                        }
                        label += new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(context.raw);
                        return label;
                    }
                }
            }
        }
    }
});
    // Product Revenue Chart
    new Chart(document.getElementById('productChart'), {
        type: 'doughnut',
        data: {
            labels: [@foreach($productRevenue as $product)'{{ $product->name }}', @endforeach],
            datasets: [{
                data: [@foreach($productRevenue as $product){{ $product->revenue }}, @endforeach],
                backgroundColor: ['#4361ee', '#4cc9f0', '#f72585', '#3f37c9', '#7209b7', '#560bad', '#480ca8', '#3a0ca3', '#3f37c9', '#4361ee'],
                borderWidth: 0,
                hoverOffset: 10
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '65%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        boxWidth: 12,
                        padding: 15,
                        usePointStyle: true,
                        pointStyle: 'circle'
                    }
                },
               tooltip: { 
                    backgroundColor: '#fff', 
                    titleColor: '#212529', 
                    bodyColor: '#495057', 
                    borderColor: '#e9ecef', 
                    borderWidth: 1, 
                    padding: 12, 
                    boxPadding: 6, 
                    usePointStyle: true,
                    callbacks: {
                        label: function(context) {
                            let label = context.label || '';
                            if (label) {
                                label += ': ';
                            }
                            label += new Intl.NumberFormat('vi-VN', { 
                                style: 'currency', 
                                currency: 'VND'
                            }).format(context.raw);
                            return label;
                        }
                    }
                }
            }
        }
    });

    // Add event listeners for period buttons
    const periodButtons = document.querySelectorAll('.period-btn');
    periodButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all buttons
            periodButtons.forEach(btn => btn.classList.remove('active'));
            // Add active class to clicked button
            this.classList.add('active');
            
            // Here you would typically load data for the selected period
            // For demo purposes, we'll just show a console message
            console.log(`Period changed to: ${this.textContent}`);
        });
    });

    // Add hover effect to table rows
    const tableRows = document.querySelectorAll('.modern-table tbody tr');
    tableRows.forEach(row => {
        row.addEventListener('mouseover', function() {
            this.style.backgroundColor = '#f8f9fa';
        });
        row.addEventListener('mouseout', function() {
            this.style.backgroundColor = '';
        });
    });

    // Add click functionality to dropdown buttons
    const dropdownButtons = document.querySelectorAll('.btn-icon');
    dropdownButtons.forEach(button => {
        button.addEventListener('click', function() {
            console.log('Action button clicked');
            // Here you would typically implement dropdown menu or action
        });
    });
});
</script>
@endsection