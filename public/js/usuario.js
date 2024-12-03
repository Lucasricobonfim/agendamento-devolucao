$(document).ready(function () {
    listar()
    // Table()
    // listar(ret);
    // $('#cadastro').on('click', function () {
    //     var idusuario = $('#idusuario').val()
    //     var senha = $('#senha').val()

    //     if (idusuario) {
    //         let dados = {
    //             nome: $('#nome').val(),
    //             login: $('#login').val(),
    //             idfilial: $('#idfilial').val(),
    //             idgrupo: $('#idgrupo').val()
    //         }
    //         if (!app.validarCampos(dados)) {
    //             Swal.fire({
    //                 icon: "warning",
    //                 title: "Atenção!!",
    //                 text: "Preencha todos os campos!"
    //             });
    //             return
    //         }
    //         dados.idusuario = idusuario
    //         dados.senha = senha


    //         if (!validarNome(dados.nome)) {
    //             return; // Se alguma validação falhar, não prossegue
    //         }
    //         if (!validarSenha(dados.senha)) {
    //             return; // Se alguma validação falhar, não prossegue
    //         }
    //         if (!validarLogin(dados.login)) {
    //             return; // Se alguma validação falhar, não prossegue
    //         }
    //         editar(dados)
    //     } else {
    //         let dados = {
    //             nome: $('#nome').val(),
    //             login: $('#login').val(),
    //             senha: senha,
    //             idfilial: $('#idfilial').val(),
    //             idgrupo: $('#idgrupo').val()
    //         }
    //         if (!app.validarCampos(dados)) {
    //             Swal.fire({
    //                 icon: "warning",
    //                 title: "Atenção!!",
    //                 text: "Preencha todos os campos!"
    //             });
    //             return
    //         }

    //         if(verificaLogin(dados.login)){
    //             console.log('aki')
    //             return;
    //         }
    //         if (!validarNome(dados.nome)) {
    //             return; // Se alguma validação falhar, não prossegue
    //         }
    //         if (!validarSenha(dados.senha)) {
    //             return; // Se alguma validação falhar, não prossegue
    //         }
    //         if (!validarLogin(dados.login)) {

    //             return; // Se alguma validação falhar, não prossegue
    //         }


    //         cadastro(dados)
    //     }

    // })

    $('#cadastro').on('click', async function () {
        const idusuario = $('#idusuario').val();
        const senha = $('#senha').val();


        if (idusuario) {
            let dados = {
                nome: $('#nome').val(),
                login: $('#login').val(),
                // senha: senha,
                idfilial: $('#idfilial').val(),
                idgrupo: $('#idgrupo').val()
            };

            if (!app.validarCampos(dados)) {
                Swal.fire({
                    icon: "warning",
                    title: "Atenção!!",
                    text: "Preencha todos os campos!"
                });
                return;
            }


            if (!validarNome(dados.nome)) return;
            if (senha != '') {
                if (!validarSenha(senha)) return;
            }
            if (!validarLogin(dados.login)) return;
            dados.senha = senha
            dados.idusuario = idusuario;
            editar(dados);
        } else {

            let dados = {
                nome: $('#nome').val(),
                login: $('#login').val(),
                senha: senha,
                idfilial: $('#idfilial').val(),
                idgrupo: $('#idgrupo').val()
            };

            if (!app.validarCampos(dados)) {
                Swal.fire({
                    icon: "warning",
                    title: "Atenção!!",
                    text: "Preencha todos os campos!"
                });
                return;
            }

            if (!validarNome(dados.nome)) return;

            if (!validarSenha(dados.senha)) return;

            if (!validarLogin(dados.login)) return;


            const loginDisponivel = await verificaLogin(dados.login);
            if (!loginDisponivel) return; // Se o login já existe, interrompe o fluxo
            cadastro(dados);
        }

    });


    $('#idgrupo').change(function () {
        var idgrupo = $(this).val();

        buscaFilial(idgrupo)
    });

    $('#nome').on('input', function () {
        $(this).removeClass('erro');
    });

    $('#login').on('input', function () {
        $(this).removeClass('erro');
    });

    $('#senha').on('input', function () {
        $(this).removeClass('erro');
    });

    $('#idgrupo').on('input', function () {
        $(this).removeClass('erro');
    });

    $('#idfilial').on('input', function () {
        $(this).removeClass('erro');
    });

})

function validarLogin(login) {
    let mensagens = [];


    // Verifica se o comprimento está entre 3 e 20 caracteres
    if (login.length < 3 || login.length > 20) {
        mensagens.push("O login deve ter entre 3 e 20 caracteres.");
    }

    // Verifica se o login começa com uma letra
    if (!/^[a-zA-Z]/.test(login)) {
        mensagens.push("O login deve começar com uma letra.");
    }

    // Verifica se o login contém apenas caracteres permitidos
    if (!/^[a-zA-Z0-9_.]+$/.test(login)) {
        mensagens.push("O login deve conter apenas letras, números, ponto ou sublinhado.");
    }

    // Verifica se o login contém espaços
    if (/\s/.test(login)) {
        mensagens.push("O login não pode conter espaços.");
    }

    // Se houver mensagens, exibe um alerta
    if (mensagens.length > 0) {
        Swal.fire({
            icon: "warning",
            title: "Atenção!!",
            text: mensagens.join(" ")
        });
        return false;
    }

    return true;

}

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

