<?php $render('header'); ?>

<style>
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

    .header-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 80px;
        /* ajuste conforme necessário */
    }

    h5 {
        margin: 0;
        /* remove o espaçamento padrão */
    }

    textarea#observacao {
        width: 100%;
        padding: 10px;
        border: 1px solid #ced4da;
        border-radius: 4px;
        font-size: 16px;
        box-sizing: border-box;
        resize: vertical;
        min-height: 100px;
    }

    .cards {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px;
        padding: 20px;
    }

    .card {
        background-color: #ffffff;
        border-radius: 10px;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.3s ease;
        text-align: center;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        padding: 20px;
        flex: 1 1 calc(25% - 20px);
        min-height: 150px;
        margin: 10px 0;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }


    .card:hover {
        background-color: #0e5caa;
        transform: translateY(-5px);
    }


    @media (max-width: 1200px) {
        .card {
            flex: 1 1 calc(50% - 20px);
        }
    }


    @media (max-width: 768px) {
        .card {
            flex: 1 1 calc(80% - 20px);
        }
    }

    @media (max-width: 480px) {
        .card {
            flex: 1 1 calc(50% - 20px);
        }

        .card h5 {
            font-size: 1.2rem;
        }

        .card p {
            font-size: 1rem;
        }
    }


    .dt-buttons {
        display: none !important;
    }

    .modal-body {
        padding: 15px 20px;
        word-break: break-word;
        vertical-align: middle;
    }
</style>

<main class='main-div' style="width:100%;">
    <div class="cards">
        <div class="card" style="background-color: #ffa5002e;" data-idsituacao="1">
            <h5 style="color: orange"><strong>Solicitações Pendentes</strong></h5>
            <p id="pendentesCount">0 solicitações pendentes</p>
        </div>

        <div class="card" style="background-color: #0000ff1a;" data-idsituacao="2">
            <h5 style="color: blue"><strong>Solicitações Em andamento</strong></h5>
            <p id="andamentoCount">0 solicitações em andamento</p>
        </div>

        <div class="card" style="background-color: #00800024;" data-idsituacao="3">
            <h5 style="color: green"><strong>Solicitações Finalizadas</strong></h5>
            <p id="finalizadasCount">0 solicitações finalizadas</p>
        </div>

        <div class="card" style="background-color: #ff000029;" data-idsituacao="4">
            <h5 style="color: red"><strong>Solicitações Canceladas/Recusadas</strong></h5>
            <p id="canceladasCount">0 solicitações canceladas</p>
        </div>
    </div>
    <div class="form-container">

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

        <h1><strong>Agendamento Transportadora</strong></h1>
        <table id="mytable" class="table table-striped table-bordered display nowrap" style="width:100%">

        </table>
    </div>


    <!-- MODAL  -->

    <div class="modal fade" id="observacaoModal" tabindex="-1" aria-labelledby="observacaoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="observacaoModalLabel">Observação</h5>
                    <button type="button" onclick="fechaModalObs()" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Conteúdo da observação -->
                    <h4 id="conteudo_obs"></h4>

                </div>
                <div class="modal-footer">
                    <button type="button" onclick="fechaModalObs()" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

</main>

</body>
<script src="<?= $base; ?>/js/agendamento.js"></script>
<!-- Bootstrap JS -->
<script>
    const base = '<?= $base; ?>';
</script>