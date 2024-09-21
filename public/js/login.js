
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
        
            if(res[0].ret == ''){
                Swal.fire({
                    icon: "warning",
                    title: "Atenção!!",
                    text: "Usuario ou senha invalidos!"
                });
                return
            }
            
            window.location.href = base+'/transportadoras';
            
        },
        onFailure(res){
            
            Swal.fire({
                icon: "error",
                title: "Atenção!!",
                text: "Erro ao Logar Tente novmente mais tarde!"
            });
            return
        }
    })
}