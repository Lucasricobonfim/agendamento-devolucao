window.app = {
    validarCNPJ(cnpj) {
        // Remove caracteres não numéricos
        cnpj = cnpj.replace(/[^\d]/g, '');
        return cnpj.length != 14 ? false : true
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
        $.ajax({
            url : config.url,
            data : config.params,
            autoAbort : false,
            //disableCaching : true,
            disableCaching : false,
            timeout : 180000000,
            type : config.method,
            success : function (a, b, c) {
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