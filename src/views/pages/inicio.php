<?php $render('header');?> 

<style>
.form-container {
    max-width: 60%;
    margin: 100px 300px;
    padding: 50px;
    font-size: 1.3rem;
    line-height: 2.25rem;
}

.card-container {
    display: flex; /* Para colocar os cards lado a lado */
    gap: 30px; /* Espaço entre os cards */
}

.card {
    background-color: white; /* Cor do fundo do card */
    border-radius: 8px; /* Bordas arredondadas */
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Sombra */
    padding: 30px 80px 60px 20px;
    min-width: 250px; /* Largura mínima para os cards */
    display: flex;
    flex-direction: column; /* Alinha título e descrição */
}
.card-button {
    position: absolute; /* Posiciona o botão em relação ao card */
    bottom: 10px; /* Distância da parte inferior do card */
    right: 10px; /* Distância da direita do card */
    background-color: blue; /* Cor de fundo do botão */
    color: white; /* Cor do texto do botão */
    border: none; /* Remove a borda padrão */
    border-radius: 5px; /* Bordas arredondadas do botão */
    padding: 1px 20px; /* Espaçamento interno do botão */
    cursor: pointer; /* Muda o cursor para indicar que é clicável */
    font-size: 14px; /* Tamanho da fonte */
    text-decoration: none; /* Remove a linha embaixo do texto */
}

.card-button:hover {
    background-color: darkblue; /* Muda a cor ao passar o mouse */
}

</style>

<div class="form-container">
    <span class="text-3xl font-bold">
        <h1>Bem-vindo(a), Lucas</h1>
        <h4>Centro de Distribuição</h4>
    </span>
    
    <div class="card-container">
        <div class="card">
            <h2>Agendamento</h2>
            <p>Solicitar um agendamento.</p>
            <a href="#" class="card-button">Acessar</a>
        </div>

        <div class="card">
            <h2>Solicitações</h2>
            <p>Gestão de solicitações de agendamento.</p>
            <a href="#" class="card-button">Acessar</a>
        </div>
    </div>
</div>

</body>
<script src="<?= $base; ?>/js/inicio.js" ></script>
<!-- Bootstrap JS -->
<script>
    const base = '<?= $base; ?>';
</script> 