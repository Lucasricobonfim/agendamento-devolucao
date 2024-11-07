$(document).ready(function () {
    //let idsituacao = 7
    listar();
    // contarIndenizacoes()

    // $('.card').on('click', function () {
    //     const idsituacao = $(this).data('idsituacao');
    //     //console.log('id clicado: ', idsituacao)
    //     listar(idsituacao);
    // });

    $('#anexo').on('change', function () {
        const fileName = $(this).val().split('\\').pop() || "Nenhum arquivo escolhido";
        $('#file-chosen').text(fileName);
    });
});

// function contarIndenizacoes() {
//     [6, 7, 8].forEach(idsituacao => {
//         app.callController({
//             method: 'GET',
//             url: base + '/getindenizacao-transportadora',
//             params: { idsituacao: idsituacao },
//             onSuccess(res) {
//                 const dados = res[0].ret;
//                 let count = dados.length;
//                 //console.log(`Dados retornados para idsituacao ${idsituacao}:`, dados);
//                 atualizarContador(idsituacao, count);
//             },
//             onFailure() {
//                 console.error('Erro ao contar solicitações para a situação:', idsituacao);
//             }
//         });
//     });
// }

// Função para atualizar o contador no card específico
// function atualizarContador(idsituacao, count) {
//     switch (idsituacao) {
//         case 8:
//             $('#pendentesCount').text(`${count} indenizações pendentes`);
//             break;
//         case 7:
//             $('#autorizadasCount').text(`${count} indenizações autorizadas`);
//             break;
//         case 6:
//             $('#contestadasCount').text(`${count} indenizações contestadas`);
//             break;
//     }
// }

function listar() {
    app.callController({
        method: 'GET',
        url: base + '/getindenizacao-financeiro',
        params: null,
        onSuccess(res) {
            Table(res[0].ret);
        },
        onFailure(res) {
            Swal.fire({
                icon: "error",
                title: "Atenção!!",
                text: "Erro ao listar Centro de distribuição!"
            });
        }
    });
}

const Table = function (res) {
    var dados = res
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
                title: 'Transportadora',
                data: 'nome_transportadora'
            },
            {
                title: 'CNPJ',
                data: 'cnpj',
                render: function (data) {
                    if (!data) {
                        return "CNPJ não disponível"; // Valor padrão se data for undefined ou null
                    }
                    // Aplicando máscara no CNPJ
                    const cnpjMascara = data.replace(/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})$/, "$1.$2.$3/$4-$5");
                    return cnpjMascara;
                }
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
                    return `
                            <button class="btn btn-success btn-sm" onclick="abrirModalFaturar('${row.idsolicitacao}', 9)">Faturado</button>
                        `;

                },
                //visible: idsituacao === 6 || idsituacao === 8 // <--- Esta linha foi adicionada
            },
        ],
        rowCallback: function (row, data) {
            $(row).addClass('linha' + data.idfilial);
        },
        // initComplete: function(settings, json) {
        //     const column = this.api().column(9);
        //     column.visible(idsituacao === 6 || idsituacao === 8);
        // }
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
function abrirModalFaturar(idsolicitacao, idsituacao) {
    $('#observacaoFaturar').text('')
    $('#modalFaturar').modal('show'); // Exibe o modal

    $('#idsolicitacaoFaturar').val(idsolicitacao); // Define o valor do ID da solicitação
    $('#idsituacao').val(idsituacao); // Define o valor da situação
    
}
function fechaModalFaturar(){
    $('#observacaoFaturar').val('')
    $('#modalFaturar').modal('hide'); // Exibe o modal
}
function  confimarFaturar(){
    let dados = {
        observacao: $('#observacaoFaturar').val(),
        idsolicitacao: $('#idsolicitacaoFaturar').val(),
        idsituacao: $('#idsituacao').val()
    }

    console.log(dados)
    
    if(!dados.observacao){
        Swal.fire({
            icon: "warning",
            title: "Atenção!!",
            text: "Preencha o campo observação."
        })
        $('#observacaoFaturar').toggleClass('erro');
        return
    }

    app.callController({
        method: 'POST',
        url: base + '/updateindenizacao-financeiro',
        params: dados, 
        onSuccess(res){
            fechaModalFaturar()
            listar()
            Swal.fire({
                icon: "success",
                title: "Sucesso!",
                text: "Solicitação faturada com sucesso!"
            });
        },
        onFailure(res){
            Swal.fire({
                icon: "error",
                title: "Atenção!!",
                text: "Erro ao faturar!"
            });
        }

    })

}


