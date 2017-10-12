/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function esquecerSenha(caminho) {

    var email = $('#email').val();
    var dataString = {
        email: email
    };
    console.log(JSON.stringify(dataString));
    $.ajax({
        type: 'post',
        data: JSON.stringify(dataString),
        contentType: 'application/json',
        dataType: 'json',
        url: '' + caminho + 'esqueceuSenha',
        cache: false,
        processData: false,
        async: false,
        success: function (response) {
            console.log(response);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(errorThrown);
        }

    });
    return false;
}
function primeiroacesso(caminho) {
    alert("teste primeiro acesso");
    var email = $('#emailPrimeiro').val();
    var codigo = $('#codigo').val();
    var dataString = {
        email: email,
        codigo: codigo
    };
    console.log(JSON.stringify(dataString));
    $.ajax({
        type: 'post',
        data: JSON.stringify(dataString),
        contentType: 'application/json',
        dataType: 'json',
        url: '' + caminho + 'primeiroacesso',
        cache: false,
        processData: false,
        async: false,
        success: function (response) {
            console.log(response);
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(errorThrown);
        }

    });
    return false;
}