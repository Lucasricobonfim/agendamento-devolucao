<?php 
$render('header');?>
<body>

  <div class="container">
    <h2>Cadastro de Transportadora</h2>
    <div class="form-group">
      <label for="nome">Nome:</label>
      <input type="text" class="form-control" id="nome" placeholder="Digite o nome da transportadora">
    </div>
    <div class="form-group">
      <label for="cnpj_cpf">CNPJ:</label>
      <input type="text" class="form-control" id="cnpj_cpf" placeholder="Digite o CNPJ da transportadora">
    </div>
    <div class="form-group">
      <label for="email">E-mail:</label>
      <input type="text" class="form-control" id="email" placeholder="Digite o endereço da transportadora">
    </div>
    <div class="form-group">
      <label for="telefone">Telefone:</label>
      <input type="text" class="form-control" id="telefone" placeholder="Digite o telefone da transportadora">
    </div>
    <input id="cadastro" type="button" value="Cadastrar" class="btn btn-primary">
  </div>
  <script src="<?= $base; ?>/js/transportadoras.js"></script>
</body>