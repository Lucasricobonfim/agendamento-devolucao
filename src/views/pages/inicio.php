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

    .dt-buttons {
        display: none !important;
    }
</style>


<main class='main-div' style="width:100%;">

    <h3 class="text-center">Dashboard</h3>
    <div class="form-container1">
        <h1><strong>Filtros</strong></h1>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="idtipofilial" class="form-label">Transportadora<span class="text-danger">*</span></label>
                <select <?php if ($_SESSION['idgrupo'] == 2) { ?> disabled <?php }  ?> class="form-select oppt" id="idtransportadora" name="idtransportadora">

                </select>
            </div>



            <div class="col-md-6 mb-3">
                <label for="idtipofilial" class="form-label">CD<span class="text-danger">*</span></label>
                <select <?php if ($_SESSION['idgrupo'] == 3) { ?> disabled <?php }  ?> class="form-select oppc" id="idcd" name="idcd">
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label for="data" class="form-label">Data Inicial<span class="text-danger">*</span></label>
                <input type="date" class="form-control" id="datainicio" name="data" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="data" class="form-label">Data Final<span class="text-danger">*</span></label>
                <input type="date" class="form-control" id="datafim" name="data" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="idsituacao" class="form-label">Situação<span class="text-danger">*</span></label>
                <select class="form-select opps" id="idsituacao" name="idsituacao">

                </select>
            </div>
            <div class="col-md-6 mb-3" style="margin-top: 30px; text-align: right;">
                <input type="button" id="pesquisar" value="Pesquisar" class="btn btn-primary">


                <button onclick="Limpar(<?= $_SESSION['idgrupo'] ?>)" type="button" id="limpar" value="Limpar" class="btn btn-primary">Limpar</button>



            </div>

            <div class="canvas">

                <canvas class="form-container-grafico" id="myPieChart"></canvas>

                <div id="noDataMessage" style="display: none; text-align: center; font-size: 18px; color: #555;">
                    SEM DADOS
                </div>


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

    <div class="modal fade" id="observacaoModal" tabindex="-1" aria-labelledby="observacaoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="observacaoModalLabel">Observação</h5>
                    <button type="button" onclick="fechaModalObs()" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Observação</th>
                                <th scope="col">Situação</th>
                                <th scope="col">Data Observação</th>
                            </tr>
                        </thead>
                        <tbody class="obshist">

                          
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


</main>
</body>
<script src="<?= $base; ?>/js/inicio.js"></script>

<script>
    const base = '<?= $base; ?>';
</script>