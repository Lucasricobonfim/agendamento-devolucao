$(document).ready(function () {
    listar();

    $('#cnpj').mask('00.000.000/0000-00', { placeholder: '__.___.___/____-__' });

});

$('#anexo').on('change', function () {
    const fileName = $(this).val().split('\\').pop() || "Nenhum arquivo escolhido";
    $('#file-chosen').text(fileName);
});


function listar() {
    app.callController({
        method: 'GET',
        url: base + '/getindenizacao-transportadora',
        params: null,
        onSuccess(res) {
            console.log(res)
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

const Table = function (ret) {
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
                title: 'Negocio',
                data: 'nome_negocio',
            },
            {
                title: 'Centro de Distribuição',
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
                title: 'Tipo Indenização',
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
                        case 1: statusClass = 'status-pendente'; break;
                        case 6: statusClass = 'status-contestacao'; break;
                        case 7: statusClass = 'status-finalizado'; break;
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
                    return `
                        <button class="btn btn-success btn-sm" onclick="abrirModalAceitar('${row.idsolicitacao}', 7)">Autorizar</button>
                        <button class="btn btn-warning btn-sm" onclick="abrirModalContestar('${row.idsolicitacao}', 6)">Contestar</button>
                    `;
                }
            },
        ],
        rowCallback: function (row, data) {
            $(row).addClass('linha' + data.idfilial);
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
    $('#idtipofilial').val('')
    $('#observacaoContestar').val(''); 
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
        observacao: $('#observacaoContestar').val(),
        cnpj: $('#cnpj').val()
    };

    console.log(dados)

    if (!dados.cnpj) {
        Swal.fire({
            icon: "warning",
            title: "Atenção!",
            text: "Por favor, insira o CNPJ."
        });
        $('#cnpj').toggleClass('erro');
        return;
    }

    app.callController({
        method: 'POST',
        url: base + '/updateindenizacao-transportadora',
        params: dados,
        onSuccess(res) {
            fechaModalAceitar()
            listar()
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
        idtipofilial: $('#idtipofilial'),
        idsolicitacao: $('#idsolicitacaoContestar').val(),
        idsituacao: $('#idsituacao').val(),
        observacao: $('#observacaoAutorizar').val(),
    };

    console.log(dados)

    if (dados.idtipofilial) {
        Swal.fire({
            icon: "warning",
            title: "Atenção!",
            text: "Por favor, insira o Negocio."
        });
        $('#idtipofilial').toggleClass('erro');
        return;
    }

    app.callController({
        method: 'POST',
        url: base + '/updateindenizacao-transportadora',
        params: dados,
        onSuccess(res) {
            fechaModalAceitar()
            listar()
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

