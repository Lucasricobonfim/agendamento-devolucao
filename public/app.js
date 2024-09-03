window.app = {
    

    chamar(){
        console.log('chamou se é loko')
    },

    validarCNPJ(cnpj) {
        // Remove caracteres não numéricos
        cnpj = cnpj.replace(/[^\d]/g, '');


        return cnpj.length != 14 ? false : true

        // Verifica se o CNPJ tem 14 dígitos
        // const cnpj = '12.345.678/0001-95';
    },

    validarCampos(obj) {
        // Verifica se o objeto é realmente um objeto e não null
        if (typeof obj !== 'object' || obj === null) {
            throw new Error('O argumento deve ser um objeto.');
        }
    
        // Itera sobre as propriedades do objeto
        for (const key in obj) {
            if (obj.hasOwnProperty(key)) {
                const valor = obj[key];
                // Verifica se o valor é vazio ou é um valor não permitido (por exemplo, null ou undefined)
                if (valor === undefined || valor === null || valor === '' || (typeof valor === 'string' && valor.trim() === '')) {
                    return false
                }
            }
        }
        return true;
    },

    callController : function (config) {
        console.log('config ', config)
        $.ajax({
            url : config.url,
            data : config.params,
            autoAbort : false,
            //disableCaching : true,
            disableCaching : false,
            timeout : 180000000,
            type : config.method,
            success : function (a, b, c) {
                console.log('a= ', a)
                // return
                var tmp = JSON.parse(a);
                 
                if (tmp[0].success == true) {
                    if (typeof config.onSuccess == 'function') {
                        config.onSuccess(tmp);
                    }
                } else {
                    if (typeof config.onFailure == 'function') {
                        config.onFailure(tmp);
                    }
                }
            }
        });
    }


}





// callController : function (config) {
//     Ext.Ajax.request({
//         url : config.url || 'controller/geral.php',
//         params : config.params,
//         autoAbort : false,
//         //disableCaching : true,
//         disableCaching : false,
//         timeout : 180000000,
//         method : 'POST',
//         success : function (a, b, c) {
//             var tmp = Ext.decode(a.responseText, true);
//             if (tmp.success == true) {
//                 if (Ext.isFunction(config.onSuccess)) {
//                     config.onSuccess(tmp);
//                 }
//             } else {
//                 if (Ext.isFunction(config.onFailure)) {
//                     config.onFailure(tmp);
//                 }
//             }
//         }
//     });
// }