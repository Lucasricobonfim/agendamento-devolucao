$(document).ready(function () {
    listar();

    // Máscara para telefone e CNPJ aplicadas corretamente
    $('#telefone').mask('(00) 00000-0000', { placeholder: '(  ) _____-____' });
    $('#cnpj_cpf').mask('00.000.000/0000-00', { placeholder: '__.___.___/____-__' });

    $('#cadastro').on('click', function () {
        var idfilial = $('#idfilial').val();
        let dados = {
            nome: $('#nome').val(),
            cnpj_cpf: $('#cnpj_cpf').val().replace(/[^\d]/g, ''), // Removendo máscara antes de enviar
            email: $('#email').val(),
            telefone: $('#telefone').val().replace(/[^\d]/g, '') // Removendo máscara antes de enviar
        };

        if (idfilial) {
            dados.idfilial = idfilial;

            if (!app.validarCampos(dados)) {
                Swal.fire({
                    icon: "warning",
                    title: "Atenção!!",
                    text: "Preencha todos os campos!"
                });
                return;
            }
            if (!validarNome(dados.nome)) {
                return; 
            }
            if (!app.validarCNPJ(dados.cnpj_cpf)) {
                Swal.fire({
                    icon: "warning",
                    title: "Atenção!!",
                    text: "CNPJ Inválido!"
                });
                return false;
            }
            if (!validarEmail(dados.email)) {
                Swal.fire({
                    icon: "warning",
                    title: "Atenção!!",
                    text: "E-mail inválido! Por favor, insira um e-mail válido."
                });
                return;
            }
            if (!validarTelefone(dados.telefone)) {
                return false;
            }

            editar(dados);

        } else {
            if (!app.validarCampos(dados)) {
                Swal.fire({
                    icon: "warning",
                    title: "Atenção!!",
                    text: "Preencha todos os campos!"
                });
                return;
            }
            if (!validarNome(dados.nome)) {
                return; 
            }
            if (!app.validarCNPJ(dados.cnpj_cpf)) {
                Swal.fire({
                    icon: "warning",
                    title: "Atenção!!",
                    text: "CNPJ Inválido!"
                });
                return false;
            }
            if (!validarEmail(dados.email)) {
                Swal.fire({
                    icon: "warning",
                    title: "Atenção!!",
                    text: "E-mail inválido! Por favor, insira um e-mail válido."
                });
                return;
            }
            if (!validarTelefone(dados.telefone)) {
                return false;
            }

            cadastro(dados);
        }
    });

    $('#nome').on('input', function () {
        $(this).removeClass('erro');
    });

    $('#cnpj_cpf').on('input', function () {
        $(this).removeClass('erro');
    });

    $('#email').on('input', function () {
        $(this).removeClass('erro');
    });

    $('#telefone').on('input', function () {
        $(this).removeClass('erro');
    });
});
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
// Função para validar e-mail
function validarEmail(email) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}
function validarTelefone(telefone) {
    // Remove a máscara
    const telefoneSemMascara = telefone.replace(/\D/g, ''); // Remove tudo que não é número

    // Verifica se o telefone tem exatamente 11 dígitos (para celular) ou 10 (para fixo)
    if (telefoneSemMascara.length !== 11 && telefoneSemMascara.length !== 10) {
        Swal.fire({
            icon: "warning",
            title: "Atenção!!",
            text: "Número de telefone inválido! Por favor, insira um número válido."
        });
        return false;
    }
    return true;
}

function listar() {
    app.callController({
        method: 'GET',
        url: base + '/getcentro-distribuicao',
        params: null,
        onSuccess(res) {
            Table(res[0].ret)
        },
        onFailure(res) {
            Swal.fire({
                icon: "error",
                title: "Atenção!!",
                text: "Erro ao listar Centro de distribuição!"
            });
            return;
        }
    });
}

