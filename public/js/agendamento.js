$(document).ready(function () {

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





    //  ---

    solicitar(dados)

    
})


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
            var rec = res[0].ret
        },
        onFailure(res){
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
            var rec = res[0].ret
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

