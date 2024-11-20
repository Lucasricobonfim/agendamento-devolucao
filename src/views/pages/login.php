<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title></title>


  <!-- font -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
<style>
  body,
  html {
    height: 100%;
    margin: 0;
    background-image: url('../public/img/um-grande-armazem-cheio-de-caixas-de-papelao-e-produtos-generative-ai.jpg');
    background-size: cover;
    background-position: center;
  }
  .login-container {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
  }

  .login-form {
    background-color: rgba(255, 255, 255, 0.5);
    padding: 60px;
    border-radius: 8px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    width: 100%;
    max-width: 600px;
  }

  h1 {
    font-size: 35px;
    color: #1f4a7c;
    margin-bottom: 20px;
  }

  .form-control {
    padding: 15px;
    border: 1px solid #1f4a7c;
  }

  .btn-custom {
    background-color: #103469;
    color: white;
    border: none;
    padding: 15px;
    font-size: 16px;
    transition: background-color 0.3s ease;
  }

  .btn-custom:hover {
    background-color: #1f4a7c;
    color: white;
  }

  .forgot-password {
    text-align: right;
    color: #1f4a7c;
  }

  .forgot-password a {
    color: #1f4a7c;
  }

  .forgot-password a:hover {
    color: #ffffff;
  }

  .input-group {
    margin-bottom: 15px;
  }

  .input-group-text {
    background-color: transparent;
    border: 1px solid #1f4a7c;
  }

  #esquecisenha {
    color: white;
    text-align: center;
    font-size: 18px;
    text-decoration: none;
    margin-top: 15px;
  }

  #toggleSenha {
    font-size: 1.2rem;
    color: black;
  }
</style>

<body>

  <div class="container-fluid d-flex align-items-center justify-content-center" style="height: 100vh;">
    <div class="login-form">
      <h1>Login</h1>
      <form>
        <div class="input-group">
          <span class="input-group-text"><i class="fas fa-user"></i></span>
          <input type="text" class="form-control" name="login" id="login" placeholder="Digite seu login" required>
        </div>

        <!-- <div class="col-sm-12 form-group">
          <label for="senha">Senha</label>
          <input type="password" name="senha" id="senha" placeholder="Digite sua senha" required> 
        </div>-->

        <div class="input-group">
          <span class="input-group-text"><i class="fas fa-lock"></i></span>
            <input type="password" class="form-control" name="senha" id="senha" placeholder="Digite sua senha" required>
            <i onclick="mostrarSenha()" id="toggleSenha" class="fa fa-eye" style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer;"></i>
        </div>
      </form>

      <input type="button" value="Acessar" id="logar" class="btn btn-custom w-100">

      <div class="forgot-password mt-3">
        <a href="<?= $base; ?>/trocar-senha" class="text-decoration-none">Esqueceu a senha?</a>
      </div>
    </div>

    <script src="<?= $base; ?>/js/login.js" defer></script>

    <script>
      const base = '<?= $base; ?>';
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>