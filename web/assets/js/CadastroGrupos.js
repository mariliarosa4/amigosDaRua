/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function validarEmail(caminho) {

    var email = $('#email').val();

    var dataString = {
        emailCadastro: email,
    };
    console.log(JSON.stringify(dataString));
    $.ajax({
        type: 'post',
        data: JSON.stringify(dataString),
        contentType: 'application/json',
        dataType: 'json',
        url: '' + caminho + 'validarEmail',
        cache: false,
        processData: false,
        async: false,
        success: function (response) {
            console.log(response);
          if(response.existe){
              alert("email já cadastrado");
          }else{
              alert("email valido");
          }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(errorThrown);

        }

    });

    return false;
}
