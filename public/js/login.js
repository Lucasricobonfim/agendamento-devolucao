
var self = this;

$(document).ready(function () {

    

    $('#logar').on('click', function () {
        let dados = {
            login: $('#login').val(),
            senha: $('#senha').val(),
        }


        logar(dados)
    })


})

function logar(dados) {

    $.ajax({
        type: "post",
        url: base + '/logar',
        data: (
            dados
        ),
        success: function (res) {
            let data = JSON.parse(res);
            if (data[0]['success'] != true) {
                Swal.fire({
                    icon: "error",
                    title: "Atenção!!",
                    text: "Dados Invalidos"
                });
                return
            }
             window.location.href = base+'/dashboard';
     
        }
    })
}