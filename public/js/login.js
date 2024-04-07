$(document).ready(function () {
    $('#logar').on('click', function () {
        let dados = {
            login: $('#login').val(),
            senha: $('#senha').val(),  }


            logar(dados)
    })

    
})

function logar(dados){

    $.ajax({
        type: "post",
        url: base + '/logar',
        data: (
            dados
        ),
        success: function (res) {
            // if()
            console.log(res)
        }
    })
}