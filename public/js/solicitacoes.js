$(document).ready(function () {
    listar()
    // Table()
    // listar(ret);
})

function listar(){
    app.callController({
        method: 'GET',
        url: base + '/getsolicitacoes',
        params: null,
        onSuccess(res){   
            Table(res[0].ret)    
        },
        onFailure(res){
            Swal.fire({
                icon: "error",
                title: "Atenção!!",
                text: "Erro ao listar Usuarios!"
            });
            return
        }
    })
}

const Table = function(dados){

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
                title: 'Cód Solicitacao',
                data: 'idsolicitacao',
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
                render: function(data) {
                    // Adicione uma classe de status com base no valor
                    const statusClass = 'status-pendente'
                    return `<span class="${statusClass}">${data}</span>`;
                }
            },
            {
                title: 'Observação',
                data: null, // Usamos `null` se não há uma propriedade específica para essa coluna no objeto de dados.
                render: function(data, type, row) {
                    dados = JSON.stringify(row).replace(/"/g, '&quot;');
                    return '<button class="btn btn-primary btn-sm" onclick="abrirModalObs('+ dados +')">Observação</button> ' 
                }
            },
            {
                title: 'Ações',
                data: null, // Usamos `null` se não há uma propriedade específica para essa coluna no objeto de dados.
                render: function(data, type, row) {
                    dados = JSON.stringify(row).replace(/"/g, '&quot;'); // Codifica o objeto para uso em HTML
                    return `
                        <button class="btn btn-success btn-sm" onclick="aceitarSolicitacao('${row.idsolicitacao}')">Aceitar</button>
                        <button class="btn btn-danger btn-sm" onclick="recusarSolicitacao('${row.idsolicitacao}')">Recusar</button>
                    `;
                }
            }
        ],
        rowCallback: function(row, data) { }
    });

}

// Modal Observacao

function abrirModalObs(dados){
    
    $('#conteudo_obs').text(dados.observacao)
    $('#observacaoModal').modal('show');
}

function fechaModalObs(){
    $('#conteudo_obs').text('')
    $('#observacaoModal').modal('hide');

}







