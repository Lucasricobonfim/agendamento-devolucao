
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

    // $.ajax({
    //     type: "post",
    //     url: base + '/logar',
    //     data: (
    //         dados
    //     ),
    //     success: function (res) {
    //         let data = JSON.parse(res);
    //         if (data[0]['success'] != true) {
    //             Swal.fire({
    //                 icon: "error",
    //                 title: "Atenção!!",
    //                 text: "Dados Invalidos"
    //             });
    //             return
    //         }
    //          window.location.href = base+'/transportadoras';
     
    //     }
    // })

    app.callController({
        method: 'POST',
        url: base + '/logar',
        params: dados,
        onSuccess(res){
            
            window.location.href = base+'/transportadoras';
            
        },
        onFailure(res){
            
            Swal.fire({
                icon: "error",
                title: "Atenção!!",
                text: "Erro ao Logar"
            });
            return
        }
    })
}