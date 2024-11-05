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

    #anexo {
        display: none;
    }

    .custom-upload-btn {
        width: 21%;
        display: inline-block;
        padding: 10px 15px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
        font-weight: bold;
        margin-top: 10px;
        transition: background-color 0.3s ease;
    }

    .custom-upload-btn:hover {
        background-color: #0056b3;
    }

    .form-row {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        justify-content: space-between;
    }

    .form-group,
    .form-row>div {
        flex: 1 1 48%;
        min-width: 200px;
    }

    .btn-right {
        float: right;
        margin-top: -50px;
    }

    .table-container {
        padding-top: 10px;
    }

    #botao {
        margin-top: 20px;
    }
</style>

<main class='main-div' style="width:100%;">

    <div class="form-container">
        <div class="header-container">
            <h1><strong>Indenizações</strong></h1>
            <button type="button" class="btn btn-primary btn-right" data-bs-toggle="modal" data-bs-target="#solicitarIndenizacaoModal">
                Solicitar Indenização
            </button>
        </div>
        <table id="mytable" class="table table-striped table-bordered display nowrap" style="width:100%;"></table>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="solicitarIndenizacaoModal" tabindex="-1" aria-labelledby="solicitarIndenizacaoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="solicitarIndenizacaoModalLabel">Solicitações de Indenização</h5>
                </div>
                <div class="modal-body">
                    <input id="idusuario" type="text" class="form-control" hidden>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="nota" class="form-label">NF<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nota" name="nota" placeholder="Número da nota">
                        </div>
                        <div class="form-group">
                            <label for="nota2" class="form-label">NFD<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nota2" name="nota2" placeholder="Número da nota">
                        </div>
                        <div class="form-group">
                            <label for="idnegocio" class="form-label">Negócio<span class="text-danger">*</span></label>
                            <select class="form-select oppp" id="idnegocio" name="idnegocio" required>
                                <option value="">Selecione</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tipoIndenizacao" class="form-label">Tipo de Indenização<span class="text-danger">*</span></label>
                            <select class="form-select" id="tipoindenizacao" name="tipoindenizacao" required>
                                <option value="">Selecione</option>
                                <option value="15%">15%</option>
                                <option value="30%">30%</option>
                                <option value="100%">100%</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="idfilial" class="form-label">Transportadora<span class="text-danger">*</span></label>
                            <select class="form-select opp" id="idfilial" name="idfilial" required>
                                <option value="">Selecione</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="data" class="form-label">Data<span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="data" name="data" required>
                        </div>
                        <div class="form-group" >
                            <label for="anexo">Anexo (imagem):<span class="text-danger">*</span></label>
                            <input type="file" name="anexo" id="anexo" accept="image/*">
                            <label for="anexo" class="custom-upload-btn" style="display: block;">Escolher Arquivo</label>
                            <span id="file-chosen">Nenhum arquivo escolhido</span>
                        </div>
                    </div>
                    <br>
                    <div class="mb-3">
                        <label for="observacao" class="form-label">Motivo da recusa<span class="text-danger">*</span></label>
                        <textarea id="observacao" name="observacao" placeholder="Informe observações" maxlength="500"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="fechaModalIndenizacao()">Fechar</button>
                    <button type="submit" class="btn btn-success" id="solicitar">Enviar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL  -->

    <div class="modal fade" id="observacaoModal" tabindex="-1" aria-labelledby="observacaoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="observacaoModalLabel">Observacao</h5>
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

<script src="<?= $base; ?>/js/indenizacao-cd.js"></script>
<script>
    const base = '<?= $base; ?>';
</script>