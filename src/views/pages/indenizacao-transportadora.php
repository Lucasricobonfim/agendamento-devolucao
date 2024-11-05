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

    .dt-buttons {
        display: none !important;
    }
</style>
<main class='main-div' style="width:100%;">
    <div class="form-container">
        <h1><strong>Indenizações (Transportadora)</strong></h1>
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
                        <input hidden name="" id="idsolicitacaoAutorizar"/>
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
                        <div class="col-md-6 mb-3">
                            <label for="idtipofilial" class="form-label">Negócio<span class="text-danger">*</span></label>
                            <select class="form-select" id="idtipofilial" name="idtipofilial">
                                <option value="">Selecionar</option>
                                <option value="">ECOMMERCE</option>
                                <option value="">ATACADO</option>
                            </select>
                        </div>
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