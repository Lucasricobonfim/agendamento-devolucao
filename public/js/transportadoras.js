$(document).ready(function () {

    listar(ret);

  
   
    $('#cadastro').on('click', function () {
        let dados = {
            nome: $('#nome').val(),
            cnpj_cpf: $('#cnpj_cpf').val().replace(/[^\d]/g, ''),
            email: $('#email').val(),
            telefone: $('#telefone').val(),
            status: $('#status').val(),
        }

        if (!app.validarCampos(dados)) {
            Swal.fire({
                icon: "warning",
                title: "Atenção!!",
                text: "Preencha todos os campos!"
            });
            return
        }
        if(!app.validarCNPJ(dados.cnpj_cpf)){
            Swal.fire({
                icon: "warning",
                title: "Atenção!!",
                text: "CNPJ Inválido!"
            });
            return false;
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
            let data = JSON.parse(res);
            if (data[0]['success'] != true) {
                if (data[0]['result'][0]['existecpf'] == 1) {
                    Swal.fire({
                        icon: "warning",
                        title: "Atenção!!",
                        text: "CNPJ já existe"
                    });
                    return
                }
                Swal.fire({
                    icon: "error",
                    title: "Atenção!!",
                    text: "Dados Invalidos"
                });
                return
            } else {
                 $('#nome').val('');
                 $('#cnpj_cpf').val('')
                 $('#email').val(''),
                 $('#telefone').val(''),
                 $('#status').val(''),

                Swal.fire({
                    icon: "success",
                    title: "Sucesso!",
                    text: "Cadastrado com sucesso!"
                });
                return
            }

        }
    })
}

function listar(ret){
    rec = JSON.parse(ret);
    
    
}