$(document).ready(function () {
    $('#cadastro').on('click', function () {
        let dados = {
            nome: $('#nome').val(),
            cnpj_cpf: $('#cnpj_cpf').val(),
            email: $('#email').val(),
            telefone: $('#telefone').val(),
        }
        if(dados.cnpj_cpf == '' || dados.email == '' || dados.nome == '' || dados.telefone == ''){
                Swal.fire({
                    icon: "error",
                    title: "Atenção!!",
                    text: "Preencha todos os campos!"
                });
                return
        }
        cadastro(dados)
    })


})
function cadastro(dados) {
    $.ajax({
        type: "post",
        url: base + '/cadtransportadoras',
        data: (
            dados
        ),
        success: function (res) {
            // console.log('res: ',res)
            // let data = JSON.parse(res);
            // if (data[0]['success'] != true) {
            //     Swal.fire({
            //         icon: "error",
            //         title: "Atenção!!",
            //         text: "Dados Invalidos"
            //     });
            //     return
            // }
     
        }
    })
}