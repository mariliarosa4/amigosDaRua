/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function validarEmail(caminho) {

    var emailResponsavel = $('#EmailResponsavel').val();

    var dataString = {
        emailCadastro: emailResponsavel
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

            if (response.existe) {
                alert("email já cadastrado");
                setTimeout(function () {
                    document.getElementById("EmailResponsavel").focus();
                }, 1);
            } 

        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(errorThrown);

        }

    });

    return false;
}

function cadastrarGrupo(caminho) {

    var nomeResponsavel = $('#NomeResponsavel').val();
    var telefoneResponsavel = $('#TelResponsavel').val();
    var emailResponsavel = $('#EmailResponsavel').val();
    var nomeGrupo = $('#NomeGrupo').val();
    var data = $('#Nascimento').val();

    var integrantes = $('#Integrantes').val();

    var dataString = {"emailResponsavel": emailResponsavel,
        "nomeResponsavel": nomeResponsavel,
        "dataNascimentoResponsavel": data,
        "nomeGrupo": nomeGrupo,
        "telefoneResponsavel": telefoneResponsavel,
        "numeroIntegrantes": integrantes
    };
    console.log(JSON.stringify(dataString));
    $.ajax({
        type: 'post',
        data: JSON.stringify(dataString),
        contentType: 'application/json',
        dataType: 'json',
        url: '' + caminho + 'cadastrarGrupo',
        cache: false,
        processData: false,
        async: false,
        success: function (response) {
            console.log(response);
            if (response.sucesso) {
                alert("Grupo cadastrado com sucesso. O codigo de acesso foi enviado por email para o usuario.");
            } else {
                alert("Falha no cadastro. Tente novamente.");
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(errorThrown);

        }

    });

    return false;
}
