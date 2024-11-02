$(document).ready(function () {


    let dados = {
        idsolicitacao: '1',
        nome_cd: 'TSTE',
        nome_transportadora: 'TESTE TT',
        placa: '1215',
        data: '2024/05/2024',
        situacao: 'PENDETE'
    }

    grafico(null)
    // listar()


    Table(dados)

})


function listar() {


    app.callController({
        method: 'GET',
        url: base + '/getTotalSolicitações',
        params: null,
        onSuccess(res) {
            let dados = res[0].ret.result
            console.log(dados)
            
            if (parseInt(dados[0].idtipofilial) == 1) {
                $('#totalsolicitacoes').text(dados[0].total)
                return
            }
            if (parseInt(dados[0].idtipofilial) == 3) {
                $('#totalsolicitacoes').text(dados[0].total)
                return
            }
            if (parseInt(dados[1].idtipofilial) == 2) {
                $('#totalagendamento').text(dados[1].total)
                return
            }


        },
        onFailure(res) {
            Swal.fire({
                icon: "error",
                title: "Atenção!!",
                text: "Erro ao listar total de Solicitações!"
            });
            return
        }
    })
}


function grafico (dados){

    var ctx = document.getElementById('myPieChart').getContext('2d');
    var myPieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['PEDENTE', 'ANDAMENTO', 'FINALIZADO', 'RECUSADO', 'CANCELADO'],
            datasets: [{
                label: 'Exemplo de Gráfico Pizza',
                data: [30, 50, 20, 50, 10], // Valores para cada categoria
                backgroundColor: [
                    'rgb(235, 190, 43)',  // Amarelo
                    'rgb(43, 72, 235)',   // Azul
                    'rgb(51, 170, 51)',   // Verde
                    'rgb(235, 43, 43)',   // Vermelho
                    'rgb(100, 11, 85)'    // Roxo
                ],
                hoverOffset: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,  
            plugins: {
                legend: {
                    position: 'top',
                }
            }
        }
    });
}



const Table = function (dados, idsituacao) {

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
        // {
        //     extend: 'copyHtml5',
        // },
        // {
        //     extend: 'excelHtml5',
        //     title: 'solicitacoes',
        // },
        // {
        //     extend: 'csvHtml5',
        // },
        // {
        //     extend: 'pdfHtml5',
        //     orientation: 'landscape', // Export in landscape mode
        //     pageSize: 'A3', // Use A4 page size
        //     title: 'solicitacoes',
        //     exportOptions: {
        //         columns: ':visible'
        //     }
        // }
        ],
        lengthMenu: [
            [10, 100, 500, -1],
            [10, 100, 500, "All"]
        ],
        data: dados,
        columns: [
            {
                title: 'Cód Solicitacao',
                data: 'idsolicitacao',
            },
            {
                title: 'CD',
                data: 'nome_cd',
            },
            {
                title: 'Transportadora',
                data: 'nome_transportadora'
            },
            {
                title: 'Placa',
                data: 'placa'
            },
            {
                title: 'Data Agendada',
                data: 'data',
            },
            {
                title: 'Situação',
                data: 'situacao',
                render: function (data, type, row) {
                    let statusClass = '';

                    // Usando switch case para definir a classe de acordo com a situação
                    switch (parseInt(row.idsituacao)) {
                        case 1: statusClass = 'status-pendente'; break;
                        case 2: statusClass = 'status-andamento'; break;
                        case 3: statusClass = 'status-finalizado'; break;
                        case 4: statusClass = 'status-recusado'; break;
                        case 5: statusClass = 'status-cancelado'; break;
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
                    return '<button style="width: 100%; " class="btn btn-primary btn-sm" onclick="abrirModalObs(' + dados + ')">Observação</button> '
                }
            },
        ],
        rowCallback: function (row, data) { },
        initComplete: function(settings, json) {}
    });




    // if (!$('#kt_datatable_example_export_menu').data('events-bound')) {
    //     $('#kt_datatable_example_export_menu').data('events-bound', true);
    //     var exportButtons = document.querySelectorAll('#kt_datatable_example_export_menu [data-kt-export]');
    //     exportButtons.forEach(exportButton => {
    //         exportButton.addEventListener('click', e => {
    //             e.preventDefault();
    //             const exportValue = e.target.getAttribute('data-kt-export');
    //             console.clear()

    //             const target = document.querySelector('.dt-buttons .buttons-' + exportValue);
    //             target.click();
    //         });
    //     });
    // }



}


// function abrirModalObs(dados) {

//     $('#conteudo_obs').text(dados.observacao)
//     $('#observacaoModal').modal('show');
// }

// function fechaModalObs() {
//     $('#conteudo_obs').text('')
//     $('#observacaoModal').modal('hide');

// }