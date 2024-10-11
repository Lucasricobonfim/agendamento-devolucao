$(document).ready(function () {
    listar()
    buscaCd()
 })

 $('#solicitar').on('click', function () {

    let dados = {
        idfilial:  $('#idfilial').val(),
        placa: $('#placa').val(),
        data: $('#data').val(),
        quantidadenota: $('#qtdnota').val(),
        observacao: $('#observacao').val()
    }
    if(!app.validarCampos(dados)){
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

function limparCampos(){
    $('#idfilial').val(''),
    $('#placa').val(''),
    $('#data').val(''),
    $('#qtdnota').val(''),
    $('#observacao').val('')
}


function solicitar(dados){
    app.callController({
        method: 'POST',
        url: base+'/solicitar-agendamento',
        params:{
            idfilial: dados.idfilial,
            placa: dados.placa,
            data: dados.data,
            quantidadenota: dados.quantidadenota,
            observacao: dados.observacao
        },
        onSuccess(res){   
            let rec = res[0]

            
            if(rec.success){
                Swal.fire({
                    icon: "success",
                    title: "Sucesso!",
                    text: "Agendamento Solicitado com sucesso!"
                }); 
                limparCampos()
            }else{
                Swal.fire({
                    icon: "error",
                    title: "Atenção!!",
                    text: "Erro ao solicitar agendamento!"
                });
                limparCampos()
                return
            }            
        },
        onFailure(res){
           let rec = res[0].ret[0]


           if(rec.existeplaca == 1){
            Swal.fire({
                icon: "warning",
                title: "Atenção!!",
                text: "Já existe um agendamento para essa Data com essa Placa"
            });
            return;
           }

            Swal.fire({
                icon: "error",
                title: "Atenção!!",
                text: "Erro ao solicitar!"
            });
            return
        }
    })
}



function buscaCd(){
    app.callController({
        method: 'GET',
        url: base + '/getcentro-distribuicao-ativos',
        params: null,
        onSuccess(res){   
            let rec = res[0].ret
            opp = $('.opp');   
            opp.html('');
            if(rec != ''){
                opp.append("<option id='filial' value=''>Selecione</option>")
                $.each(rec, function (i, el){
                    opp.append("<option id='filial' value='"+el.idfilial+"' >"+el.descricao+"</option>")
                })
            }   
        },
        onFailure(res){
            Swal.fire({
                icon: "error",
                title: "Atenção!!",
                text: "Erro ao buscar Filial!"
            });
            return
        }
    })
}

// fim cadastro


// listagem 


function listar(){
    app.callController({
        method: 'GET',
        url: base + '/get-agendamento',
        params: null,
        onSuccess(res){   

            Table(res[0].ret)    
        },
        onFailure(res){
            Swal.fire({
                icon: "error",
                title: "Atenção!!",
                text: "Erro ao listar Agendamentos!"
            });
            return
        }
    })
}





const Table = function(dados){

    //var dados = JSON.parse(ret)
    $('#table-agend').DataTable({
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
                    return '<button class="btn btn-primary btn-sm" onclick="setEditar('+ dados +')">Observação</button> ' 
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