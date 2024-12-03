
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

    app.callController({
        method: 'POST',
        url: base + '/logar',
        params: dados,
        onSuccess(res){
        var rec = res[0]
        if(rec.idtipo == 1){
            window.location.href = base+'/inicio';
        }

        if(rec.idtipo == 2){
            Swal.fire({
                icon: "warning",
                title: "Atenção!!",
                text: "Usuario ou senha invalidos!"
            });
            return
        }   
        },
        onFailure(res){
            console.log(res)
            Swal.fire({
                icon: "error",
                title: "Atenção!!",
                text: "Erro ao Logar Tente novmente mais tarde!"
            });
            return
        }
    })
}
function mostrarSenha(){
    let inputSenha = $('#senha')
    if (inputSenha.attr('type') === 'password') {
         inputSenha.attr('type', 'text');
     } else {
         inputSenha.attr('type', 'password');
     }
 }