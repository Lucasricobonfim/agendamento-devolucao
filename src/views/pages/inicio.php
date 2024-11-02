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

    .form-container-grafico {
        max-width: 35%;
        margin: 30px auto;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        margin-top: 70px;

    }

    .form-container {
        max-width: 80%;
        margin: 20px auto;
        padding: 20px;
        background-color: #fff;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        margin-top: 50px;
    }

</style>


<main class='main-div' style="width:100%;">

    <h3 class="text-center">Dashboard</h3>

    <div class="form-container-grafico">

        <canvas id="myPieChart"></canvas>

    </div>



    <div class="form-container">
        <!-- botao Exportar e PDF -->
        <div class="card-toolbar d-flex justify-content-end gap-3" style="margin: 0px 0px 20px 0px;">

            <!-- Dropdown de Exportação -->
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" id="exportMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                    Exportar
                </button>


                <div id="kt_datatable_example_export_menu" class="dropdown-menu" aria-labelledby="exportMenuButton" style="min-width: 200px;">
                    <a href="#" class="dropdown-item d-flex align-items-center" data-kt-export="excel">
                        <span class="me-2">📄</span>
                        Excel
                    </a>
                    <a href="#" class="dropdown-item d-flex align-items-center" data-kt-export="pdf">
                        <span class="me-2">📄</span>
                        PDF
                    </a>
                </div>
            </div>

            <div id="kt_datatable_example_buttons_detalhes" class="btn-group"></div>

        </div>

        <h1><strong>Solicitações Agendamento (CD)</strong></h1>
        <table id="mytable" class="table table-striped table-bordered display nowrap" style="width:100%">

        </table>
    </div>


</main>
</body>
<script src="<?= $base; ?>/js/inicio.js"></script>

<script>
    const base = '<?= $base; ?>';
</script>