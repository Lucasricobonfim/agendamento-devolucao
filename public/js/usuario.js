$(document).ready(function () {
    listar()
    Table()
    // listar(ret);
    $('#cadastro').on('click', function () {
       
        let dados = {
            nome: $('#nome').val(),
            login: $('#login').val(),
            senha: $('#senha').val(),
            //idfilial: $('#idfilial').val(),
            idgrupo: $('#idgrupo').val()
        }
        console.log(dados)
        if(!app.validarCampos(dados)){
            Swal.fire({
                icon: "warning",
                title: "Atenção!!",
                text: "Preencha todos os campos!"
            });
            return
        }

        cadastro(dados)
    })
    

})

        function listar(){
            app.callController({
                method: 'GET',
                url: base + '/getusuarios',
                params: null,

                onSuccess(res){   

                    Table(res[0].result)
                    
                    console.log('sucesso', res)
                        
                },
                onFailure(res){
                    console.log('falha', res)
                   
                }
            })
        }


        function cadastro(dados){
            app.callController({
                method: 'POST',
                url: base + '/cadusuario',
                params: dados,
                onSuccess(res){   
                    
                    console.log('sucesso', res)
                        //  $('#nome').val('');
                        //  $('#cnpj_cpf').val('')
                        //  $('#email').val(''),
                        //  $('#telefone').val(''),
                        //  $('#status').val(''),
                        // window.location.href = base+'/transportadoras';
                        // Swal.fire({
                        //     icon: "success",
                        //     title: "Sucesso!",
                        //     text: "Cadastrado com sucesso!"
                        // });
                },
                onFailure(res){
                    console.log('falha', res)
                        // if (res[0]['result'][0]['existecpf'] == 1) {
                        //     Swal.fire({
                        //         icon: "warning",
                        //         title: "Atenção!!",
                        //         text: "CNPJ já existe"
                        //     });
                        //     return
                        // }
                        // Swal.fire({
                        //     icon: "error",
                        //     title: "Atenção!!",
                        //     text: "Erro ao cadastrar Transportadora"
                        // });
                        // return
                }
            })
        }



        const Table = function(ret){

            console.log('aaa', ret)
            //var dados = JSON.parse(ret)
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
                data: null, //dados,
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
                        data: 'idfilial'
                    },
                    {
                        title: 'Grupo',
                        data: 'idgrupo',
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