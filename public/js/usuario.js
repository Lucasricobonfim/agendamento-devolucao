$(document).ready(function () {
    listar()
    // Table()
    // listar(ret);
    $('#cadastro').on('click', function () {
        var idusuario = $('#idusuario').val()
      
        let dados = {
            nome:  $('#nome').val(),
            login: $('#login').val(),
            senha: $('#senha').val(),
            idfilial: $('#idfilial').val(),
            idgrupo: $('#idgrupo').val()
        }
        
        if(!app.validarCampos(dados)){
            Swal.fire({
                icon: "warning",
                title: "Atenção!!",
                text: "Preencha todos os campos!"
            });
            return
        }

        if(idusuario){
            dados.idusuario = idusuario

            editar(dados)

        }else{

            cadastro(dados)
        }

        
    })
    

    $('#idgrupo').change(function() {
        var idgrupo = $(this).val();

        buscaFilial(idgrupo)
    });

})

function mostrarSenha(){
   let inputSenha = $('#senha')
   if (inputSenha.attr('type') === 'password') {
        inputSenha.attr('type', 'text');
    } else {
        inputSenha.attr('type', 'password');
    }
}

function limparForm(){
    $('#nome').val(''),
    $('#login').val(''),
    $('#senha').val(''),
    $('#idfilial').val(''),
    $('#idgrupo').val('')
}

function listar(){
    app.callController({
        method: 'GET',
        url: base + '/getusuarios',
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

function buscaFilial(idgrupo){
    app.callController({
        method: 'GET',
        url: base + '/getfilialporgrupo',
        params: {
            idgrupo: idgrupo
        },
        onSuccess(res){   
            var rec = res[0].ret
            opp = $('.opp');
            opp.html('');
            if(rec != ''){
                $.each(rec, function (i, el){
                    console.log('el: ',el)
                    opp.append("<option id='filial' value='"+el.idfilial+"' >"+el.descricao+"</option>")
                })
            }   
        },
        onFailure(res){
            Swal.fire({
                icon: "error",
                title: "Atenção!!",
                text: "Erro ao buscar Filial por Grupo!"
            });
            return
        }
    })
}

function cadastro(dados){
    app.callController({
        method: 'POST',
        url: base + '/cadusuario',
        params: dados,
        onSuccess(res){   
            listar()
            limparForm()
            Swal.fire({
                icon: "success",
                title: "Sucesso!",
                text: "Cadastrado com sucesso!"
            });
        },
        onFailure(res){
            Swal.fire({
                icon: "error",
                title: "Atenção!!",
                text: "Erro ao cadastrar Usuario!"
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
                title: 'Nome',
                data: 'nome',
            },
            {
                title: 'Login',
                data: 'login'
            },
            {
                title: 'Senha',
                data: 'senha'
            },
            {
                title: 'Filial',
                data: 'filial'
            },
            {
                title: 'Grupo',
                data: 'grupo',
            },
            {
                title: 'Ações',
                data: null, // Usamos `null` se não há uma propriedade específica para essa coluna no objeto de dados.
                render: function(data, type, row) {
                    
                    dados = JSON.stringify(row).replace(/"/g, '&quot;');

                  
                    return '<button class="btn btn-primary btn-sm" onclick="setEditar('+ dados +')">Editar</button> ' 
                    // +'<button class="btn btn-danger btn-sm" onclick="updateSituacao('+ row.idusuario +','+ 2+','+row.idsituacao+')">Inativar</button> '+
                            // '<button class="btn btn-success btn-sm" onclick="updateSituacao('+row.idusuario +','+ 1+','+row.idsituacao+')">Ativar</button>';
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

function setEditar(row){
    $('#idusuario').val(row.idusuario),
    $('#nome').val(row.nome),
    $('#login').val(row.login),
    $('#senha').val(row.senha),
    $('#idfilial').val(row.idfilial),
    $('#idgrupo').val(row.idgrupo)
    // formatarCNPJ()
}

function editar(dados){
    
    app.callController({
        method: 'GET',
        url: base + '/editarusuario',
        params: {
           nome: dados.nome,   
           idfilial: dados.idfilial,
           idgrupo: dados.idgrupo,
           login: dados.login,
           senha: dados.senha,
           idusuario: dados.idusuario
        },
        onSuccess(res){
            listar()
            Swal.fire({
                icon: "success",
                title: "Sucesso!",
                text: "Editado com sucesso!"
            });
            
        },
        onFailure(res){
            Swal.fire({
                icon: "error",
                title: "Atenção!!",
                text: "Erro ao editar Usuario!"
            });
            return
           
        }
    })
}