<?php $render('header'); ?>

<style>

        .card {
            border-radius: 10px;
        }
        .icon-container {
            background-color: #007bff;
            border-radius: 50%;
            padding: 10px;
            color: white;
        }
        .metric-value {
            font-size: 2rem;
            font-weight: bold;
        }
        .percentage {
            font-size: 0.9rem;
        }
        .up {
            color: green;
        }
        .down {
            color: red;
        }
   
</style>


<main class='main-div' style="width:100%; margin-left: 100px;">

<h3 class="text-center">Dashboard</h3>

<div class="container mt-5">
    <div class="row text-center">
        <!-- Card 1: Clicks -->
        <div class="col-md-4">
            <div class="card shadow-sm p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="icon-container">
                        <i class="fas fa-thumbs-up fa-2x"></i>
                    </div>
                    <div class="text-end">
                        <p class="mb-0">Clicks</p>
                        <p class="metric-value">71,897</p>
                        <span class="percentage up">
                            <i class="fas fa-arrow-up"></i> 5.4%
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <!-- Card 2: Impressions -->
        <div class="col-md-4">
            <div class="card shadow-sm p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="icon-container">
                        <i class="fas fa-eye fa-2x"></i>
                    </div>
                    <div class="text-end">
                        <p class="mb-0">Impressions</p>
                        <p class="metric-value">146,926</p>
                        <span class="percentage up">
                            <i class="fas fa-arrow-up"></i> 8.3%
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <!-- Card 3: Average CTR -->
        <div class="col-md-4">
            <div class="card shadow-sm p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="icon-container">
                        <i class="fas fa-chart-pie fa-2x"></i>
                    </div>
                    <div class="text-end">
                        <p class="mb-0">Average CTR</p>
                        <p class="metric-value">24.57%</p>
                        <span class="percentage down">
                            <i class="fas fa-arrow-down"></i> 3.9%
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</main>
</body>
<script src="<?= $base; ?>/js/inicio.js"></script>
<!-- Bootstrap JS -->
<script>
    const base = '<?= $base; ?>';
</script>