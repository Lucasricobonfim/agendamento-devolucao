$(document).ready(function () {
    listar()

    
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
            text: "Erro ao lista solicitações!"
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
                title: 'CD',
                data: 'centro_distribuicao'
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
            },
            {
                title: 'Observação',
                data: null, // Usamos `null` se não há uma propriedade específica para essa coluna no objeto de dados.
                render: function(data, type, row) {
                    dados = JSON.stringify(row).replace(/"/g, '&quot;');
                    return '<button class="btn btn-primary btn-sm" onclick="abrirModalObs('+ dados +')">Observação</button> ' 
                }
            }
        ],
        columnDefs: [
            { 
                targets: [0], // Índice da coluna "Cód Solicitacao"
                width: '50px' // Definindo a largura desejada
            }
        ],
        rowCallback: function(row, data) {
            $(row).addClass('linha' + data.idfilial);
        }
    });

}





