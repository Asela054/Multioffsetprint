<?php include "include/header.php"; ?>
    <?php include "include/menubar.php"; ?>

    <!-- Main Content Wrapper -->
    <main class="flex-grow-1 d-flex flex-column h-100 overflow-hidden position-relative">
        
        <?php include "include/topnavbar.php"; ?>

        <!-- Page Content Area -->
        <div class="flex-grow-1 px-4 px-md-5 pb-4 overflow-auto">
            <!-- Dashboard Title Area -->
            <div class="d-flex align-items-center gap-3 mb-4">
                <div class="p-2 glossy-icon-gray text-secondary rounded-xl d-flex align-items-center justify-content-center">
                     <i class="fas fa-desktop text-2xl page-title-icon"></i>
                </div>
                <h2 class="h4 font-weight-bold text-dark mb-0 tracking-tight page-title-text">Dashboard</h2>
            </div>
            
            <!-- ERP Section -->
            <div class="mb-5">
                <h6 class="text-xs font-weight-bold text-muted text-uppercase tracking-wider mb-3 px-2">ERP Overview</h6>
                
                <!-- Top Row: Jobs -->
                <div class="row mb-4">
                    <!-- Confirmed Jobs -->
                    <div class="col-md-4 mb-3 mb-md-0">
                        <div class="glass-card rounded-3xl p-4 d-flex flex-column justify-content-between h-100 hover-lift">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div class="p-2 glossy-icon-blue text-primary rounded-xl d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                    <i class="fas fa-check-circle text-xl"></i>
                                </div>
                                <span class="text-xs font-weight-bold text-success glossy-icon-green px-2 py-1 rounded-xl">+12%</span>
                            </div>
                            <div>
                                <p class="text-sm font-weight-bold text-muted mb-1">Confirmed Jobs</p>
                                <h4 class="text-3xl font-extrabold text-gradient-dark mb-0 d-flex align-items-baseline gap-2">45 <span class="text-sm font-weight-bold text-muted">over 5k</span></h4>
                            </div>
                        </div>
                    </div>

                    <!-- Ongoing Jobs -->
                    <div class="col-md-4 mb-3 mb-md-0">
                        <div class="glass-card rounded-3xl p-4 d-flex flex-column justify-content-between h-100 hover-lift">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div class="p-2 glossy-icon-yellow text-warning rounded-xl d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                    <i class="fas fa-wrench text-xl"></i>
                                </div>
                            </div>
                            <div>
                                <p class="text-sm font-weight-bold text-muted mb-1">Ongoing Jobs</p>
                                <h4 class="text-3xl font-extrabold text-gradient-dark mb-0">18</h4>
                            </div>
                        </div>
                    </div>

                    <!-- Completed Jobs -->
                    <div class="col-md-4">
                        <div class="glass-card rounded-3xl p-4 d-flex flex-column justify-content-between h-100 hover-lift">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div class="p-2 glossy-icon-green text-success rounded-xl d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                    <i class="fas fa-flag-checkered text-xl"></i>
                                </div>
                            </div>
                            <div>
                                <p class="text-sm font-weight-bold text-muted mb-1">Completed</p>
                                <h4 class="text-3xl font-extrabold text-gradient-dark mb-0 d-flex align-items-baseline gap-2">124 <span class="text-sm font-weight-bold text-muted">Next 30p</span></h4>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Second Row: Stock & Chart -->
                <div class="row">
                    <!-- Stock Reorder Level -->
                    <div class="col-lg-4 mb-4 mb-lg-0">
                        <div class="rounded-3xl p-4 h-100 position-relative overflow-hidden border" style="background: linear-gradient(to bottom right, #fef2f2, #fff7ed); box-shadow: inset 0 1px 1px white, 0 8px 24px rgba(220,38,38,0.06); border-color: rgba(254, 202, 202, 0.6);">
                            <div class="position-absolute rounded-circle" style="top: -2.5rem; right: -2.5rem; width: 8rem; height: 8rem; background: rgba(248, 113, 113, 0.1); filter: blur(20px);"></div>
                            
                            <div class="d-flex align-items-center gap-3 mb-4 position-relative" style="z-index: 10;">
                                <div class="p-2 glossy-icon-red text-danger rounded-xl d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                                    <i class="fas fa-exclamation-circle text-xl"></i>
                                </div>
                                <h5 class="font-weight-bold text-danger mb-0">Stock</h5>
                            </div>
                            
                            <div class="d-flex flex-column gap-2 position-relative" style="z-index: 10;">
                                <div class="bg-white p-3 rounded-2xl d-flex justify-content-between align-items-center shadow-sm hover-lift-sm border">
                                    <span class="text-sm font-weight-bold" style="color: #7f1d1d;">Art Paper 23x36</span>
                                    <span class="text-xs font-weight-bold text-danger px-2 py-1 rounded-xl" style="background: rgba(254, 226, 226, 0.5);">Low</span>
                                </div>
                                <div class="bg-white p-3 rounded-2xl d-flex justify-content-between align-items-center shadow-sm hover-lift-sm border">
                                    <span class="text-sm font-weight-bold" style="color: #7f1d1d;">Cyan Ink</span>
                                    <span class="text-xs font-weight-bold text-danger px-2 py-1 rounded-xl" style="background: rgba(254, 226, 226, 0.5);">Critical</span>
                                </div>
                                <div class="bg-white p-3 rounded-2xl d-flex justify-content-between align-items-center shadow-sm hover-lift-sm border">
                                    <span class="text-sm font-weight-bold" style="color: #7f1d1d;">Sticker Paper</span>
                                    <span class="text-xs font-weight-bold text-danger px-2 py-1 rounded-xl" style="background: rgba(254, 226, 226, 0.5);">Low</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bar Chart -->
                    <div class="col-lg-8">
                        <div class="glass-card rounded-3xl p-4 d-flex flex-column h-100" style="min-height: 350px;">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="font-weight-bold text-dark mb-0">Financial Overview</h5>
                                <div class="d-flex gap-3 text-xs font-weight-bold text-muted">
                                    <span class="d-flex align-items-center gap-1"><div class="rounded-circle bg-primary-900" style="width: 8px; height: 8px;"></div> Sales</span>
                                    <span class="d-flex align-items-center gap-1"><div class="rounded-circle bg-primary" style="width: 8px; height: 8px;"></div> Collection</span>
                                    <span class="d-flex align-items-center gap-1"><div class="rounded-circle bg-secondary" style="width: 8px; height: 8px;"></div> Expenses</span>
                                </div>
                            </div>
                            <div class="flex-grow-1 position-relative w-100 h-100">
                                <canvas id="financeChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Accounts Section -->
            <div>
                <h6 class="text-xs font-weight-bold text-muted text-uppercase tracking-wider mb-3 px-2">Accounts</h6>
                
                <div class="row">
                    <!-- Column 1 -->
                    <div class="col-md-4 d-flex flex-column gap-3 mb-4 mb-md-0">
                        <div class="glass-card rounded-3xl p-4 d-flex align-items-center justify-content-between hover-lift">
                            <div>
                                <p class="text-xs font-weight-bold text-muted mb-1">Bank Balance</p>
                                <h5 class="font-weight-bold text-gradient-dark mb-0">Rs. 4,500,000</h5>
                            </div>
                            <div class="p-2 glossy-icon-gray text-secondary rounded-xl d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;"><i class="fas fa-university text-lg"></i></div>
                        </div>
                        <div class="glass-card rounded-3xl p-4 d-flex align-items-center justify-content-between hover-lift">
                            <div>
                                <p class="text-xs font-weight-bold text-muted mb-1">Outstanding List</p>
                                <h5 class="font-weight-bold text-gradient-dark mb-0">Rs. 1,250,000</h5>
                            </div>
                            <div class="p-2 glossy-icon-gray text-secondary rounded-xl d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;"><i class="fas fa-list-ol text-lg"></i></div>
                        </div>
                        <div class="glass-card rounded-3xl p-4 d-flex align-items-center justify-content-between hover-lift">
                            <div>
                                <p class="text-xs font-weight-bold text-muted mb-1">Receivables</p>
                                <h5 class="font-weight-bold text-primary-600 mb-0">Rs. 2,800,000</h5>
                            </div>
                            <div class="p-2 glossy-icon-blue text-primary-600 rounded-xl d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;"><i class="fas fa-hand-holding-usd text-lg"></i></div>
                        </div>
                    </div>

                    <!-- Column 2 -->
                    <div class="col-md-4 d-flex flex-column gap-3 mb-4 mb-md-0">
                        <div class="glass-card rounded-3xl p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <p class="text-xs font-weight-bold text-muted mb-0">Cheques</p>
                                <i class="fas fa-money-bill-wave text-muted"></i>
                            </div>
                            <div class="d-flex flex-column gap-2">
                                <div class="d-flex justify-content-between align-items-center border-bottom pb-2">
                                    <span class="text-sm font-weight-bold text-secondary">Our PD Cheques</span>
                                    <span class="text-sm font-weight-bold text-dark">Rs. 450,000</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center pt-1">
                                    <span class="text-sm font-weight-bold text-secondary">Issued Cheques</span>
                                    <span class="text-sm font-weight-bold text-dark">Rs. 890,000</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="glass-card rounded-3xl p-4 d-flex align-items-center justify-content-between mt-auto hover-lift">
                            <div>
                                <p class="text-xs font-weight-bold text-muted mb-1">Net Payable (Weekly)</p>
                                <h5 class="font-weight-bold text-danger mb-0">Rs. 1,500,000</h5>
                            </div>
                            <div class="p-2 glossy-icon-red text-danger rounded-xl d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;"><i class="fas fa-level-down-alt text-lg"></i></div>
                        </div>
                    </div>

                    <!-- Column 3 -->
                    <div class="col-md-4">
                        <div class="glass-card rounded-3xl p-4 h-100 d-flex flex-column">
                            <div class="d-flex align-items-center gap-3 mb-4">
                                <div class="p-2 glossy-icon-gray text-secondary rounded-xl d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    <i class="fas fa-receipt text-lg"></i>
                                </div>
                                <h6 class="font-weight-bold text-dark mb-0">Uninvoiced Details</h6>
                            </div>
                            
                            <div class="flex-grow-1 d-flex flex-column gap-2 overflow-auto pr-1">
                                <div class="bg-white p-3 rounded-2xl d-flex justify-content-between align-items-center shadow-sm hover-lift-sm border" style="cursor: pointer;">
                                    <div>
                                        <p class="text-sm font-weight-bold text-dark mb-0">Job #1024 - Polytech</p>
                                        <p class="text-muted mb-0" style="font-size: 10px;">Completed 2 days ago</p>
                                    </div>
                                    <button class="btn btn-sm btn-light text-primary rounded-xl">
                                        <i class="fas fa-arrow-right"></i>
                                    </button>
                                </div>
                                <div class="bg-white p-3 rounded-2xl d-flex justify-content-between align-items-center shadow-sm hover-lift-sm border" style="cursor: pointer;">
                                    <div>
                                        <p class="text-sm font-weight-bold text-dark mb-0">Job #1025 - Agrawal</p>
                                        <p class="text-muted mb-0" style="font-size: 10px;">Completed yesterday</p>
                                    </div>
                                    <button class="btn btn-sm btn-light text-primary rounded-xl">
                                        <i class="fas fa-arrow-right"></i>
                                    </button>
                                </div>
                                 <div class="bg-white p-3 rounded-2xl d-flex justify-content-between align-items-center shadow-sm hover-lift-sm border" style="cursor: pointer;">
                                    <div>
                                        <p class="text-sm font-weight-bold text-dark mb-0">Job #1028 - Delmar</p>
                                        <p class="text-muted mb-0" style="font-size: 10px;">Completed today</p>
                                    </div>
                                    <button class="btn btn-sm btn-light text-primary rounded-xl">
                                        <i class="fas fa-arrow-right"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <?php include "include/footerbar.php"; ?>
        </div>

    </main>

    <?php include "include/footerscripts.php"; ?>

    <script>
        // Chart Initialization
        window.onload = function() {
            const ctx = document.getElementById('financeChart').getContext('2d');
            
            const gradientSales = ctx.createLinearGradient(0, 0, 0, 400);
            gradientSales.addColorStop(0, '#212B9D'); 
            gradientSales.addColorStop(1, '#3b82f6'); 

            const gradientCollection = ctx.createLinearGradient(0, 0, 0, 400);
            gradientCollection.addColorStop(0, '#60a5fa');
            gradientCollection.addColorStop(1, '#bfdbfe');

            const gradientExpenses = ctx.createLinearGradient(0, 0, 0, 400);
            gradientExpenses.addColorStop(0, '#94a3b8');
            gradientExpenses.addColorStop(1, '#e2e8f0');

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
                    datasets: [
                        { label: 'Sales', data: [1200000, 1900000, 1500000, 2200000], backgroundColor: gradientSales, borderRadius: 6, barPercentage: 0.6, categoryPercentage: 0.8 },
                        { label: 'Collection', data: [900000, 1500000, 1200000, 1800000], backgroundColor: gradientCollection, borderRadius: 6, barPercentage: 0.6, categoryPercentage: 0.8 },
                        { label: 'Expenses', data: [500000, 800000, 600000, 900000], backgroundColor: gradientExpenses, borderRadius: 6, barPercentage: 0.6, categoryPercentage: 0.8 }
                    ]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: 'rgba(15, 23, 42, 0.9)', titleFont: { family: 'Inter', size: 13 }, bodyFont: { family: 'Inter', size: 12 }, padding: 10, cornerRadius: 8,
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) { label += ': Rs. '; }
                                    if (context.parsed.y !== null) { label += new Intl.NumberFormat('en-IN').format(context.parsed.y); }
                                    return label;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true, grid: { color: '#f1f5f9', drawBorder: false },
                            ticks: {
                                font: { family: 'Inter', size: 11 }, color: '#94a3b8',
                                callback: function(value) {
                                    if(value >= 1000000) return (value / 1000000) + 'M';
                                    if(value >= 1000) return (value / 1000) + 'K';
                                    return value;
                                }
                            }
                        },
                        x: { grid: { display: false, drawBorder: false }, ticks: { font: { family: 'Inter', size: 11 }, color: '#64748b' } }
                    },
                    interaction: { intersect: false, mode: 'index' }
                }
            });
        };
    </script>
<?php include "include/footer.php"; ?>