function limparForm(){
    $('#form-title').text('Cadastrando CD').css('color', 'blue');;

    $('#nome').val('');
    $('#cnpj_cpf').val('');
    $('#email').val('');
    $('#telefone').val('');
    $('#idfilial').val('');
    //Para remover erro do preenchimento
    $('#nome').removeClass('erro'); // Remove a classe 'erro'
    $('#cnpj_cpf').removeClass('erro'); // Remove a classe 'erro'
    $('#email').removeClass('erro'); // Remove a classe 'erro'
    $('#telefone').removeClass('erro'); // Remove a classe 'erro'
}

function cadastro(dados) {  
    app.callController({
        method: 'POST',
        url: base + '/cadcentro-distribuicao',
        params: dados,
        onSuccess(res) {         
           limparForm()
            listar(); // Atualiza a lista após o cadastro
            Swal.fire({
                icon: "success",
                title: "Sucesso!",
                text: "Cadastrado com sucesso!"
            });
        },
        onFailure(res) {
            if (res[0]['ret']['result'][0]['existecpf'] == 1) {
                Swal.fire({
                    icon: "warning",
                    title: "Atenção!!",
                    text: "CNPJ já existe"
                });
                return;
            }
            Swal.fire({
                icon: "error",
                title: "Atenção!!",
                text: "Erro ao cadastrar Centro de distribuição"
            });
            return;
        }
    });
}

const Table = function(ret){
    var dados = ret
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
        data: dados, //dados,
        columns: [
            {
                title: 'Nome',
                data: 'nome',
                render: function(data) {
                    return `<strong>${data}</strong>`; // Coloca o nome em negrito
                }
            },
            {
                title: 'CNPJ',
                data: 'cnpj_cpf',
                render: function(data) {
                    // Aplicando máscara no CNPJ
                    const cnpjMascara = data.replace(/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/, "$1.$2.$3/$4-$5");
                    return cnpjMascara;
                }
            },
            {
                title: 'E-mail',
                data: 'email'
            },
            {
                title: 'Telefone',
                data: 'telefone',
                render: function(data) {
                    if (data.length === 10) {
                        // Telefone fixo sem o nono dígito
                        return data.replace(/^(\d{2})(\d{4})(\d{4})$/, "($1) $2-$3");
                    } else if (data.length === 11) {
                        // Telefone celular com o nono dígito
                        return data.replace(/^(\d{2})(\d{5})(\d{4})$/, "($1) $2-$3");
                    } else if (data.length === 8) {
                        // Telefone fixo local sem DDD
                        return data.replace(/^(\d{4})(\d{4})$/, "$1-$2");
                    } else {
                        // Retorna o número sem máscara se não corresponder a nenhum formato conhecido
                        return data;
                    }
                }
            },
            {
                title: 'Status',
                data: 'descricao',
                render: function(data) {
                    // Adicione uma classe de status com base no valor
                    const statusClass = data === 'Ativo' ? 'status-ativo' : 'status-inativo';
                    return `<span class="${statusClass}">${data}</span>`;
                }
            },
            {
                title: 'Ações',
                data: null, // Usamos `null` se não há uma propriedade específica para essa coluna no objeto de dados.
                render: function(data, type, row) {
                    dados = JSON.stringify(row).replace(/"/g, '&quot;');
                    
                    return '<div class="dropdown" style="display: inline-block; cursor: pointer;">' +
                                '<a class="text-secondary" id="actionsDropdown' + row.idfilial + '" data-bs-toggle="dropdown" aria-expanded="false" style="text-decoration: none; cursor: pointer;">' +
                                    '<i class="fas fa-ellipsis-h"></i>' + // Ícone horizontal de 3 pontos
                                '</a>' +
                                '<ul class="dropdown-menu" aria-labelledby="actionsDropdown' + row.idfilial + '">' +
                                    '<li><a class="dropdown-item text-primary" onclick="setEditar(' + dados + ')">Editar</a></li>' + // Azul para "Editar"
                                    '<li><a class="dropdown-item text-danger" onclick="confirmUpdateSituacao(' + row.idfilial + ', 2, ' + row.idsituacao + ', \'Inativar\')">Inativar</a></li>' + // Vermelho para "Inativar"
                                    '<li><a class="dropdown-item text-success" onclick="confirmUpdateSituacao(' + row.idfilial + ', 1, ' + row.idsituacao + ', \'Ativar\')">Ativar</a></li>' + // Verde para "Ativar"
                                '</ul>' +
                            '</div>';
                }
            }
        ],
        rowCallback: function(row, data) {
            $(row).addClass('linha' + data.idfilial);
        }
    });

}

