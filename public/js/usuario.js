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
    $('#nome').val('');
    $('#idfilial').val('');
    $('#idgrupo').val('');
    $('#login').val('');
    $('#senha').val('');
    $('#idusuario').val('');
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
                title: 'Situação',
                data: 'situacao',
            },
            {
                title: 'Ações',
                data: null, // Usamos `null` se não há uma propriedade específica para essa coluna no objeto de dados.
                render: function(data, type, row) {
                    dados = JSON.stringify(row).replace(/"/g, '&quot;');
                    
                    return '<button class="btn btn-primary btn-sm" onclick="setEditar('+ dados +')">Editar</button> ' +
                           '<button class="btn btn-danger btn-sm" onclick="confirmUpdateSituacao('+ row.idfilial +', 2,'+ row.idsituacao +', \'Inativar\')">Inativar</button> ' +
                           '<button class="btn btn-success btn-sm" onclick="confirmUpdateSituacao('+ row.idfilial +', 1,'+ row.idsituacao +', \'Ativar\')">Ativar</button>';
                }
            }
        ],
        rowCallback: function(row, data) {
            $(row).addClass('linha' + data.idfilial);
        }
    });

}

function confirmUpdateSituacao(id, idsituacao, atualsituacao, acao) {
    var situacaoAtual = atualsituacao == 2 ? 'Inativo' : 'Ativo';
    // Verifica se o centro de distribuição já está na situação desejada
    if (idsituacao == atualsituacao) {
        Swal.fire({
            icon: "warning",
            title: "Atenção!",
            text: "Usuario já está " + situacaoAtual
        });
        return; // Não continua com a confirmação
    }

    var mensagem = "Você tem certeza que deseja " + acao.toLowerCase() + " o usuario?";
    Swal.fire({
        title: 'Confirmação',
        text: mensagem,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sim',
        cancelButtonText: 'Não',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // Se o usuário confirmar, a função de update é chamada
            updateSituacao(id, idsituacao, atualsituacao);
        } else {
            Swal.fire('Ação cancelada', '', 'info');
        }
    });
}

function updateSituacao(id, idsituacao, atualsituacao){
    var situacao = atualsituacao == 2 ? 'Inativo' : 'Ativo'
    if(idsituacao == atualsituacao){
        Swal.fire({
            icon: "warning",
            title: "Atenção!",
            text: "Usuario já está " +  situacao
        });
        return
    }
    app.callController({
        method: 'GET',
        url: base + '/updatesituacaousuario',
        params: {
            id: id,
            idsituacao: idsituacao
        },
        onSuccess(res){
            listar(); 
            // Terceiro alerta de sucesso
            var novaSituacao = idsituacao == 2 ? 'inativado' : 'ativado';
            Swal.fire({
                icon: "success",
                title: "Sucesso!",
                text: "Usuario " + novaSituacao + " com sucesso."
            });  
        },
        onFailure(res){
            Swal.fire({
                icon: "error",
                title: "Atenção!!",
                text: "Erro ao atualizar situação do Usuario!"
            });
            return
        }
    })
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

function editar(dados) {
    console.log("Iniciando edição com os dados:", dados);

    // Atualiza o título para "Editar Usuário"
    $('#form-title').text('Editar Usuário');
    console.log("Título atualizado.");

    // Mostra a mensagem de status
    $('#status-message').show(); // Exibe a mensagem
    console.log("Mensagem de status exibida.");

    // Preenche os campos do formulário
    setEditar(dados);
    console.log("Campos do formulário preenchidos.");

    // Chama o controller para editar os dados
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
        onSuccess(res) {
            listar(); // Atualiza a lista após a edição
            limparForm();
            $('#status-message').hide();
            Swal.fire({
                icon: "success",
                title: "Sucesso!",
                text: "Editado com sucesso!"
            });
        },
        onFailure(res) {
            Swal.fire({
                icon: "error",
                title: "Atenção!!",
                text: "Erro ao editar Usuário!"
            });
            return;
        }
    });
}