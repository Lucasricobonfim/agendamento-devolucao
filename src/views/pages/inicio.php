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
        width: 50%;
        height: auto;
    }

    .form-container1 {
        max-width: 80%;
        margin: 40px auto;
        padding: 20px;
        background-color: #fff;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        margin-top: 50px;
    }

    .form-container {
        max-width: 80%;
        margin: 40px auto;
        padding: 20px;
        background-color: #fff;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        margin-top: 50px;
    }

    .canvas {
        width: 80%;
        margin: 20px auto;
        max-height: 1200px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
        border: 1px solid #dee2e6;
        background-color: #fff;
        padding: 20px;
    }
</style>


<main class='main-div' style="width:100%;">

    <h3 class="text-center">Dashboard</h3>
    <div class="form-container1">
        <h1><strong>Filtros</strong></h1>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="idtipofilial" class="form-label">Transportadora<span class="text-danger">*</span></label>
                <select class="form-select" id="idtipofilial" name="idtipofilial">
                    <option value="">Selecionar</option>
                    <option value="">Transportadora</option>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label for="idtipofilial" class="form-label">CD<span class="text-danger">*</span></label>
                <select class="form-select" id="idtipofilial" name="idtipofilial">
                    <option value="">Selecionar</option>
                    <option value="">CD</option>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label for="data" class="form-label">Data Inicial<span class="text-danger">*</span></label>
                <input type="date" class="form-control" id="data" name="data" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="data" class="form-label">Data Final<span class="text-danger">*</span></label>
                <input type="date" class="form-control" id="data" name="data" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="idsituacao" class="form-label">Situação<span class="text-danger">*</span></label>
                <select class="form-select" id="idsituacao" name="idsituacao">
                    <option value="">Selecionar</option>
                    <option value="">Finalizado</option>
                </select>
            </div>
            <div class="col-md-6 mb-3" style="margin-top: 30px; text-align: right;">
                <input type="button" value="Pesquisar" class="btn btn-primary">
                <input type="button" value="Limpar" class="btn btn-primary">
            </div>

            <div class="canvas">

                <canvas class="form-container-grafico" id="myPieChart"></canvas>

            </div>
        </div>
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

        <table id="mytable" class="table table-striped table-bordered display nowrap" style="width:100%">

        </table>
    </div>


</main>
</body>
<script src="<?= $base; ?>/js/inicio.js"></script>

<script>
    const base = '<?= $base; ?>';
</script>