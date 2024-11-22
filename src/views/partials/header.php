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



    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
    <!-- DataTables  -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.bootstrap5.min.css">
    <!-- <script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <!-- <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script> -->

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
    <link rel="stylesheet" href="<?= $base; ?>/css/header/botoes.css">
    <link rel="stylesheet" href="<?= $base; ?>/css/header/header.css">
    <link rel="stylesheet" href="<?= $base; ?>/css/header/body.css">
    <link rel="stylesheet" href="<?= $base; ?>/css/tabela/tabela-responsive.css">
    <!-- MaskPlugin -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <!-- inputmask -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.7/jquery.inputmask.min.js"></script>
</head>

<body style="background-color: #EDF2F6;">
    <div class="sair-icon" style="display: flex; align-items: center;">
        <i class="fa-solid fa-user"></i>
        <span style="margin-left: 5px;"><?= $_SESSION['usuario'] ?></span>
        <div style="border-left: 1px solid #ccc; height: 20px; margin: 0 10px;"></div>

        <a href="<?= $base; ?>/deslogar" style="color: rgb(161, 161, 170); margin-left: 7px;">
            <i class="fas fa-sign-out-alt"></i>
        </a>
    </div>
    <header class="header">
        <div>
            <i class="fas fa-bars hamburger" style="font-size: 22px;"></i>
        </div>
    </header>
    <aside class="sidebar">
        <img src="<?= $base; ?>/img/logo_topo.png" class="img-fluid" alt="texte">
        <ul>
            <li class="<?= (basename($_SERVER['REQUEST_URI']) == 'inicio') ? 'active' : ''; ?>">
                <a class="negrito" href="<?= $base; ?>/inicio">
                    <i class="fa-solid fa-house" style="margin-right: 10px; font-size: 22px;"></i>Inicio
                </a>
            </li>
            <?php if ($_SESSION['idgrupo'] == 1) { ?>
                <li class="<?= (basename($_SERVER['REQUEST_URI']) == 'usuario') ? 'active' : ''; ?>">
                    <a class="negrito" href="<?= $base; ?>/usuario">
                        <i class="fa-solid fa-users-gear" style="margin-right: 10px; font-size: 22px;"></i>Manutenção de Usuários
                    </a>
                </li>
            <?php } ?>
            <?php if ($_SESSION['idgrupo'] == 1) { ?>
                <li class="<?= (basename($_SERVER['REQUEST_URI']) == 'transportadoras') ? 'active' : ''; ?>">
                    <a class="negrito" href="<?= $base; ?>/transportadoras">
                        <i class="fa-solid fa-truck" style="margin-right: 10px; font-size: 22px;"></i>Transportadoras
                    </a>
                </li>
            <?php } ?>
            <?php if ($_SESSION['idgrupo'] == 1) { ?>
                <li class="<?= (basename($_SERVER['REQUEST_URI']) == 'centro-distribuicao') ? 'active' : ''; ?>">
                    <a class="negrito" href="<?= $base; ?>/centro-distribuicao">
                        <i class="fa-solid fa-arrow-right-to-bracket" style="margin-right: 10px; font-size: 22px;"></i>Centro de distribuição
                    </a>
                </li>
            <?php } ?>
            
            <?php if ( $_SESSION['idgrupo'] == 2) { ?>
            <li class="<?= (basename($_SERVER['REQUEST_URI']) == 'agendamento') ? 'active' : ''; ?>">
                <a class="negrito" href="<?= $base; ?>/agendamento">
                    <i class="fa-solid fa-clipboard-list" style="margin-right: 10px; font-size: 22px;"></i>Agendar
                </a>
            </li>
            <?php } ?>

            <?php if ($_SESSION['idgrupo'] == 2) { ?>
            <li class="<?= (basename($_SERVER['REQUEST_URI']) == 'agendamento-listar') ? 'active' : ''; ?>">
                <a class="negrito" href="<?= $base; ?>/agendamento-listar">
                    <i class="fa-solid fa-list-check" style="margin-right: 10px; font-size: 22px;"></i>Listar Agendamentos
                </a>
            </li>
            <?php } ?>

            <?php if ($_SESSION['idgrupo'] == 1 || $_SESSION['idgrupo'] == 3) { ?>
            <li class="<?= (basename($_SERVER['REQUEST_URI']) == 'solicitacoes') ? 'active' : ''; ?>">
                <a class="negrito" href="<?= $base; ?>/solicitacoes">
                    <i class="fa-solid fa-list-check" style="margin-right: 10px; font-size: 22px;"></i>Solicitações
                </a>
            </li>
            <?php } ?>
        </ul>
    </aside>
    <script>
        $('.hamburger').on('click', function() {
            $('.sidebar').toggleClass('open');
            $('body').toggleClass('sidebar-open');
            $('.header').toggleClass('sidebar-open');

            if ($('.sidebar').hasClass('open')) {
                $('.sidebar').css('left', '0');
                $('body').css('margin-left', '250px');
                $('.header').css('margin-left', '250px');
            } else {
                $('.sidebar').css('left', '-250px');
                $('body').css('margin-left', '0');
                $('.header').css('margin-left', '0');
            }
        });
    </script>