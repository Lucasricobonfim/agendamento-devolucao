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
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap 5 JS (compatível com a versão do CSS) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- DataTables CSS com Bootstrap 5 -->
    <link href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css" rel="stylesheet">

    <!-- DataTables JS com Bootstrap 5 -->
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
    
    <!-- DataTables Buttons -->
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.colVis.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Arquivos CSS personalizados -->
    <link rel="stylesheet" href="<?= $base; ?>/css/header/header.css">
    <link rel="stylesheet" href="<?= $base; ?>/css/tabela/tabela-responsive.css">
</head>
<body style="background-color: #EDF2F6;">
    <header class="header">
        <div>
            <h1>AGN</h1>
        </div>
        <div>
            <i class="fa-solid fa-user"></i> <?=$_SESSION['usuario'] ?>
            <a href="<?= $base; ?>/deslogar" style="color: rgb(161 161 170/var(--tw-text-opacity));">
                <i class="fas fa-sign-out-alt"></i>
            </a>
        </div>
    </header>
    <aside class="sidebar">
        <img src="<?= $base; ?>/img/logo_topo.png" alt="texte" style="width:100%; padding: 10px;">
        <ul>
            
            <li><a class="negrito" href="<?= $base; ?>/inicio">Inicio</a></li>

        <?php if($_SESSION['idgrupo'] == 1) { ?> 
            <li><a class="negrito" href="<?= $base; ?>/usuario">Manutenção de Usuários</a></li>
        <?php } ?>

        <?php if($_SESSION['idgrupo'] == 1) { ?> 
            <li><a class="negrito" href="<?= $base; ?>/transportadoras">Transportadoras</a></li>
        <?php } ?>  

        <?php if($_SESSION['idgrupo'] == 1) { ?> 
            <li><a class="negrito" href="<?= $base; ?>/centro-distribuicao">Centro de distribuição</a></li>
        <?php } ?>  

        
        <li><a class="negrito" href="<?= $base; ?>/agendamento">Agendar</a></li>
        
        <li><a class="negrito" href="<?= $base; ?>/agendamento-listar">Listar Agendamentos</a></li>
        </ul>
    </aside>