<?php $render ('header')?>

<script src="<?= $base; ?>/js/login.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<div class="container-fluid">
  <div class="row justify-content-center align-items-center" style="height: 100vh;">
    <div class="col-md-4">
      <form>
        <div class="form-group">
          <label for="">Login: </label>
          <input type="email" class="form-control" id="login" aria-describedby="emailHelp" placeholder="Seu email">
        </div>
        <div class="form-group">
          <label for="">Senha: </label>
          <input type="password" class="form-control" id="senha" placeholder="Sua Senha">
        </div>

        <input type="button" value='Logar' class="btn btn-primary" id="logar">
    </div>
  </div>
</div>


<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