function validarNome(nome) {
    // Verifica se o nome contém apenas letras e espaços
    const nomeRegex = /^[A-Za-zÀ-ÿ\s]+$/;

    // Verifica se o nome é válido e se respeita o limite de caracteres
    if (!nomeRegex.test(nome) || nome.length > 25) {
        if (nome.length > 25) {
            Swal.fire({
                icon: "warning",
                title: "Atenção!!",
                text: `O nome deve ter no máximo ${25} caracteres.`
            });
        } else {
            Swal.fire({
                icon: "warning",
                title: "Atenção!!",
                text: "O nome pode conter apenas letras e espaços."
            });
        }
        return false;
    }
    return true;
}

function mostrarSenha() {
    let inputSenha = $('#senha')
    if (inputSenha.attr('type') === 'password') {
        inputSenha.attr('type', 'text');
    } else {
        inputSenha.attr('type', 'password');
    }
}

function limparForm() {
    $('#form-title').text('Cadastrando Usuários').css('color', 'blue');;
    $('#nome').val('');
    $('#idfilial').val('');
    $('#idgrupo').val('');
    $('#login').val('');
    $('#senha').val('');
    $('#idusuario').val('');

    //Para remover erro do preenchimento
    $('#nome').removeClass('erro'); // Remove a classe 'erro'
    $('#login').removeClass('erro'); // Remove a classe 'erro'
    $('#senha').removeClass('erro'); // Remove a classe 'erro'
    $('#idgrupo').removeClass('erro'); // Remove a classe 'erro'
    $('#idfilial').removeClass('erro'); // Remove a classe 'erro'
}

function listar() {
    app.callController({
        method: 'GET',
        url: base + '/getusuarios',
        params: null,
        onSuccess(res) {
            Table(res[0].ret)
        },
        onFailure(res) {
            Swal.fire({
                icon: "error",
                title: "Atenção!!",
                text: "Erro ao listar Usuarios!"
            });
            return
        }
    })
}

function buscaFilial(idgrupo) {
    app.callController({
        method: 'GET',
        url: base + '/getfilialporgrupo',
        params: {
            idgrupo: idgrupo
        },
        onSuccess(res) {
            var rec = res[0].ret
            opp = $('.opp');
            opp.html('');
            if (rec != '') {
                $.each(rec, function (i, el) {
                    opp.append("<option id='filial' value='" + el.idfilial + "' >" + el.descricao + "</option>")
                })
            }
        },
        onFailure(res) {
            Swal.fire({
                icon: "error",
                title: "Atenção!!",
                text: "Erro ao buscar Filial por Grupo!"
            });
            return
        }
    })
}

function cadastro(dados) {
    app.callController({
        method: 'POST',
        url: base + '/cadusuario',
        params: dados,
        onSuccess(res) {
            listar()
            limparForm()
            Swal.fire({
                icon: "success",
                title: "Sucesso!",
                text: "Cadastrado com sucesso!"
            });
        },
        onFailure(res) {
            Swal.fire({
                icon: "error",
                title: "Atenção!!",
                text: "Erro ao cadastrar Usuario!"
            });
            return
        }
    })
}



const Table = function (dados) {

    //var dados = JSON.parse(ret)
    $('#mytable').DataTable({
        dom: 'Bfrtip',
        responsive: true,
        stateSave: true,
        "bDestroy": true,
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.10.25/i18n/Portuguese-Brasil.json"
        },
        buttons: [
            /*
            {
                extend: 'copyHtml5',
                className: 'btn btn-primary'
            },
            {
                extend: 'excelHtml5',
                className: 'btn btn-primary'
            },
            {
                extend: 'csvHtml5',
                className: 'btn btn-primary'
            },
            {
                extend: 'pdfHtml5',
                className: 'btn btn-primary'
            },
            {
                extend: 'print',
                className: 'btn btn-primary'
            },
            {
                extend: 'colvis',
                className: 'btn btn-primary'
            }
            */
        ],
        lengthMenu: [
            [10, 100, 500, -1],
            [10, 100, 500, "All"]
        ],
        data: dados,
        columns: [
            {
                title: 'Nome',
                data: 'nome',
                render: function (data) {
                    return `<strong>${data}</strong>`; // Coloca o nome em negrito
                }
            },
            {
                title: 'Login',
                data: 'login'
            },
            {
                title: 'Filial',
                data: 'filial'
            },
            {
                title: 'Grupo',
                data: 'grupo',
            },
            {
                title: 'Situação',
                data: 'descricao',
                render: function (data) {
                    // Adicione uma classe de status com base no valor
                    const statusClass = data === 'Ativo' ? 'status-ativo' : 'status-inativo';
                    return `<span class="${statusClass}">${data}</span>`;
                }
            },
            {
                title: 'Ações',
                data: null, // Usamos `null` se não há uma propriedade específica para essa coluna no objeto de dados.
                render: function (data, type, row) {
                    dados = JSON.stringify(row).replace(/"/g, '&quot;');

                    return '<div class="dropdown" style="display: inline-block; cursor: pointer;">' +
                        '<a class="text-secondary" id="actionsDropdown' + row.idusuario + '" data-bs-toggle="dropdown" aria-expanded="false" style="text-decoration: none; cursor: pointer;">' +
                        '<i class="fas fa-ellipsis-h"></i>' + // Ícone horizontal de 3 pontos
                        '</a>' +
                        '<ul class="dropdown-menu" aria-labelledby="actionsDropdown' + row.idusuario + '">' +
                        '<li><a class="dropdown-item text-primary" onclick="setEditar(' + dados + ')">Editar</a></li>' + // Azul para "Editar"
                        '<li><a class="dropdown-item text-danger" onclick="confirmUpdateSituacao(' + row.idusuario + ', 2, ' + row.idsituacao + ', \'Inativar\')">Inativar</a></li>' + // Vermelho para "Inativar"
                        '<li><a class="dropdown-item text-success" onclick="confirmUpdateSituacao(' + row.idusuario + ', 1, ' + row.idsituacao + ', \'Ativar\')">Ativar</a></li>' + // Verde para "Ativar"
                        '</ul>' +
                        '</div>';
                }
            }
        ],
        rowCallback: function (row, data) {
            $(row).addClass('linha' + data.idfilial);
        }
    });

}

