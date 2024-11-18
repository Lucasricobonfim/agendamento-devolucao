$(document).ready(function () {
    buscaNegocio()
    buscaTransportadora()
    listar();
    validarCampoNumerico('#nota');
    validarCampoNumerico('#nota2');

    $('#solicitarIndenizacaoModal').modal({
        backdrop: 'static',
        keyboard: false
    });
});

$('#anexo').on('change', function() {
    // Obtém o nome do arquivo selecionado
    const fileName = $(this).val().split('\\').pop() || "Nenhum arquivo escolhido";
    $('#file-chosen').text(fileName); // Exibe o nome do arquivo no elemento correspondente
});

$('#solicitar').on('click', function () {
    let dados = {
        numero_nota: $('#nota').val(),
        numero_nota2: $('#nota2').val(),
        idnegocio: $('#idnegocio').val(),
        tipo_indenizacao: $('#tipoindenizacao').val(),
        idfilial: $('#idfilial').val(),
        arquivo: $('#arquivo')[0].files,
        data: $('#data').val(),
        observacao: $('#observacao').val()
    }
    
    if (!app.validarCampos(dados)) {
        Swal.fire({
            icon: "warning",
            title: "Atenção!!",
            text: "Preencha todos os campos!"
        });
        return
    }
    // validar se a data da solicitacao e menor que dia de HOJE
    let dataSolicitacao = new Date(dados.data + 'T00:00:00'); // Garante a conversão correta da string para Date
    let hoje = new Date();
    hoje.setHours(0, 0, 0, 0); // Zera as horas para comparar apenas a data

    if (dataSolicitacao < hoje) {
        Swal.fire({
            icon: "warning",
            title: "Atenção!!",
            text: "A data da solicitação não pode ser anterior à data de hoje!"
        });
        return;
    }

    solicitar(dados)


})
function validarCampoNumerico(campoId) {
    $(campoId).on('input', function() {
        this.value = this.value.replace(/\D/g, '');
    });
}

function limparCampos() {
    $('#nota').val(''),
    $('#nota2').val(''),
    $('#idnegocio').val(''),
    $('#tipoindenizacao').val(''),
    $('#idfilial').val(''),
    $('#arquivo').val('')
    $('#data').val('')
    $('#observacao').val('')
}

function solicitar(dados) {
    const formData = new FormData();
    
    // Adiciona outros dados ao FormData
    formData.append('numero_nota', dados.numero_nota);
    formData.append('numero_nota2', dados.numero_nota2);
    formData.append('idnegocio', dados.idnegocio);
    formData.append('tipo_indenizacao', dados.tipo_indenizacao);
    formData.append('idfilial', dados.idfilial);
    formData.append('data', dados.data);
    formData.append('observacao', dados.observacao);

    // Adiciona os arquivos ao FormData
    if (dados.arquivo.length > 0) {
        Array.from(dados.arquivo).forEach((file, index) => {
            // Verifica o tipo de arquivo antes de adicionar (exemplo: apenas PDF ou imagens)
            if (file.type === "application/pdf" || file.type.startsWith("image/")) {
                formData.append('anexo[]', file);
            } else {
                Swal.fire({
                    icon: "warning",
                    title: "Atenção!!",
                    text: "Formato de arquivo não permitido. Selecione apenas PDF ou imagens!"
                });
                return;
            }
        });
    } else {
        Swal.fire({
            icon: "warning",
            title: "Atenção!!",
            text: "Selecione pelo menos um arquivo para anexar!"
        });
        return;
    }

    // Realiza a solicitação AJAX
    $.ajax({
        method: 'POST',
        url: base + '/solicitar-indenizacao',
        data: formData,
        processData: false,
        contentType: false,
        success: function (res) {
            listar(); // Atualiza a lista de indenizações
            fechaModalIndenizacao(); // Fecha o modal
            Swal.fire({
                icon: "success",
                title: "Sucesso!",
                text: "Solicitação Enviada com Sucesso!"
            });
        },
        error: function (xhr, status, error) {
            Swal.fire({
                icon: "error",
                title: "Atenção!!",
                text: "Erro ao solicitar indenização!"
            });
        }
    });
}

function buscaNegocio() {
    app.callController({
        method: 'GET',
        url: base + '/get-negocio-ativos',
        params: null,
        onSuccess(res) {
            //console.log(res)
            let rec = res[0].ret
            oppp = $('.oppp');
            oppp.html('');
            if (rec != '') {
                oppp.append("<option id='filial' value=''>Selecione</option>")
                $.each(rec, function (i, el) {
                    oppp.append("<option id='filial' value='" + el.idfilial + "' >" + el.descricao + "</option>")
                })
            }
        },
        onFailure(res) {
            Swal.fire({
                icon: "error",
                title: "Atenção!!",
                text: "Erro ao buscar Filial!"
            });
            return
        }
    })
}


