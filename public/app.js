window.app = {
    validarCNPJ(cnpj) {
        // Remove caracteres não numéricos
        cnpj = cnpj.replace(/[^\d]/g, '');
        return cnpj.length != 14 ? false : true
    },

    validarCampos_old(obj) {
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
    },

    validarCampos(obj) {
        // Verifica se o argumento é um objeto
        if (typeof obj !== 'object' || obj === null) {
            throw new Error('O argumento deve ser um objeto.');
        }
    
        let valido = true;
    
        // Itera sobre as propriedades do objeto
        for (const key in obj) {
            if (obj.hasOwnProperty(key)) {
                const valor = obj[key];
                const campo = $('#' + key); // Seleciona o input pelo ID
    
                // Limpa os erros anteriores
                campo.removeClass('erro');
    
                // Verifica se o valor é vazio ou não permitido
                if (valor === undefined || valor === null || valor === '' || (typeof valor === 'string' && valor.trim() === '')) {
                    valido = false;
                    // Adiciona uma classe de erro ao campo vazio
                    campo.addClass('erro');
                }
            }
        }
    
        return valido;
    },

    formatarData(data) {
        // Converte a string para um objeto Date
        let [ano, mes, dia] = data.split('-'); // Divide a string no formato "YYYY-MM-DD"
        let dataObj = new Date(ano, mes - 1, dia); // Mês em Date começa do índice 0
    
        // Formata a data no padrão "DD/MM/YYYY"
        return `${String(dataObj.getDate()).padStart(2, '0')}/${String(dataObj.getMonth() + 1).padStart(2, '0')}/${dataObj.getFullYear()}`;
    }
}