<?php
if (!isset($_SESSION['token'])) {
    header("Location: " . $base . '/');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
 

    <!-- Font -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> 
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
    <!-- DataTables Buttons JS -->
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.colVis.min.js"></script> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> 

    
    <link href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet">

    <!-- css do arquivo -->
    <link rel="stylesheet" href="<?= $base; ?>/css/header/header.css">
</head>
<body style="background-color: #EDF2F6;">
    <header class="header">
        <div>
            <h1>AGN</h1>
        </div>
        <div>
            <h4>Agendamento de devoluções</h4>
        </div>
        <?php if($_SESSION['idgrupo'] == 1) { ?>
            <div>
                <a style="color:white; text-decoration:none;" href="">Usuários</a>
            </div>
        <?php } ?>
        <div>
            <i class="fa-solid fa-user"></i> <?=$_SESSION['usuario'] ?>
            <a href="<?= $base; ?>/deslogar" style="color:white; text-decoration:none;">Sair</a>
        </div>
    </header>
    <aside class="sidebar">
        <img src="<?= $base; ?>/img/logo_topo.png" alt="texte" style="width:100%; padding: 10px;">
        <ul>
            <li><a class="negrito" href="<?= $base; ?>/inicio">Inicio</a></li>
            <li><a class="negrito" href="<?= $base; ?>/usuario">Manutenção de Usuários</a></li>
            <li><a class="negrito" href="<?= $base; ?>/transportadoras">Transportadoras</a></li>
            <li><a class="negrito" href="<?= $base; ?>/centro-distribuicao">Centro de distribuição</a></li>
            <li><a class="negrito" href="<?= $base; ?>/solicitacao">Solicitação</a></li>
        </ul>
    </aside>