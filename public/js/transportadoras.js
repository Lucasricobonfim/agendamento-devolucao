$(document).ready(function () {
    Table(ret);
    // listar(ret);
    $('#cadastro').on('click', function () {
        let dados = {
            idtransportadora: $('#idtransportadora').val(),
            nome: $('#nome').val(),
            cnpj_cpf: $('#cnpj_cpf').val().replace(/[^\d]/g, ''),
            email: $('#email').val(),
            telefone: $('#telefone').val(),
            status: $('#status').val(),
        }
     
        if(dados.idtransportadora){
            // chamar o editar
            console.log('tem o id :',dados.idtransportadora)
            return
        }{
         
            if (!app.validarCampos(dados)) {
                Swal.fire({
                    icon: "warning",
                    title: "Atenção!!",
                    text: "Preencha todos os campos!"
                });
                return
            }
            if(!app.validarCNPJ(dados.cnpj_cpf)){
                Swal.fire({
                    icon: "warning",
                    title: "Atenção!!",
                    text: "CNPJ Inválido!"
                });
                return false;
            }
            
            cadastro(dados)
        }
    })
})

function cadastro(dados){  
    console.log('cadastro')
    app.callController({
        method: 'POST',
        url: base + '/cadtransportadoras',
        params: dados,
        onSuccess(res){
            let data = JSON.parse(res);
            
                 $('#nome').val('');
                 $('#cnpj_cpf').val('')
                 $('#email').val(''),
                 $('#telefone').val(''),
                 $('#status').val(''),

                Swal.fire({
                    icon: "success",
                    title: "Sucesso!",
                    text: "Cadastrado com sucesso!"
                });
                return
            
        },
        onFailure(res){
            console.log(res)
                if (res[0]['result'][0]['existecpf'] == 1) {
                    Swal.fire({
                        icon: "warning",
                        title: "Atenção!!",
                        text: "CNPJ já existe"
                    });
                    return
                }
                Swal.fire({
                    icon: "error",
                    title: "Atenção!!",
                    text: "Erro ao cadastrar Transportadora"
                });
                return
        }
    })

}
function listar(ret){
    rec = JSON.parse(ret);  
}

const Table = function(ret){
    var dados = JSON.parse(ret)
    $('#mytable').DataTable({
        dom: 'Bfrtip',
        responsive: true,
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.10.25/i18n/Portuguese-Brasil.json"
        },
        buttons: [
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
        ],
        lengthMenu: [
            [10, 100, 500, -1],
            [10, 100, 500, "All"]
        ],
        data: dados, //dados,
        columns: [
            {
                title: 'Nome',
                data: 'nome',
            },
            {
                title: 'CNPJ',
                data: 'cnpj_cpf'
            },
            {
                title: 'E-mail',
                data: 'email'
            },
            {
                title: 'Telefone',
                data: 'telefone'
            },
            {
                title: 'Status',
                data: 'descricao',
            },
            {
                title: 'Ações',
                data: null, // Usamos `null` se não há uma propriedade específica para essa coluna no objeto de dados.
                render: function(data, type, row) {
                   dados = JSON.stringify(row).replace(/"/g, '&quot;');
                   
                    return '<button class="btn btn-primary btn-sm" onclick="setEditar('+ dados +')">Editar</button> ' +
                           '<button class="btn btn-danger btn-sm" onclick="deletar('+ row.idtransportadora +')">Excluir</button>';
                }
            }
        ],
        rowCallback: function(row, data) {
            // console.log('r',row)
            // console.log('data',data)
            $(row).addClass('linha' + data.idtransportadora);

        }
    });

}

function deletar(id){
   
    console.log('id', id)
    
    app.callController({
        method: 'GET',
        url: base + '/deltransportadoras',
        params: {
            id: id
        },
        onSuccess(res){
            console.log('S ',res)
            $('.linha' + id).hide(500)
        },
        onFailure(res){
            console.log('F ',res)
           
        }
    })
}


function setEditar(row){
   
    console.log(row)
   
    $('#idtransportadora').val(row.idtransportadora),
    $('#nome').val(row.nome),
    $('#cnpj_cpf').val(row.cnpj_cpf)
    $('#email').val(row.email),
    $('#telefone').val(row.telefone),
    $('#status').val(row.status)

    // console.log('id', id)
    

}

function editar(dados){

    console.log('da', dados)


    app.callController({
        method: 'GET',
        url: base + '/deltransportadoras',
        params: {
            id: id
        },
        onSuccess(res){
            console.log('S ',res)
            $('.linha' + id).hide(500)
        },
        onFailure(res){
            console.log('F ',res)
           
        }
    })
}

/*
function cadastro(dados) {
    $.ajax({
        type: "post",
        url: base + '/cadtransportadoras',
        data: (
            dados
        ),
        success: function (res) {
            let data = JSON.parse(res);
            if (data[0]['success'] != true) {
                if (data[0]['result'][0]['existecpf'] == 1) {
                    Swal.fire({
                        icon: "warning",
                        title: "Atenção!!",
                        text: "CNPJ já existe"
                    });
                    return
                }
                Swal.fire({
                    icon: "error",
                    title: "Atenção!!",
                    text: "Dados Invalidos"
                });
                return
            } else {
                 $('#nome').val('');
                 $('#cnpj_cpf').val('')
                 $('#email').val(''),
                 $('#telefone').val(''),
                 $('#status').val(''),

                Swal.fire({
                    icon: "success",
                    title: "Sucesso!",
                    text: "Cadastrado com sucesso!"
                });
                return
            }

        }
    })
}


    */