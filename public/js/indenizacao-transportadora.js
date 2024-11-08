$(document).ready(function () {
    let idsituacao = 8
    listar(idsituacao);
    contarIndenizacoes()

    $('#cnpj').mask('00.000.000/0000-00', { placeholder: '__.___.___/____-__' });

    $('.card').on('click', function () {
        const idsituacao = $(this).data('idsituacao');
        //console.log('id clicado: ', idsituacao)
        listar(idsituacao);
    });

    $('#anexo').on('change', function () {
        const fileName = $(this).val().split('\\').pop() || "Nenhum arquivo escolhido";
        $('#file-chosen').text(fileName);
    });

});

function contarIndenizacoes() {
    [6, 7, 8, 9].forEach(idsituacao => {
        app.callController({
            method: 'GET',
            url: base + '/getindenizacao-transportadora',
            params: { idsituacao: idsituacao },
            onSuccess(res) {
                const dados = res[0].ret;
                let count = dados.length;
                //console.log(`Dados retornados para idsituacao ${idsituacao}:`, dados);
                atualizarContador(idsituacao, count);
            },
            onFailure() {
                console.error('Erro ao contar solicitações para a situação:', idsituacao);
            }
        });
    });
}

// Função para atualizar o contador no card específico
function atualizarContador(idsituacao, count) {
    switch (idsituacao) {
        case 8:
            $('#pendentesCount').text(`${count} indenizações pendentes`);
            break;
        case 7:
            $('#autorizadasCount').text(`${count} indenizações autorizadas`);
            break;
        case 6:
            $('#contestadasCount').text(`${count} indenizações contestadas`);
            break;
        case 9:
            $('#faturadasCount').text(`${count} indenizações faturadas`);
            break;
    }
}

