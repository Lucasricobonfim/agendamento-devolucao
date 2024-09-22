<?php $render('header');?> 

<style>

.form-container {
    max-width: 62%;
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
    margin-bottom: 20px; /* ajuste conforme necessário */
}


h5 {
    margin: 0; /* remove o espaçamento padrão */
}
</style>

<div class="form-container">

    <h1>CENTRO DE DISTRIBUIÇÃO</h1>
    <div class="header-container">
        <button id="novo" class="btn btn-primary" onclick="limparForm()">Novo</button>
        <h5>Informações básicas</h5>
    </div>

    <div style="margin-top: 50px;">
        <div class="row">
            <input id="idfilial" type="text" class="form-control"  hidden>

            <div class="mb-3">
                        <label for="nome" class="form-label">Nome<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nome" name="nome" required>
                    </div>
                    <div class="mb-3">
                        <label for="cnpj_cpf" class="form-label">CNPJ<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="cnpj_cpf" name="cnpj_cpf" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="telefone" class="form-label">Telefone<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="telefone" name="telefone" required>
                    </div>
            </div>
            <div class="form-footer">
                <button id="cadastro" class="btn btn-primary">Gravar</button>
            </div>
    </div>
</div>

<div class="form-container">
    <table id="mytable" class="table table-striped table-bordered display nowrap" style="width:100%">
        
    </table>
</div>
 


</body>
<script src="<?= $base; ?>/js/centro-distribuicao.js" ></script>
<!-- Bootstrap JS -->
<script>
    const base = '<?= $base; ?>';
</script> 