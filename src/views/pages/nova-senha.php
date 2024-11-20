<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Senha</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<script src="<?= $base; ?>/js/esqueceusenha.js"></script>


<!-- <body> -->

    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card shadow-lg" style="width: 100%; max-width: 400px;">
            <div class="card-body">
                <h5 class="card-title text-center mb-4">Alterar Senha</h5>
                <!-- <form action="#" method="POST"> -->

                <!-- <input type="text" class="form-control" id="idusuario" value="" >
                <input type="email" class="form-control" id="email"  > -->
                    <!-- Campo Nova Senha -->
                    <div class="mb-3">
                        <label for="novaSenha" class="form-label">Nova Senha</label>
                        <input 
                            type="password" 
                            id="novaSenha" 
                            name="novaSenha" 
                            class="form-control" 
                            placeholder="Digite sua nova senha" 
                            required>
                            <!-- <i onclick="mostrarSenha()" id="toggleSenha" class="fa fa-eye" style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer;"></i> -->
                    </div>

                    <!-- Campo Confirmar Nova Senha -->
                    <div class="mb-3">
                        <label for="confirmarSenha" class="form-label">Confirme a Nova Senha</label>
                        <input 
                            type="password" 
                            id="confirmarSenha" 
                            name="confirmarSenha" 
                            class="form-control" 
                            placeholder="Confirme sua nova senha" 
                            required>
                        <!-- <i onclick="mostrarSenha()" id="toggleSenha" class="fa fa-eye" style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer;"></i> -->
                    </div>

                    <!-- Botão de Enviar -->
                    <div class="d-grid">
                        <button type="button" id="btnalterarsenha" class="btn btn-primary">Alterar Senha</button>
                    </div>
                <!-- </form> -->
            </div>
<!-- </body> -->
<script>
    const base = '<?= $base; ?>';
</script>