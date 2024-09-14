$(document).ready(function () {
    Table(ret);
    // listar(ret);
    $('#cadastro').on('click', function () {
        var idfilial = $('#idfilial').val()
        let dados = {
            nome: $('#nome').val(),
            cnpj_cpf: $('#cnpj_cpf').val().replace(/[^\d]/g, ''),
            email: $('#email').val(),
            telefone: $('#telefone').val()
        }
        
     
        if(idfilial){
            dados.idfilial = idfilial
            
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

            
            editar(dados)



        }else{ 
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


function limparForm(){
    $('#idfilial').val('');
    $('#nome').val('');
    $('#cnpj_cpf').val('')
    $('#email').val(''),
    $('#telefone').val('')
}


function cadastro(dados){  
    
    app.callController({
        method: 'POST',
        url: base + '/cadtransportadoras',
        params: dados,
        onSuccess(res){         
                 $('#nome').val('');
                 $('#cnpj_cpf').val('')
                 $('#email').val(''),
                 $('#telefone').val(''),
                 $('#status').val(''),
                window.location.href = base+'/transportadoras';
                Swal.fire({
                    icon: "success",
                    title: "Sucesso!",
                    text: "Cadastrado com sucesso!"
                });
        },
        onFailure(res){
            
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
                           '<button class="btn btn-danger btn-sm" onclick="updateSituacao('+ row.idfilial +','+ 2+','+row.idsituacao+')">Inativar</button> '+
                           '<button class="btn btn-success btn-sm" onclick="updateSituacao('+row.idfilial +','+ 1+','+row.idsituacao+')">Ativar</button>';
                }
            }
        ],
        rowCallback: function(row, data) {
            // 
            // 
            $(row).addClass('linha' + data.idfilial);

        }
    });

}

function updateSituacao(id, idsituacao, atualsituacao){
   
    var situacao = atualsituacao == 2 ? 'Inativa' : 'Ativa'
    if(idsituacao == atualsituacao){
        Swal.fire({
            icon: "warning",
            title: "Atenção!",
            text: "Transportadora já está " +  situacao
        });
        return
    }
    
    app.callController({
        method: 'GET',
        url: base + '/updatesituacaotransportadora',
        params: {
            id: id,
            idsituacao: idsituacao
        },
        onSuccess(res){
            window.location.href = base+'/transportadoras';
        },
        onFailure(res){
            
        }
    })
}


function setEditar(row){

   
    $('#idfilial').val(row.idfilial),
    $('#nome').val(row.nome),
    $('#cnpj_cpf').val(row.cnpj_cpf)
    $('#email').val(row.email),
    $('#telefone').val(row.telefone)
}

function editar(dados){
    // console.log('dda; ',dados)
    // return
    app.callController({
        method: 'GET',
        url: base + '/editartransportadora',
        params: {
           nome: dados.nome,
           cnpj_cpf: dados.cnpj_cpf,
           email: dados.email,
           telefone: dados.telefone,
           idfilial: dados.idfilial
        },
        onSuccess(res){
            window.location.href = base+'/transportadoras';
            
        },
        onFailure(res){
            
            console.log('Falha res ',res)
           
        }
    })
}