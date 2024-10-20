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
                data: null, 
                render: function(data, type, row) {
                    dados = JSON.stringify(row).replace(/"/g, '&quot;'); 
                    return `
                        <button class="btn btn-success btn-sm" onclick="abrirModalAceitar('${row.idsolicitacao}', 2)">Aceitar</button>
                        <button class="btn btn-danger btn-sm" onclick="abrirModalAceitar('${row.idsolicitacao}', 4)">Recusar</button>
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



function abrirModalAceitar(idsolicitacao, idsituacao){
    $('#modalAceitacao').modal('show');
    if(parseInt(idsituacao)== 2){
        $('#tituloModalObs').text('Aceitar Solicitação - Observação')
    }else{
        $('#tituloModalObs').text('Recusar Solicitação - Observação')
    }
    $('#idsolicitacao').val(idsolicitacao)
    $('#idsituacao').val(idsituacao)
  
}

function fechaModalAceitar(){
    $('#modalAceitacao').modal('hide');
}


function confimarSolicitacao(){
    let dados = {
        observacao:  $('#observacaoact').val(),
        idsolicitacao: $('#idsolicitacao').val(),
        idsituacao: $('#idsituacao').val()
    }
    let textoslt = parseInt(dados.idsituacao) == 2 ? 'Aceitar' : 'Recusar'
    if(!dados.observacao){
        Swal.fire({
            icon: "warning",
            title: "Atenção!!",
            text: "Preencha com uma Observação!"
        });
        $('#observacaoact').toggleClass('erro');
        return 
    }

    app.callController({
        method: 'POST',
        url: base + '/updatesolicitacao',
        params: dados,
        onSuccess(res){   
            fechaModalAceitar()
            listar()


            Swal.fire({
                position: "top-end",
                title: "TESE",
                icon: 'none', 
                width: 200,
                timer: 4000,  //tempo
                showConfirmButton: false,
                heightAuto: false, 
                backdrop: false, 
                allowOutsideClick: true
            }); //configurar esses para avisos de sucesso e error


            // Swal.fire({
            //     icon: "success",
            //     title: "Sucesso!",
            //     text: "Solicitação Confirmada com Sucesso!"
            // });
            // return
        },
        onFailure(res){
            
            Swal.fire({
                icon: "error",
                title: "Atenção!!",
                text: "Erro ao "+textoslt+" Solicitação!"
            });
            return
        }
    })
}







