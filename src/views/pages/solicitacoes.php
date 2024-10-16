<?php $render('header'); ?>

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
</style>

<div class="form-container">
    <table id="mytable" class="table table-striped table-bordered display nowrap" style="width:100%">

    </table>
</div>



</body>
<script src="<?= $base; ?>/js/solicitacoes.js"></script>
<!-- Bootstrap JS -->
<script>
    const base = '<?= $base; ?>';
</script>