
var self = this;

$(document).ready(function () {

    

    $('#logar').on('click', function () {
        let dados = {
            login: $('#login').val(),
            senha: $('#senha').val(),
        }

        if (!app.validarCampos(dados)) {
            Swal.fire({
                icon: "warning",
                title: "Atenção!!",
                text: "Preencha todos os campos!"
            });
            return
        }
        logar(dados)
    })
})

function logar(dados) {
    console.log('Chegando no logar', dados); 

    app.callController({
        method: 'POST',
        url: base + '/logar',
        params: dados,
        onSuccess(res) {
            console.log('Resposta recebida do servidor:', res); 
            var rec = res[0];
            console.log('rec:', rec);

            if (rec.idtipo == 1) {
                const idGrupo = parseInt(rec.idgrupo, 10);

                if (idGrupo === 4 || idGrupo === 5) {
                    window.location.href = base + '/replica';
                } 
                else if (idGrupo === 1 || idGrupo === 2 || idGrupo === 3) {
                    window.location.href = base + '/inicio';
                } 
                else {
                    window.location.href = base + '/indenizacao-financeiro';
                }
            }

            if (rec.idtipo == 2) {
                Swal.fire({
                    icon: "warning",
                    title: "Atenção!!",
                    text: "Usuário ou senha inválidos!"
                });
                return;
            }
        },
        onFailure(res) {
            Swal.fire({
                icon: "error",
                title: "Atenção!!",
                text: "Erro ao logar, tente novamente mais tarde!"
            });
            return;
        }
    });
}
function mostrarSenha(){
    let inputSenha = $('#senha')
    if (inputSenha.attr('type') === 'password') {
         inputSenha.attr('type', 'text');
     } else {
         inputSenha.attr('type', 'password');
     }
 }