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
        margin-bottom: 20px;
        /* ajuste conforme necessário */
    }


    h5 {
        margin: 0;
    }
    .form-cad{
        margin-left: 100px;
    }
</style>

<main class='main-div' style="width:100%;">
    <div class="form-container">
        <div class="header-container">
            <button id="novo" class="btn-custom" onclick="limparForm()">Novo</button>
            <h5 id="form-title" class="form-cad">Cadastrando Negocio</h5>
            <h5>Informações básicas</h5>
        </div>

        <div style="margin-top: 50px;">
            <div class="row">
                <input id="idfilial" type="text" class="form-control" hidden>
                <div class="col-md-6 mb-3">
                    <label for="nome" class="form-label">Nome<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="nome" placeholder="Nome">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">E-mail<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="email" placeholder="E-mail">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="idtipofilial" class="form-label">Negócio<span class="text-danger">*</span></label>
                    <select class="form-select" id="idtipofilial" name="idtipofilial">
                        <option value="">Selecionar</option>
                        <option value="4">ATACADO</option>
                        <option value="5">E-COMMERCE</option>
                        <option value="6">NOVA VENDA</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="telefone" class="form-label">Telefone<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="telefone" placeholder="Telefone">
                </div>
            </div>
            <div class="form-footer">
                <button id="cadastro" class="btn-custom">Gravar</button>
            </div>
        </div>
    </div>

    <div class="form-container">
        <h1><strong>Negocio</strong></h1>
        Gestão de negocios
        <table id="mytable" class="table table-bordered display nowrap" style="width:100%">

        </table>
    </div>


</main>

</body>
<script src="<?= $base; ?>/js/negocio.js"></script>
<!-- Bootstrap JS -->
<script>
    const base = '<?= $base; ?>';
</script>