function confirmUpdateSituacao(id, idsituacao, atualsituacao, acao) {
    var situacaoAtual = atualsituacao == 2 ? 'Inativo' : 'Ativo';
    // Verifica se o centro de distribuição já está na situação desejada
    if (idsituacao == atualsituacao) {
        Swal.fire({
            icon: "warning",
            title: "Atenção!",
            text: "Usuario já está " + situacaoAtual
        });
        return; // Não continua com a confirmação
    }

    var mensagem = "Você tem certeza que deseja " + acao.toLowerCase() + " o usuario?";
    Swal.fire({
        title: 'Confirmação',
        text: mensagem,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sim',
        cancelButtonText: 'Não',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Se o usuário confirmar, a função de update é chamada
            updateSituacao(id, idsituacao, atualsituacao);
        } else {
            Swal.fire('Ação cancelada', '', 'info');
        }
    });
}

function updateSituacao(id, idsituacao, atualsituacao) {
    app.callController({
        method: 'GET',
        url: base + '/updatesituacaousuario',
        params: {
            id: id,
            idsituacao: idsituacao
        },
        onSuccess(res) {
            listar();
            // Terceiro alerta de sucesso
            var novaSituacao = idsituacao == 2 ? 'inativado' : 'ativado';
            Swal.fire({
                icon: "success",
                title: "Sucesso!",
                text: "Usuario " + novaSituacao + " com sucesso."
            });
        },
        onFailure(res) {
            Swal.fire({
                icon: "error",
                title: "Atenção!!",
                text: "Erro ao atualizar situação do Usuario!"
            });
            return
        }
    })
}

function setEditar(row) {

    $('#form-title').text('Editando Usuário').css('color', 'blue');;
    buscaFilial(row.idgrupo)


    $('#idgrupo').val(row.idgrupo)

    setTimeout(() => {
        $('#idfilial').val(row.idfilial)
    }, 300);
    $('#idusuario').val(row.idusuario),
        $('#nome').val(row.nome),
        $('#login').val(row.login),

        // formatarCNPJ()

        $('html, body').animate({
            scrollTop: $(".form-container").offset().top
        }, 100);

}

function editar(dados) {
    // Chama o controller para editar os dados
    app.callController({
        method: 'GET',
        url: base + '/editarusuario',
        params: {
            nome: dados.nome,
            idfilial: dados.idfilial,
            idgrupo: dados.idgrupo,
            login: dados.login,
            senha: dados.senha,
            idusuario: dados.idusuario
        },
        onSuccess(res) {
            listar(); // Atualiza a lista após a edição
            limparForm();
            $('#status-message').hide();
            Swal.fire({
                icon: "success",
                title: "Sucesso!",
                text: "Editado com sucesso!"
            });
        },
        onFailure(res) {
            Swal.fire({
                icon: "error",
                title: "Atenção!!",
                text: "Erro ao editar Usuário!"
            });
            return;
        }
    });
}



function verificaLogin(login) {
    return new Promise((resolve, reject) => {
        app.callController({
            method: 'GET',
            url: base + '/verifica/existe/login',
            params: { login: login },
            onSuccess(res) {
                let dados = res[0].ret;
                if (dados.length > 0) {
                    Swal.fire({
                        icon: "warning",
                        title: "Atenção!!",
                        text: "Erro ao cadastrar esse login! Esse login já está em uso."
                    });
                    resolve(false); // Login já existe
                } else {
                    resolve(true); // Login disponível
                }
            },
            onFailure() {
                Swal.fire({
                    icon: "error",
                    title: "Erro!",
                    text: "Erro ao verificar se o login existe. Tente novamente mais tarde."
                });
                reject(false); // Erro na verificação
            }
        });
    });
}
