function teste(va){
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
          confirmButton: "btn btn-success",
          cancelButton: "btn btn-danger"
        },
        buttonsStyling: false
      });
      swalWithBootstrapButtons.fire({
        title: "Tem certeza?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Aceito",
        cancelButtonText: "Cancelar",
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {

            $(document).ready(function(){
                $.ajax({
                    url: base+'/sobre',
                    method: 'GET', // ou 'POST' se preferir
                    dataType: 'json', // o tipo de dados que você espera receber
                    success: function(response){
                        // Função a ser executada em caso de sucesso
                        console.log(response); // Exibe a resposta no console
                    },
                    error: function(xhr, status, error){
                        // Função a ser executada em caso de erro
                        console.error(xhr.responseText); // Exibe a mensagem de erro no console
                    }
                });
            });
        //   swalWithBootstrapButtons.fire({
        //     title: "Aceito",
        //     text: "Aceito com sucesso",
        //     icon: "success"
        //   });
        } else if (
          result.dismiss === Swal.DismissReason.cancel
        ) {
          swalWithBootstrapButtons.fire({
            title: "Cancelado",
            text: "NAO",
            icon: "error"
          });
        }
      });





    
}