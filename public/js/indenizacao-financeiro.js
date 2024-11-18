$(document).ready(function () {
    let idsituacao = 7
    listar(idsituacao);
    contarIndenizacoes()

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
    [7, 9].forEach(idsituacao => {
        app.callController({
            method: 'GET',
            url: base + '/getindenizacao-financeiro',
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
        case 9:
            $('#faturadasCount').text(`${count} indenizações faturadas`);
            break;
        case 7:
            $('#autorizadasCount').text(`${count} indenizações autorizadas`);
            break;
    }
}

function listar(idsituacao) {
    app.callController({
        method: 'GET',
        url: base + '/getindenizacao-financeiro',
        params: {idsituacao: idsituacao},
        onSuccess(res) {
            const dados = res[0].ret;
            Table(dados, idsituacao);
            console.log(idsituacao, dados, res)
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
            {
                extend: 'copyHtml5',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8] // Exporta somente as colunas escolhidas para planilha 
                }
            },
            {
                extend: 'excelHtml5',
                title: 'Indenizacações',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
                }
            },
            {
                extend: 'csvHtml5',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
                }
            },
            {
                extend: 'pdfHtml5',
                orientation: 'landscape', 
                pageSize: 'A3', 
                title: 'INDENIZAÇÕES',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8]
                },
                customize: function (doc) {
                    // Reduz as margens da página para expandir a tabela
                    doc.pageMargins = [10, 10, 10, 10]; 
            
                    // Centraliza o título
                    doc.content[0].alignment = 'center';
            
                    // Ajusta o tamanho da fonte do título
                    doc.content[0].fontSize = 14;
            
                    // Aumenta o tamanho da tabela
                    doc.content[1].layout = {
                        hLineWidth: function () { return 0.5; },
                        vLineWidth: function () { return 0.5; },
                        paddingLeft: function () { return 5; },
                        paddingRight: function () { return 5; },
                        paddingTop: function () { return 5; },
                        paddingBottom: function () { return 5; }
                    };
            
                    // Define o estilo do cabeçalho da tabela
                    doc.styles.tableHeader = {
                        alignment: 'center',
                        fillColor: '#2D9CDB',
                        color: 'white',
                        bold: true,
                        fontSize: 12
                    };
            
                    // Ajusta o conteúdo da tabela para centralizar
                    doc.styles.tableBodyEven = { alignment: 'center' };
                    doc.styles.tableBodyOdd = { alignment: 'center' };
            
                    // Define o alinhamento padrão para todo o conteúdo
                    doc.defaultStyle.alignment = 'center';
            
                    // Ajusta o tamanho das colunas para preencher mais a página
                    var table = doc.content[1].table;
                    table.widths = Array(table.body[0].length).fill('*'); // Define a largura de todas as colunas para distribuir igualmente
                }
            }
        ],
        lengthMenu: [
            [10, 100, 500, -1],
            [10, 100, 500, "All"]
        ],
        data: dados, //dados,
        columns: [
            {
                title: 'ID',
                data: 'idsolicitacao',
            },
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
                visible: idsituacao === 7
            },
        ],
        columnDefs: [
            {
                targets: [4], 
                width: '1px' // Definindo a largura desejada
            },
            {
                targets: [5],
                width: '1px' // Definindo a largura desejada
            }
        ],
        rowCallback: function (row, data) {
            $(row).addClass('linha' + data.idfilial);
        },
        initComplete: function(settings, json) {
            console.log('Valor de idsituacao:', idsituacao); // Para verificar o valor
            const column = this.api().column(12);
            column.visible(idsituacao === 7);
        }
    });

    if (!$('#kt_datatable_example_export_menu').data('events-bound')) {
        $('#kt_datatable_example_export_menu').data('events-bound', true);
        var exportButtons = document.querySelectorAll('#kt_datatable_example_export_menu [data-kt-export]');
        exportButtons.forEach(exportButton => {
            exportButton.addEventListener('click', e => {
                e.preventDefault();
                const exportValue = e.target.getAttribute('data-kt-export');
                console.clear()

                const target = document.querySelector('.dt-buttons .buttons-' + exportValue);
                target.click();
            });
        });
    }

}

function abrirModalObs(dados) {
    console.log('Dados recebidos:', dados);  // Verifique se os dados estão corretos
    let opp = $('.obshist');
    opp.html('');

    if (dados.observacoes) {
        console.log('Observações:', dados.observacoes);
        let observacoes = dados.observacoes.split('|');
        let situacao_operacao = dados.situacao_operacao.split('|');
        let dataoperacao = dados.dataoperacao.split('|');

        let registros = observacoes.map((obs, index) => ({
            observacao: obs || 'Sem observação',
            situacao: situacao_operacao[index] || 'Sem situação',
            data: dataoperacao[index] || 'Sem data'
        }));

        console.log('Registros:', registros);

        registros.sort((a, b) => {
            let dateA = new Date(a.data.replace(/(\d{2})\/(\d{2})\/(\d{4})/, '$3-$2-$1')); 
            let dateB = new Date(b.data.replace(/(\d{2})\/(\d{2})\/(\d{4})/, '$3-$2-$1'));
            return dateA - dateB;
        });

        registros.forEach(registro => {
            opp.append(
                `<tr><td>${registro.observacao}</td><td>${registro.situacao}</td><td>${registro.data}</td></tr>`
            );
        });
    } else {
        opp.append("<tr><td colspan='3'>Nenhuma observação encontrada.</td></tr>");
    }

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
            listar(7)
            contarIndenizacoes()
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


