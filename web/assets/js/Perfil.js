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


function atualizarSenha(caminho) {

    var senha = $('#senha').val();
    var novaSenha = $('#novaSenha').val();
    var confirmarSenha = $('#confirmarSenha').val();



    if (senha != "" && novaSenha != "" && confirmarSenha != "") {
        if (novaSenha == confirmarSenha) {
            var hashSenha = $.sha256(senha);
            var hashNovaSenha = $.sha256(novaSenha);
            var hashConfirmarSenha = $.sha256(confirmarSenha);
            console.log(hashSenha);
            var dataString = {
                S: hashSenha,
                NS: hashNovaSenha,
                CS: hashConfirmarSenha
            };

            console.log(JSON.stringify(dataString));
            $.ajax({
                type: 'post',
                data: JSON.stringify(dataString),
                contentType: 'application/json',
                dataType: 'json',
                url: '' + caminho + 'alterarSenha',
                cache: false,
                processData: false,
                async: false,
                success: function (response) {
                    console.log(response);
                    if (response.sucesso) {
                        alert("Senha alterada com sucesso!");
                    }
                    if (response.senhaAtualIncorreta) {
                        alert("Senha atual incorreta! Tente novamente.");
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(errorThrown);

                }

            });
        } else {
            alert("Senhas não conferem!");
        }
    } else {
        alert("Todos os campos de senhas devem ser preenchidos!");

    }
    return false;

}