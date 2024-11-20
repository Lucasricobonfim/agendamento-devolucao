$(document).ready(function () {


    $('#enviar').on('click', function () {

        console.log('sasa')
        let dados = {
            email: $('#email').val()
        }

        console.log(dados)

        $.ajax({
            url: base + '/enviarcod',
            data: { email: dados.email },
            autoAbort: false,
            //disableCaching : true,
            disableCaching: false,
            timeout: 180000000,
            type: 'post',
            success: function (a, b, c) {
                var tmp = JSON.parse(a);

                if (tmp[0].ret == '') {
                    Swal.fire({
                        icon: "warning",
                        title: "E-mail Inválido!",
                    })
                    return
                }
                Swal.fire({
                    icon: "success",
                    title: "Email enviado com sucesso!",
                })

            },
            error: function (a) {
                Swal.fire({
                    icon: "error",
                    title: "Erro ao Enviar E-mail",
                })
            }
        });
    })




    $('#btnalterarsenha').on('click', function () {
        let dados = {
            novasenha: $('#novaSenha').val(),
            confirmaSenha: $('#confirmarSenha').val()
        }


        if (dados.novasenha != dados.confirmaSenha) {
            alert('Senha não condiz')
            return
        }

        if (!validarSenha(dados.novasenha)) {
            return; // Se alguma validação falhar, não prossegue
        }

        $.ajax({
            url: base + '/cadastrar-novasenha',
            data: { senha: dados.novasenha },
            autoAbort: false,
            //disableCaching : true,
            disableCaching: false,
            timeout: 180000000,
            type: 'post',
            success: function (a, b, c) {
            ;
            Swal.fire({
                icon: "success",
                title: "Senha alterada com sucesso!",
            }).then(function() {
                // Aguarda o fechamento da mensagem antes de redirecionar
                window.location.href = base + '/deslogar';
            });
            },
            error: function (a) {
                console.log('A: ', a)
            }
        });

    })

})




function validarSenha(senha) {
    let mensagens = [];

    // Verifica se a senha tem pelo menos 6 caracteres
    if (senha.length < 8) {
        mensagens.push("A senha deve ter pelo menos 8 caracteres.");
    }

    // Verifica se a senha contém pelo menos uma letra maiúscula
    if (!/[A-Z]/.test(senha)) {
        mensagens.push("A senha deve conter pelo menos uma letra maiúscula.");
    }

    // Verifica se a senha contém pelo menos um caractere especial
    if (!/[!@#$%^&*(),.?":{}|<>]/.test(senha)) {
        mensagens.push("A senha deve conter pelo menos um caractere especial.");
    }

    // Se houver mensagens, exibe um alerta
    if (mensagens.length > 0) {
        Swal.fire({
            icon: "warning",
            title: "Atenção!!",
            text: mensagens.join(" ") // Junta as mensagens em uma única string
        });
        return false;
    }

    return true;
}