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
</style>
<script>
    const base = '<?= $base; ?>';
</script>
<style>
    body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    display: flex;
    height: 100vh;
}

.sidebar {
    width: 250px;
    background-color: #3498db;
    color: white;
    height: 100%;
    position: fixed;
    overflow-y: auto;
}

.sidebar-header {
    padding: 20px;
    text-align: center;
    border-bottom: 1px solid #3498db;
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
}

.sidebar ul li {
    padding: 15px;
    border-bottom: 1px solid #3498db;
}

.sidebar ul li a {
    color: white;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 10px;
}

.sidebar ul li a:hover {
    background-color: #6ba7ce;
    padding: 8px;
}

.content {
    margin-left: 250px;
    padding: 20px;
    flex-grow: 1;
    background-color: #ecf0f1;
    overflow-y: auto;
}

header {
    background-color: #3498db;
    color: white;
    padding: 10px 20px;
    text-align: center;
}

.dashboard-section {
    background-color: white;
    border-radius: 5px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    padding: 20px;
    margin-bottom: 20px;
}

.delivery-capacity {
    display: flex;
    justify-content: space-around;
}

.capacity-item {
    text-align: center;
}

.transporters {
    list-style-type: none;
    padding: 0;
}

.transporters li {
    padding: 10px;
    border-bottom: 1px solid #ddd;
}

.top-deliverers {
    list-style-type: none;
    padding: 0;
}

.top-deliverers li {
    padding: 10px;
    border-bottom: 1px solid #ddd;
}
</style>
 <body> 
    <div class="sidebar">
        <div class="sidebar-header">
            <h2><i class="fas fa-gem"></i> SIdev</h2>
        </div>
        <ul>
            <li><a href="<?= $base; ?>/transportadoras"><i class="fas fa-truck"></i> Cadastro Transportadora</a></li>
        </ul>
    </div>
    <!-- <div>
    </div>
     -->
    <!-- <div class="content">
        <header>
            <h1>Dashboard</h1>
            <p>Bem-vindo(a) Gerenciamento de Devoluções</p>
        </header>
        <main>
            <section class="dashboard-section">
                <h2>Finalizadas x Em andamento</h2>
                <canvas id="pieChart"></canvas>
            </section>
            <section class="dashboard-section">
                <h3>Transportadoras</h3>
                <ul class="transporters">
                    <li>IDH TRANSPORTES</li>
                    <li>ALFA TRANSPORTES</li>
                    <li>ATUAL CARGAS</li>
                    <li>RODONAVES</li>
                </ul>
            </section>
            <section class="dashboard-section">
                <h2>Percentual de Devoluções</h2>
                <canvas id="barChart"></canvas>
            </section>
        </main>
    </div>
     -->
 </body>
</html>