function confirmUpdateSituacao(id, idsituacao, atualsituacao, acao) {
    var situacaoAtual = atualsituacao == 2 ? 'inativo' : 'ativo';
    // Verifica se o centro de distribuição já está na situação desejada
    if (idsituacao == atualsituacao) {
        Swal.fire({
            icon: "warning",
            title: "Atenção!",
            text: "Centro de distribuição já está " + situacaoAtual
        });
        return; // Não continua com a confirmação
    }

    var mensagem = "Você tem certeza que deseja " + acao.toLowerCase() + " o centro de distribuição?";
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



function updateSituacao(id, idsituacao, atualsituacao){
   
    var situacao = atualsituacao == 2 ? 'inativo' : 'ativo'
    if(idsituacao == atualsituacao){
        Swal.fire({
            icon: "warning",
            title: "Atenção!",
            text: "Centro de distribuição já está " +  situacao
        });
        return
    }
    app.callController({
        method: 'GET',
        url: base + '/updatesituacaocentro-distribuicao',
        params: {
            id: id,
            idsituacao: idsituacao
        },
        onSuccess(res){
            listar(); 
            // Terceiro alerta de sucesso
            var novaSituacao = idsituacao == 2 ? 'inativado' : 'ativado';
            Swal.fire({
                icon: "success",
                title: "Sucesso!",
                text: "Centro de distribuição " + novaSituacao + " com sucesso."
            });  
        },
        onFailure(res){
            Swal.fire({
                icon: "error",
                title: "Atenção!!",
                text: "Erro ao atualizar situação do Centro de distribuição!"
            });
            return
        }
    })
}

function setEditar(row) {
    $('#form-title').text('Editando CD').css('color', 'blue');
    $('#idfilial').val(row.idfilial);
    $('#nome').val(row.nome);

    // Remover máscaras antes de setar novos valores
    $('#cnpj_cpf').unmask();
    $('#telefone').unmask();
    
    // Setando o valor no campo CNPJ e Telefone
    $('#cnpj_cpf').val(row.cnpj_cpf);
    $('#email').val(row.email);
    $('#telefone').val(row.telefone);

    // Reaplicar as máscaras após os valores serem inseridos
    $('#telefone').mask('(00) 00000-0000'); 
    $('#cnpj_cpf').mask('00.000.000/0000-00');
    
    // Rolagem suave para o formulário
    $('html, body').animate({
        scrollTop: $(".form-container").offset().top
    }, 100); 
}
    function editar(dados){
        app.callController({
            method: 'GET',
            url: base + '/editarcentro-distribuicao',
            params: {
               nome: dados.nome,
               cnpj_cpf: dados.cnpj_cpf,
               email: dados.email,
               telefone: dados.telefone,
               idfilial: dados.idfilial
            },
            onSuccess(res){
                listar(); // Atualiza a lista após o cadastro
                // Limpar os campos do formulário
                limparForm()
                // Mostrar alerta de sucesso
                Swal.fire({
                    icon: "success",
                    title: "Sucesso!",
                    text: "Editado com sucesso!"
                });
            },
            onFailure(res){
                 
                Swal.fire({
                    icon: "error",
                    title: "Atenção!!",
                    text: "Erro ao editar Centro de distribuição!"
                });
                return
               
            }
        })
    }

