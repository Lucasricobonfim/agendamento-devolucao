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


<main class='main-div' style="width:100%;">

    <h3 class="text-center">Dashboard</h3>

    <div class="container mt-5">
        <div class="row text-center">
            <!-- Card 1: Total Solicitações -->

            <?php if ($_SESSION['idgrupo'] == 1 || $_SESSION['idgrupo'] == 3) { ?>
                <div class="col-md-4">
                    <div class="card shadow-sm p-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="icon-container">
                                <!-- <i class="fas fa-thumbs-up fa-2x"></i> -->
                                <i class="fa-solid fa-file-signature fa-2x"></i>
                            </div>
                            <div class="text-end">
                                <p class="mb-0">Total de Solicitações</p>
                                <p id="totalsolicitacoes" class="metric-value"></p>
                                <span class="percentage up">
                                    <!-- <i class="fas fa-arrow-up"></i>  -->
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <!-- Card 2: Total Agendamento -->
            <?php if ($_SESSION['idgrupo'] == 1 || $_SESSION['idgrupo'] == 2) { ?>
                <div class="col-md-4">
                    <div class="card shadow-sm p-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="icon-container">
                                <!-- <i class="fas fa-eye fa-2x"></i> -->
                                <i class="fa-solid fa-calendar-check fa-2x"></i>
                            </div>
                            <div class="text-end">
                                <p class="mb-0">Total de Agendamentos</p>
                                <p id="totalagendamento" class="metric-value"></p>
                                <span class="percentage up">
                                    <!-- <i class="fas fa-arrow-up"></i>  -->
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>

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