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
        margin-bottom: 0;
    }

    h5 {
        margin: 0;
    }

    textarea#observacao {
        width: 100%;
        padding: 10px;
        /* border: 1px solid #ced4da; */
        border-radius: 4px;
        font-size: 16px;
        box-sizing: border-box;
        resize: vertical;
        min-height: 100px;
    }
</style>

<main class='main-div' style="width:100%;">
    
    <div class="form-container">
        <div class="titulo-container">
            <h1><strong>Agendamento de devolução</strong></h1>
            <div class="header-container">
                <h5>Informe os dados abaixo para continuar sua solicitação.</h5>
            </div>
        </div>
        <div style="margin-top: 50px;">
            <div class="row">
                <input id="idusuario" type="text" class="form-control" hidden>
                <div class="col-md-6 mb-3">
                    <label for="idfilial" class="form-label">Centro de Distuição<span class="text-danger">*</span></label>
                    <select class="form-select opp" id="idfilial" name="idfilial" required>
                        <option value="">Selecione</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="placa" class="form-label">Placa<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="placa" name="placa" placeholder="Placa" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="data" class="form-label">Data<span class="text-danger">*</span></label>
                    <input type="date" class="form-control" id="data" name="data" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="qtd" class="form-label">QTD de notas<span class="text-danger">*</span></label>
                    <input type="number" class="form-control" id="quantidadenota" name="qtd" min="1"  placeholder="QTD" required>
                </div>
                <div class="mb-3">
                    <label for="obs" class="form-label">OBS<span class="text-danger">*</span></label>
                    <textarea id="observacao" name="observacao" placeholder="Informe observações" maxlength="500"></textarea>
                </div>
            </div>
            <div class="form-footer">
                <button id="solicitar" class="btn-custom">Solicitar agendamento</button>
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