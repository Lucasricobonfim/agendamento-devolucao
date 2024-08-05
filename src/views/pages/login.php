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
  .content{
    background: linear-gradient(#1773e4, #48d);
    width: 35%;
    color: #eee;
    font-size: 14px;
    display: block;
    padding-left: 25px;
    padding-right: 25px;
    border-radius: 30px;
    position: relative;
}
.content-forms {
    margin: 25px 0;
    flex-flow: column;
    display: flex;
    width: 100%;
}
.image-gazin {
    height: 80px;
    max-height: 100%;
    display: block;
    margin: 0 auto 15px;
}
hr{
    margin: 15px 0;
    width: 100%;
    border-top: 1px solid #eeeeee1f;
}

input{
    background: rgba(255, 255, 255, 0.1);
    font-size: 18px;
    border: none;
    padding: 15px 20px 15px 20px;
    color: #fff;
    width: 100%;
}
input::-webkit-input-placeholder { 
    font-size: 17px;
    color: #fff;
    opacity: 0.5;
  }
label {
    display: inline-block;
    max-width: 100%;
    margin-bottom: 5px;
    font-weight: 700;
    font-size: 18px;
}
#esquecisenha {
    color: white;
    text-align: center;
    font-size: 18px;
    text-decoration: none;
    margin-top: 15px;
}

body{
    min-height: 100vh;
    justify-content: center;
    align-items: center;
    display: flex;
    background: linear-gradient(#c9e5e9, #ccddf9);

}
.btn{
    margin: 25px 0 0 0;
    border: none;
    background: #22b877;
    border-radius: 10px;
    font-size: 19px;
    color: #fff;
    width: 100%;
}
.btn:hover {
    color: #fff;
    background-color: #28d098;
    border-color: #28d098;
}
</style>



<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> -->

<body>

<div class="content">
  <div class="content-forms">
    <img src="<?= $base; ?>/img/logo_topo.png" class="image-gazin img-responsive">
    <hr>

    <div class="col-sm-12 form-group">
      <label for="email">Login</label>
      <input type="text" name="login" id="login" placeholder="Digite seu login" required>
    </div>

    <div class="col-sm-12 form-group">
      <label for="senha">Senha</label>
      <input type="password" name="senha" id="senha" placeholder="Digite sua senha" required>
    </div>
    <input type="button" value="Continuar" id="logar" class="btn">
  </div>
</div>
<script src="<?= $base; ?>/js/login.js"defer ></script>

<script>const base = '<?= $base; ?>';</script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</body>