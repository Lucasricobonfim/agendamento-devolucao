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
    }


}
