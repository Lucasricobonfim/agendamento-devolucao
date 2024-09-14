<?php $render('header');?> 
<link rel="stylesheet" href="<?= $base; ?>/css/transportadoras/transportadoras.css">

<style>
        .form-header {
            margin-bottom: 0;
            float: right;
        }

        .form-header small {
            font-weight: 500;
            color: #6c757d;
        }

        .table-c {
            max-width: 50%;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-top: 100px;
        }

        .container {
            max-width: 1000px;
            margin: auto;
        }
        .dataTables_wrapper .dt-buttons {
            float: left;
        }
        .dataTables_length {
            float: right;
            margin-right: 20px;
        }
        .dataTables_filter {
            float: right;
        }

        .dataTables_wrapper {
            width: 100% !important; 
            overflow-x: auto !important;
        }
        .table-responsive {
            width: 100% !important;
            overflow-x: auto !important;
        }
        .table>thead>tr>th{
            background-color: blue !important;
            color: white !important;
            border-radius: 5px !important;
            border: none !important;
            margin-left: 55px !important;
        }

        #mytable_filter label input{
            width: 600px !important;
            margin-right: 290px !important;
            border-radius: 8px !important;
        }

</style>

<div class="form-container">
    <button id="novo" class="btn btn-primary" onclick="limparForm()">Novo</button>
    <div class="form-header">
        <h5>Informações básicas </h5>
    </div>

    <div style="margin-top: 50px;">
        <div class="row">
            <input id="idfilial" type="text" class="form-control"  hidden>

            <div class="col-md-6 mb-3">
                <label for="nome" class="form-label">Nome<span class="text-danger">*</span></label>
                <input id="nome" type="text" class="form-control" placeholder="Nome">
            </div>
            <div class="col-md-6 mb-3">
                <label for="cnpj" class="form-label">CNPJ<span class="text-danger">*</span></label>
                <input id="cnpj_cpf" type="text" class="form-control" placeholder="CNPJ">
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="branch" class="form-label">E-mail<span class="text-danger">*</span></label>
                <input id="email" type="text" class="form-control" placeholder="E-mail">
            </div>
            <div class="col-md-6 mb-3">
                <label for="branch" class="form-label">Telefone<span class="text-danger">*</span></label>
                <input id="telefone" type="text" class="form-control" placeholder="Telefone">
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
<script src="<?= $base; ?>/js/transportadoras.js" ></script>
<!-- Bootstrap JS -->
<script>
    const base = '<?= $base; ?>';
    const ret = '<?= $dados ?>';
</script> 