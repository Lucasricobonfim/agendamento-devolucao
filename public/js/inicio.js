$(document).ready(function () {
    listar()
})


function listar() {


    app.callController({
        method: 'GET',
        url: base + '/getTotalSolicitações',
        params: null,
        onSuccess(res) {
            let dados = res[0].ret.result
            console.log(dados)
            
            if (parseInt(dados[0].idtipofilial) == 1) {
                $('#totalsolicitacoes').text(dados[0].total)
                return
            }
            if (parseInt(dados[0].idtipofilial) == 3) {
                $('#totalsolicitacoes').text(dados[0].total)
                return
            }
            if (parseInt(dados[1].idtipofilial) == 2) {
                $('#totalagendamento').text(dados[1].total)
                return
            }


        },
        onFailure(res) {
            Swal.fire({
                icon: "error",
                title: "Atenção!!",
                text: "Erro ao listar total de Solicitações!"
            });
            return
        }
    })
}