function buscaTransportadora() {
    app.callController({
        method: 'GET',
        url: base + '/get-transportadora-ativos',
        params: null,
        onSuccess(res) {
            let rec = res[0].ret
            opp = $('.opp');
            opp.html('');
            if (rec != '') {
                opp.append("<option id='filial' value=''>Selecione</option>")
                $.each(rec, function (i, el) {
                    opp.append("<option id='filial' value='" + el.idfilial + "' >" + el.descricao + "</option>")
                })
            }
        },
        onFailure(res) {
            Swal.fire({
                icon: "error",
                title: "Atenção!!",
                text: "Erro ao buscar Filial!"
            });
            return
        }
    })
}

function listar() {
    app.callController({
        method: 'GET',
        url: base + '/get-indenizacao-cd',
        params: null,
        onSuccess(res) {
            console.log('res[0]:', res[0]);  // Verifique a estrutura do primeiro item da resposta
            console.log('res[0].ret:', res[0].ret);  // Verifique o campo ret
            console.log('res[0].ret.observacoes:', res[0].ret.observacoes);  // Verifique o campo observacoes
            Table(res[0].ret)
        },
        onFailure(res) {
            Swal.fire({
                icon: "error",
                title: "Atenção!!",
                text: "Erro ao listar indenizações!"
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
            {
                extend: 'copyHtml5',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7] // Exporta somente as colunas escolhidas para planilha 
                }
            },
            {
                extend: 'excelHtml5',
                title: 'Indenizacações',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7]
                }
            },
            {
                extend: 'csvHtml5',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7]
                }
            },
            {
                extend: 'pdfHtml5',
                orientation: 'landscape', 
                pageSize: 'A3', 
                title: 'INDENIZAÇÕES',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7]
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
                title: 'Transportadora',
                data: 'transportadora'
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
                render: function(data) {
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
                        case 7: statusClass = 'status-finalizado'; break;
                        case 6: statusClass = 'status-contestacao'; break;
                        case 9: statusClass = 'status-faturado'; break;
                        case 10: statusClass = 'status-recusado'; break;
                        default: statusClass = '';
                    }

                    return `<span class="${statusClass}">${data}</span>`;
                }
            },
            {
                title: 'Observacao',
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
        ],
        columnDefs: [
            {
                targets: [0], 
                width: '1px' 
            },
            {
                targets: [1], 
                width: '1px' 
            },
            {
                targets: [2], 
                width: '1px' 
            },
            {
                targets: [3], 
                width: '1px' 
            },
            {
                targets: [4], 
                width: '1px'
            },
            {
                targets: [5],
                width: '1px'
            }
            ,
            {
                targets: [6],
                width: '1px'
            }
        ],
        rowCallback: function(row, data) {
            $(row).addClass('linha' + data.idfilial);
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
function fechaModalIndenizacao() {
    $('#solicitarIndenizacaoModal').modal('hide'); // Fecha o modal

    // Limpar campos
    $('#nota').val('');
    $('#nota2').val('');
    $('#idnegocio').val('');
    $('#tipoindenizacao').val('');
    $('#idfilial').val('');
    $('#data').val('');
    $('#observacao').val('');
    $('#arquivo').val(''); // Limpar arquivo
    $('#file-chosen').text("Nenhum arquivo escolhido"); // Resetar texto
}

// Evento de clique no botão de anexo
function abrirModalAnexo(dados) {
    console.log(dados);
    // Mostra o modal de anexos
    $('#imageModal').modal('show');

    // Limpa o conteúdo do modal antes de adicionar os anexos
    $('#modalImage').html('');

    // Requisição AJAX para buscar as imagens da solicitação
    $.ajax({
        method: 'GET',
        url: base + '/get-anexos-solicitacao', // URL para buscar os anexos
        data: { idsolicitacao: dados.idsolicitacao }, // Envia o ID da solicitação
        success: function (res) {
            console.log(res);  // Verifica a resposta da requisição
            if (res.success && res.ret.length > 0) {
                // Variáveis para navegação entre as imagens
                let currentIndex = 0;

                // Função para atualizar a imagem no modal
                function updateImage() {
                    console.log("Exibindo imagem: ", res.ret[currentIndex]);
                    const imgSrc = baseUrl + res.ret[currentIndex];  // Ajuste o caminho da imagem
                    console.log("Caminho da imagem: ", imgSrc);  // Verifica o caminho final
                    const imgElement = `<img src="${imgSrc}" alt="Anexo" class="img-fluid" style="max-height: 70vh;">`;
                    $('#modalImage').html(imgElement);
                }

                // Exibe a primeira imagem
                updateImage();

                // Navegar para a imagem anterior
                $('#prevBtn').on('click', function() {
                    if (currentIndex > 0) {
                        currentIndex--;
                        updateImage();  // Atualiza a imagem ao clicar no botão 'Anterior'
                    }
                });

                // Navegar para a próxima imagem
                $('#nextBtn').on('click', function() {
                    if (currentIndex < res.ret.length - 1) {
                        currentIndex++;
                        updateImage();  // Atualiza a imagem ao clicar no botão 'Próximo'
                    }
                });
            } else {
                $('#modalImage').html('<p>Nenhum anexo encontrado.</p>');
            }
        },
        error: function () {
            Swal.fire({
                icon: "error",
                title: "Erro!",
                text: "Falha ao carregar anexos."
            });
        }
    });
}
