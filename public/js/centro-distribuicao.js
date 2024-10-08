$(document).ready(function () {
    listar(); // Chama a função listar ao carregar a página
    formatarCNPJ();

    $('#cadastro').on('click', function () {
        var idfilial = $('#idfilial').val();
        let dados = {
            nome: $('#nome').val(),
            cnpj_cpf: $('#cnpj_cpf').val().replace(/[^\d]/g, ''),
            email: $('#email').val(),
            telefone: $('#telefone').val()
        };

        console.log(dados);

        if (idfilial) {
            dados.idfilial = idfilial;

            if (!app.validarCampos(dados)) {
                Swal.fire({
                    icon: "warning",
                    title: "Atenção!!",
                    text: "Preencha todos os campos!"
                });
                return;
            }
            if (!app.validarCNPJ(dados.cnpj_cpf)) {
                Swal.fire({
                    icon: "warning",
                    title: "Atenção!!",
                    text: "CNPJ Inválido!"
                });
                return false;
            }


            editar(dados);


        } else {
            if (!app.validarCampos(dados)) {
                Swal.fire({
                    icon: "warning",
                    title: "Atenção!!",
                    text: "Preencha todos os campos!"
                });
                return;
            }
            if (!app.validarCNPJ(dados.cnpj_cpf)) {
                Swal.fire({
                    icon: "warning",
                    title: "Atenção!!",
                    text: "CNPJ Inválido!"
                });
                return false;
            }
            cadastro(dados);
        }
    });
});

function formatarCNPJ() {
    var cnpj_cpf = document.getElementById('cnpj_cpf');

    cnpj_cpf.addEventListener('input', function (e) {
        let value = e.target.value;
        value = value.replace(/\D/g, ''); // Remove caracteres não numéricos
        value = value.substring(0, 14); // Limita o número de dígitos

        if (value.length > 12) {
            value = value.replace(/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/, '$1.$2.$3/$4-$5');
        }

        e.target.value = value;
    });
}

function listar() {
    app.callController({
        method: 'GET',
        url: base + '/getcentro-distribuicao',
        params: null,
        onSuccess(res) {
            //console.log(res[0].ret); // Adicione este log
            Table(res[0].ret)
        },
        onFailure(res) {
            Swal.fire({
                icon: "error",
                title: "Atenção!!",
                text: "Erro ao listar Centro de distribuição!"
            });
            return;
        }
    });
}

function cadastro(dados) {  
    app.callController({
        method: 'POST',
        url: base + '/cadcentro-distribuicao',
        params: dados,
        onSuccess(res) {         
            $('#nome').val('');
            $('#cnpj_cpf').val('');
            $('#email').val('');
            $('#telefone').val('');
            $('#status').val('');
            listar(); // Atualiza a lista após o cadastro
            Swal.fire({
                icon: "success",
                title: "Sucesso!",
                text: "Cadastrado com sucesso!"
            });
        },
        onFailure(res) {
            if (res[0]['ret']['result'][0]['existecpf'] == 1) {
                Swal.fire({
                    icon: "warning",
                    title: "Atenção!!",
                    text: "CNPJ já existe"
                });
                return;
            }
            Swal.fire({
                icon: "error",
                title: "Atenção!!",
                text: "Erro ao cadastrar Centro de distribuição"
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
            text: "Centro de distribuição já está " +  situacao
        });
        return
    }
    app.callController({
        method: 'GET',
        url: base + '/updatesituacaocentro-distribuicao',
        params: {
            id: id,
            idsituacao: idsituacao
        },
        onSuccess(res){
            listar()
              
        },
        onFailure(res){
            Swal.fire({
                icon: "error",
                title: "Atenção!!",
                text: "Erro ao atualizar situação da Transportadora!"
            });
            return
        }
    })
}

    function setEditar(row){
    $('#idfilial').val(row.idfilial),
    $('#nome').val(row.nome),
    $('#cnpj_cpf').val(row.cnpj_cpf)
    $('#email').val(row.email),
    $('#telefone').val(row.telefone)
    formatarCNPJ()
    
}
    function editar(dados){
        //console.log('dda; ',dados)
        app.callController({
            method: 'GET',
            url: base + '/editarcentro-distribuicao',
            params: {
               nome: dados.nome,
               cnpj_cpf: dados.cnpj_cpf,
               email: dados.email,
               telefone: dados.telefone,
               idfilial: dados.idfilial
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
                    text: "Erro ao editar Transportadora!"
                });
                return
               
            }
        })
    }

