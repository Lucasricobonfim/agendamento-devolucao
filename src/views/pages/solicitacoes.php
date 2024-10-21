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
        margin-top: 100px;
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
        margin-bottom: 20px;
        justify-content: center;
    }

    .card {
        background-color: #ffffff;
        border-radius: 10px;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.3s ease;
        text-align: center;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        padding: 20px;
        flex: 1;
        margin: 0 10px;
    }

    .card:hover {
        background-color: #0e5caa;
        transform: translateY(-5px);
    }
</style>
<main class='main-div' style="width:100%; margin-left: 100px;">

    <div class="cards">
        <div class="card" style="background-color: #ffa5002e;">
            <h5 style="color: orange"><strong>Solicitações Pendentes</strong></h5>
            <p id="pendentesCount">0 solicitações pendentes</p>
        </div>

        <div class="card" style="background-color: #0000ff1a;">
            <h5 style="color: blue"><strong>Solicitações Em andamento</strong></h5>
            <p id="andamentoCount">0 solicitações em andamento</p> <!-- Corrigido ID -->
        </div>

        <div class="card" style="background-color: #00800024;">
            <h5 style="color: green"><strong>Solicitações Finalizadas</strong></h5>
            <p id="finalizadasCount">0 solicitações finalizadas</p> <!-- Corrigido ID -->
        </div>

        <div class="card" style="background-color: #ff000029;">
            <h5 style="color: red"><strong>Solicitações Canceladas/Recusadas</strong></h5>
            <p id="canceladasCount">0 solicitações canceladas</p> <!-- Corrigido ID -->
        </div>
    </div>
    <div class="form-container">
        <h1><strong>Solicitações Agendamento (CD)</strong></h1>
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

    <!-- FIM MODAL -->

    <!-- MODAL ACEITACAO -->

    <div class="modal fade" id="modalAceitacao" tabindex="-1" aria-labelledby="tituloModalObs" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tituloModalObs">Observação</h5>
                    <button type="button" onclick="fechaModalAceitar()" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Conteúdo da observação -->
                    <input hidden name="" id="idsolicitacao"></input>
                    <input hidden name="" id="idsituacao"></input>
                    <textarea class="form-control" name="" id="observacaoact"></textarea>

                </div>
                <div class="modal-footer">
                    <button type="button" onclick="confimarSolicitacao()" class="btn btn-secondary">Confirmar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- FIM MODAL ACEITACAO -->

</main>


</body>
<script src="<?= $base; ?>/js/solicitacoes.js"></script>
<!-- Bootstrap JS -->
<script>
    const base = '<?= $base; ?>';
</script>