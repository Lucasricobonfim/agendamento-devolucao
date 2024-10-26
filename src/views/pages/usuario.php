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
        /* remove o espaçamento padrão */
    }
    .form-cad{
        margin-left: 100px;
    }
</style>

<main class='main-div' style="width:100%;">

    <div class="form-container">
        <div class="header-container">
            <button id="novo" class="btn-custom" onclick="limparForm()">Novo</button>
            <h5 id="form-title" class="form-cad">Cadastrando Usuários</h5>
            <h5>Informações básicas</h5>
        </div>

        <div style="margin-top: 50px;">
            <div class="row">
                <input id="idusuario" type="text" class="form-control" hidden>

                <div class="col-md-6 mb-3">
                    <label for="nome" class="form-label">Nome<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="login" class="form-label">Login<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="login" name="login" placeholder="Login">
                </div>
                <div class="col-md-6 mb-3" style="position: relative;">
                    <label for="senha" class="form-label">Senha<span class="text-danger">*</span></label>
                    <input type="password" class="form-control pr-5" id="senha" name="senha" placeholder="Senha">
                    <i onclick="mostrarSenha()" class="fa fa-eye" style="position: absolute; top: 74%; right: 25px; transform: translateY(-50%); cursor: pointer;"></i>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="grupo" class="form-label">Grupo<span class="text-danger">*</span></label>
                    <select class="form-select" id="idgrupo" name="idgrupo">
                        <option value="">Selecionar</option>
                        <option value="1">ADM</option>
                        <option value="2">Transportadora</option>
                        <option value="3">CD</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="idfilial" class="form-label">Filial<span class="text-danger">*</span></label>
                    <select class="form-select opp" id="idfilial" name="idfilial">
                        <option id="" value="">Selecionar</option>
                    </select>
                </div>
            </div>
            <div class="form-footer">
                <button id="cadastro" class="btn-custom">Gravar</button>
            </div>
        </div>
    </div>

    <div class="form-container">
        <h1><strong>Usuários</strong></h1>
        Gestão de usuários e acessos
        <table id="mytable" class="table table-bordered display nowrap" style="width:100%">

        </table>
    </div>

</main>

</body>
<script src="<?= $base; ?>/js/usuario.js"></script>
<!-- Bootstrap JS -->
<script>
    const base = '<?= $base; ?>';
</script>