function listar(idsituacao) {
    app.callController({
        method: 'GET',
        url: base + '/getindenizacao-transportadora',
        params: { idsituacao: idsituacao },
        onSuccess(res) {
            const dados = res[0].ret;
            Table(dados, idsituacao); // Atualiza a tabela com os novos dados
            //console.log(idsituacao, dados)
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

const Table = function (dados, idsituacao) {

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
                title: 'Negocio',
                data: 'nome_negocio',
            },
            {
                title: 'CD',
                data: 'nome_cd'
            },
            {
                title: 'NF',
                data: 'numero_nota',
            },
            {
                title: 'NFD',
                data: 'numero_nota2',
            },
            {
                title: '% Indenização',
                data: 'tipo_indenizacao',
                render: function (data) {
                    // Aplicando máscara no CNPJ
                    const cnpjMascara = data.replace(/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/, "$1.$2.$3/$4-$5");
                    return cnpjMascara;
                }
            },
            {
                title: 'Data Solicitação',
                data: 'data',
            },
            {
                title: 'Situação',
                data: 'descricao_situacao',
                render: function (data, type, row) {
                    let statusClass = '';

                    // Usando switch case para definir a classe de acordo com a situação
                    switch (parseInt(row.idsituacao)) {
                        case 8: statusClass = 'status-pendente'; break;
                        case 6: statusClass = 'status-contestacao'; break;
                        case 7: statusClass = 'status-finalizado'; break;
                        case 9: statusClass = 'status-faturado'; break;
                        default: statusClass = '';
                    }

                    return `<span class="${statusClass}">${data}</span>`;
                }
            },
            {
                title: 'Observação',
                data: null, // Usamos `null` se não há uma propriedade específica para essa coluna no objeto de dados.
                render: function (data, type, row) {
                    dados = JSON.stringify(row).replace(/"/g, '&quot;');
                    return '<button style="width: 100%;" class="btn btn-primary btn-sm" onclick="abrirModalObs(' + dados + ')">Detalhes</button> '
                }
            },
            {
                title: 'Anexo',
                data: null, // Usamos `null` se não há uma propriedade específica para essa coluna no objeto de dados.
                render: function (data, type, row) {
                    dados = JSON.stringify(row).replace(/"/g, '&quot;');
                    return '<button style="width: 100%;" class="btn btn-primary btn-sm" onclick="abrirModalAnexo(' + dados + ')">Anexo</button> '
                }
            },
            {
                title: 'Ações',
                data: null, // Usamos `null` se não há uma propriedade específica para essa coluna no objeto de dados.
                render: function (data, type, row) {
                    dados = JSON.stringify(row).replace(/"/g, '&quot;');
                    if (idsituacao === 8 || idsituacao === 6) {
                        return `
                            <button class="btn btn-success btn-sm" onclick="abrirModalAceitar('${row.idsolicitacao}', 7)">Autorizar</button>
                            <button class="btn btn-warning btn-sm" onclick="abrirModalContestar('${row.idsolicitacao}', 6)">Contestar</button>
                        `;
                    } else {
                        return ''; // Retorna vazio se não houver ações para o estado atual
                    }
                },
                visible: idsituacao === 6 || idsituacao === 8 // <--- Esta linha foi adicionada
            },
        ],
        rowCallback: function (row, data) {
            $(row).addClass('linha' + data.idfilial);
        },
        initComplete: function(settings, json) {
            const column = this.api().column(9);
            column.visible(idsituacao === 6 || idsituacao === 8);
        }
    });

}

function abrirModalObs(dados) {
    $('#conteudo_obs').text(dados.observacao)
    $('#observacaoModal').modal('show');
}
function fechaModalObs() {
    $('#conteudo_obs').text('')
    $('#observacaoModal').modal('hide');
}

// Função para fechar o modal de aceitação/recusa e limpar o campo de observação
function fechaModalAceitar() {
    $('#observacaoAutorizar').val(''); // Limpa o campo de observação ao fechar o modal
    $('#cnpj').val(''); // Limpa o campo de observação ao abrir o modal
    $('#modalAutorizar').modal('hide');
}
function fechaModalContestar() {
    $('#observacaoContestar').val(''); // Limpa o campo de observação ao fechar o modal
    $('#idtipofilial').val(''); // Limpa o campo de observação ao abrir o modal
    $('#modalContestar').modal('hide');
}

function abrirModalAceitar(idsolicitacao, idsituacao) {
    $('#observacaoAutorizar').val(''); // Limpa o campo de observação ao abrir o modal
    $('#cnpj').val(''); // Limpa o campo de observação ao abrir o modal
    $('#modalAutorizar').modal('show');

    if (parseInt(idsituacao) === 7) {
        $('#tituloModalObs').text('Autorizar Solicitação');
    } else{
        $('#tituloModalObs').text('Contestar Solicitação');
    }

    $('#idsolicitacaoAutorizar').val(idsolicitacao);
    $('#idsituacao').val(idsituacao);
}
function abrirModalContestar(idsolicitacao, idsituacao) {
    $('#observacaoContestar').val(''); // Limpa o campo de observação ao abrir o modal
    $('#idtipofilial').val(''); // Limpa o campo de observação ao abrir o modal
    $('#modalContestar').modal('show');

    if (parseInt(idsituacao) === 6) {
        $('#tituloModalObs').text('Autorizar Solicitação');
    } else{
        $('#tituloModalObs').text('Contestar Solicitação');
    }

    $('#idsolicitacaoContestar').val(idsolicitacao);
    $('#idsituacao').val(idsituacao);
}

// Função para confirmar autorização
function confirmarAutorizar() {
    let dados = {
        idsolicitacao: $('#idsolicitacaoAutorizar').val(),
        idsituacao: $('#idsituacao').val(),
        observacao: $('#observacaoAutorizar').val(),
        cnpj: $('#cnpj').val().replace(/[^\d]/g, ''), // Removendo máscara antes de enviar
    };

    //console.log(dados)

    if (!dados.cnpj) {
        Swal.fire({
            icon: "warning",
            title: "Atenção!",
            text: "Por favor, insira o CNPJ."
        });
        $('#cnpj').toggleClass('erro');// Adiciona a classe 'erro' se o CNPJ estiver vazio
        return;
    }
    if (!app.validarCNPJ(dados.cnpj)) {
        Swal.fire({
            icon: "warning",
            title: "Atenção!!",
            text: "CNPJ Inválido!"
        });
        return false;
    }

    app.callController({
        method: 'POST',
        url: base + '/updateindenizacao-transportadora',
        params: dados,
        onSuccess(res) {
            fechaModalAceitar()
            listar(8)
            contarIndenizacoes()
            Swal.fire({
                icon: "success",
                title: "Sucesso!",
                text: "Solicitação autorizada com sucesso!"
            });
        },
        onFailure(res) {
            Swal.fire({
                icon: "error",
                title: "Erro!",
                text: "Falha ao autorizar a solicitação."
            });
        }
    });
}

// Função para confirmar autorização
function confirmarContestar() {
    let dados = {
        idsolicitacao: $('#idsolicitacaoContestar').val(),
        idsituacao: $('#idsituacao').val(),
        observacao: $('#observacaoContestar').val(),
        idtipofilial: $('#idtipofilial').val()
    };

    console.log(dados)

    // if (!dados.idtipofilial) {
    //     Swal.fire({
    //         icon: "warning",
    //         title: "Atenção!",
    //         text: "Por favor, insira o Negocio."
    //     });
    //     $('#idtipofilial').toggleClass('erro');
    //     return;
    // }
    // if(dados.observacao){
    //     Swal.fire({
    //         icon: "warning",
    //         title: "Atenção!",
    //         text: "Por favor, insira o Motivo da contestação."
    //     });
    //     $('#observacaoContestar').toggleClass('erro');
    //     return;
    // }

    app.callController({
        method: 'POST',
        url: base + '/updateindenizacao-transportadora',
        params: dados,
        onSuccess(res) {
            fechaModalContestar()
            listar(8)
            contarIndenizacoes()
            Swal.fire({
                icon: "success",
                title: "Sucesso!",
                text: "Solicitação contestada com sucesso!"
            });
        },
        onFailure(res) {
            Swal.fire({
                icon: "error",
                title: "Erro!",
                text: "Falha ao autorizar a solicitação."
            });
        }
    });
}

