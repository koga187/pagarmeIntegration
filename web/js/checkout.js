$(document).ready(function() {
    $body = $('body');

    $('.cardNumber').mask('0000 0000 0000 0000');
    $('.cardExpireDate').mask('00/00');
    $('.cpf').mask('000.000.000-00');
    $('.zipcode').mask('00000-000');
    $('.phoneNumber').mask('(00)0000-0000#');

    $('#address_zipcode').on('change', function() {
        cep = $(this).val();
        cep = cep.replace('-', '');
        $.ajax({
            url: 'http://viacep.com.br/ws/' + cep + '/json/unicode/',
            dataType: 'json',
            method: 'get',
            beforeSend: function() {
                $body.loading({
                    message: 'Estamos procurando o CEP'
                });
            },
            success: function(jsonResponse, status, jqXHR) {
                $('#address_neighborhood').val(jsonResponse.bairro);
                $('#address_street').val(jsonResponse.logradouro);
                $('#address_state').val(jsonResponse.uf);
                $('#address_city').val(jsonResponse.localidade);
                $body.loading('toggle');
            },
            error: function() {

                bootbox.alert('Erro na requisição do CEP, preencha os dados manualmente.')
                $body.loading('toggle');
            }
        });
    });
});