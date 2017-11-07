/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$("#EmailResponsavel").click(function () {
    $('#validarEmailCarregando').toggle();

});
function validarEmail(caminho) {


    var emailResponsavel = $('#EmailResponsavel').val();

    var dataString = {
        "emailCadastro": emailResponsavel
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
                }, 10);
            }
            $('#validarEmailCarregando').toggle();

        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(errorThrown);

        }

    });

    return false;
}

function cadastrarGrupo(caminho) {

    $('#cadastroCompleto').toggle();
    var nomeResponsavel = $('#NomeResponsavel').val();
    var telefoneResponsavel = $('#TelResponsavel').val();
    var emailResponsavel = $('#EmailResponsavel').val();
    var nomeGrupo = $('#NomeGrupo').val();
    var data = $('#Nascimento').val();

    var integrantes = $('#Integrantes').val();
    if (nomeResponsavel != "" && telefoneResponsavel != "" && emailResponsavel != "" && nomeGrupo != "" && data != "") {
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
            success: function (response) {
                console.log(response);
                if (response.sucesso) {
                    alert("Grupo cadastrado com sucesso. O codigo de acesso foi enviado por email para o usuario.");
                } else {
                    alert("Falha no cadastro. Tente novamente.");
                }
                $('#cadastroCompleto').toggle();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
                alert("Falha no cadastro. Tente novamente.");
                $('#cadastroCompleto').toggle();
            }

        });
    } else {
        alert("Campos obrigatórios em branco.");
        $('#cadastroCompleto').toggle();
    }
    return false;
}
