<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>

<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        display: flex;
        height: 100vh;
    }

    header {
        width: 250px;
        background-color: #3498db;
        color: white;
        height: 100vh;
        position: fixed;
        top: 0;
        left: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        overflow-y: auto;
        border-right: 2px solid #2980b9;
    }

    .sidebar-header {
        padding: 20px;
        text-align: center;
        border-bottom: 1px solid #2980b9;
        width: 100%;
    }

    .sidebar-header h2 {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        font-size: 1.5em;
    }

    .sidebar ul {
        list-style-type: none;
        padding: 0;
        width: 100%;
    }

    .sidebar ul li {
        width: 100%;
        border-bottom: 1px solid #2980b9;
    }

    .sidebar ul li a {
        color: white;
        text-decoration: none;
        padding: 15px;
        display: block;
        width: 100%;
        text-align: center;
        box-sizing: border-box;
    }

    .sidebar ul li a:hover {
        background-color: #6ba7ce;
    }

    .content {
        margin-left: 250px;
        padding: 20px;
        flex-grow: 1;
        background-color: #ecf0f1;
        overflow-y: auto;
    }
</style>


    <header>
        <div class="sidebar-header">
            <h2><i class="fas fa-gem"></i> SIdev</h2>
        </div>
        <ul>
            <li><a href="<?= $base; ?>/transportadoras"><i class="fas fa-truck"></i> Cadastro Transportadora</a></li>
        </ul>
    </header>

    <div class="content">
        <!-- Sua área de conteúdo aqui -->
    </div>

</html>