<?php $render('header'); ?>

<style>
    .form-container {
        max-width: 99%;
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
    }

    h5 {
        margin: 0;
    }

    textarea#observacao {
        width: 100%;
        padding: 10px;
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
        gap: 15px;
        padding: 20px;
    }

    .card {
        background-color: #ffffff;
        border-radius: 10px;
        border: 1px solid #dee2e6;
        cursor: pointer;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        text-align: center;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        padding: 20px;
        flex: 1 1 calc(20% - 20px);
        min-height: 150px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }

    /* Cores de texto para cada status */
    .card[data-idsituacao="1"] h5,
    .card[data-idsituacao="1"] p {
        color: orange;
    }

    .card[data-idsituacao="2"] h5,
    .card[data-idsituacao="2"] p {
        color: blue;
    }

    .card[data-idsituacao="3"] h5,
    .card[data-idsituacao="3"] p {
        color: green;
    }

    .card[data-idsituacao="4"] h5,
    .card[data-idsituacao="4"] p {
        color: red;
    }

    .card[data-idsituacao="5"] h5,
    .card[data-idsituacao="5"] p {
        color: #6a1b9a;
    }

    /* Barra de carregamento em azul */
    .card::after {
        content: "";
        position: absolute;
        bottom: 0;
        left: 0;
        height: 4px;
        width: 70%;
        background-color: #007bff;
        animation: loadBar 1.5s ease forwards;
    }

    @keyframes loadBar {
        0% {
            width: 0;
        }

        70% {
            width: 70%;
        }
    }

    /* Efeito hover leve */
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
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
            flex: 1 1 calc(100% - 20px);
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

    .modal-lg {
        max-width: 50%;
        min-height: 500px;
    }

    /* Modal */
    @media (max-width: 768px) {
        .modal-lg {
            max-width: 90%;
        }

        .modal-body {
            font-size: 0.8em;
        }
    }

    @media (max-width: 576px) {
        .modal-lg {
            max-width: 100%;
        }
    }

    .modal-body {
        flex: 1;
        overflow-y: auto;
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
            <h5 style="color: red"><strong>Solicitações Recusadas</strong></h5>
            <p id="recusadasCount">0 solicitações recusadas</p>
        </div>
        <div class="card" style="background-color: #b39ddb;" data-idsituacao="5">
            <h5 style="color: b39ddb"><strong>Solicitações Canceladas</strong></h5>
            <p id="canceladasCount">0 solicitações canceladas</p>
        </div>
    </div>
    
    <div class="form-container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1><strong>Agendamento Transportadora</strong></h1>
            <div class="dropdown ms-auto">
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
        <table id="mytable" class="table table-striped table-bordered display nowrap" style="width:100%"></table>
    </div>


    <!-- MODAL  -->

    <div class="modal fade" id="observacaoModal" tabindex="-1" aria-labelledby="observacaoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="observacaoModalLabel">Observação</h5>
                    <button type="button" onclick="fechaModalObs()" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Conteúdo da observação -->
                    <!-- <h4 id="conteudo_obs"></h4>  -->

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Observação</th>
                                <th scope="col">Situação</th>
                                <th scope="col">Data</th>
                            </tr>
                        </thead>
                        <tbody class="obshist">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <!-- MODDAL REAGENDER -->
    <div class="modal fade" id="modalReagendar" tabindex="-1" aria-labelledby="reagendarModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="observacaoModalLabel">Observação</h5>
                    <button type="button" onclick="fecharModalReagendar()" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                <form>
                    <div class="mb-3">
                        <input type="text" disabled class="form-control" id="idsolicitacao" required style="display: none;">

                        <label for="obs" class="form-label">OBS<span class="text-danger">*</span></label>
                        <textarea id="observacao" name="observacaoReagendar" placeholder="Informe observações" maxlength="500"></textarea>

                        <label for="dataReagendamento" class="form-label">Data para Reagendar</label>
                        <input type="date" class="form-control" id="dataReagendamento" required>
                    </div>
                    <button type="button" onclick="reagendar()"  class="btn btn-primary w-100">Reagendar</button>
                </form>
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