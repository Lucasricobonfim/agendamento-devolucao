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
        /* Azul padrão */
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

    /* Modal Historico*/
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

    .modal-lg {
        max-width: 50%;
        min-height: 500px;
    }
</style>
<main class='main-div' style="width:100%;">
    <div class="cards">
        <div class="card" style="background-color: #ffa5002e;" data-idsituacao="8">
            <h5 style="color: orange"><strong>Indenizações Pendentes</strong></h5>
            <p id="pendentesCount" style="color: orange">0 indenizações pendentes</p>
        </div>

        <div class="card" style="background-color: #e057202e;" data-idsituacao="6">
            <h5 style="color: #e05720"><strong>Indenizações Contestadas</strong></h5>
            <p id="contestadasCount" style="color: #e05720">0 indenizações contestadas</p>
        </div>

        <div class="card" style="background-color: #00800024;" data-idsituacao="7">
            <h5 style="color: green"><strong>Indenizações autorizadas</strong></h5>
            <p id="autorizadasCount" style="color: green">0 indenizações autorizadas</p>
        </div>

        <div class="card" style="background-color: #B0E0E6;" data-idsituacao="9">
            <h5><strong>Indenizações Faturadas</strong></h5>
            <p id="faturadasCount">0 indenizações faturadas</p>
        </div>
    </div>
    <div class="form-container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="mb-0"><strong>Indenizações (Transportadora)</strong></h1>
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
        </div>
        <!-- Tabela -->
        <table id="mytable" class="table table-striped table-bordered display nowrap" style="width:100%">

        </table>
    </div>

    <!-- MODAL  -->

    <div class="modal fade" id="observacaoModal" tabindex="-1" aria-labelledby="observacaoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="observacaoModalLabel">Observacao</h5>
                    <button type="button" onclick="fechaModalObs()" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Conteúdo da observação -->
                    <!-- <h4 id="conteudo_obs"></h4>  -->

                    <table id="modal-media" class="table table-striped">
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
                <div class="modal-footer">
                    <button type="button" onclick="fechaModalObs()" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- FIM MODAL -->

    <!-- Modal para Autorizar -->
    <div class="modal fade" id="modalAutorizar" tabindex="-1" role="dialog" aria-labelledby="tituloModalObs" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tituloModalObs">Autorizar Solicitação</h5>
                    <button type="button" onclick="fechaModalObs()" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formAutorizar">
                        <div class="form-group">
                            <label for="cnpj">CNPJ</label>
                            <input type="text" class="form-control" id="cnpj" placeholder="Digite o CNPJ" required>
                        </div>
                        <div class="form-group">
                            <label for="observacaoAutorizar">Observação</label>
                            <textarea class="form-control" id="observacaoAutorizar" rows="3" placeholder="Digite uma observação"></textarea>
                        </div>
                        <input hidden name="" id="idsolicitacaoAutorizar" />
                        <input hidden name="" id="idsituacao"></input>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="fechaModalObs()" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="confirmarAutorizar()">Confirmar Autorização</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Contestar -->
    <div class="modal fade" id="modalContestar" tabindex="-1" role="dialog" aria-labelledby="tituloModalObs" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tituloModalObs">Contestar Solicitação</h5>
                    <button type="button" onclick="fechaModalObs()" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formContestar">
                        <div class="form-group">
                            <label for="observacaoContestar">Motivo da Contestação</label>
                            <textarea class="form-control" id="observacaoContestar" rows="3" placeholder="Digite uma observação"></textarea>
                        </div>
                        <input hidden name="" id="idsolicitacaoContestar" />
                        <input hidden name="" id="idsituacao"></input>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="fechaModalObs()" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="confirmarContestar()">Confirmar Contestação</button>
                </div>
            </div>
        </div>
    </div>

</main>


</body>
<script src="<?= $base; ?>/js/indenizacao-transportadora.js"></script>
<!-- Bootstrap JS -->
<script>
    const base = '<?= $base; ?>';
</script>