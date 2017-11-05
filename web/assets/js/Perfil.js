/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function salvarEdicaoPerfil(caminho) {

    var nomeResponsavel = $('#NomeResponsavel').val();
    var telefoneResponsavel = $('#TelResponsavel').val();
    var dataNascimentoResponsavel = $('#Nascimento').val();
    var integrantesGrupo = $('#Integrantes').val();
    var nomeGrupo = $('#NomeGrupo').val();
    if (nomeResponsavel != "" && telefoneResponsavel != "" && dataNascimentoResponsavel != "" && nomeGrupo != "") {

        var dataString = {
            nomeResponsavel: nomeResponsavel,
            telefoneResponsavel: telefoneResponsavel,
            dataNascimentoResponsavel: dataNascimentoResponsavel,
            integrantesGrupo: integrantesGrupo,
            nomeGrupo: nomeGrupo
        };

        console.log(JSON.stringify(dataString));
        $.ajax({
            type: 'post',
            data: JSON.stringify(dataString),
            contentType: 'application/json',
            dataType: 'json',
            url: '' + caminho + 'salvarEdicaoPerfil',
            cache: false,
            processData: false,
            async: false,
            success: function (response) {
                console.log(response);
                if (response.sucesso) {
                    alert("Perfil alterado com sucesso!");
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);

            }

        });
    } else {
        alert("Campos obrigatórios em branco");

    }
    return false;
}

