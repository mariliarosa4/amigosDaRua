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
            alert("Email enviado com sucesso!");//melhorar a forma de exibir esse aviso
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(errorThrown);
        }

    });
    return false;
}
function primeiroacesso(caminho) {
    alert("teste primeiro acesso");
    alert(caminho);
    var email = $('#emailPrimeiro').val().trim();
    var codigo = $('#codigo').val().trim();
    var dataString = {
        email:email,
        codigo:codigo
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
            if (response.sucesso) {
                alert('Primeiro acesso realizado com sucesso! Vamos cadastrar sua senha.');
                document.getElementById("novaSenha").style.display="block";
                document.getElementById("novaSenha").style.visibility="visible";

            }

        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(errorThrown);
        }

    });

}

function novaSenha(caminho, email) {

    var senha = $('#senha').val();
    var confirmaSenha = $('#confirmarSenha').val();
    if (senha == confirmaSenha) {
        var dataString = {
            senha: senha,
            confirmaSenha: confirmaSenha,
            email: email
        };
        console.log(JSON.stringify(dataString));
        $.ajax({
            type: 'post',
            data: JSON.stringify(dataString),
            contentType: 'application/json',
            dataType: 'json',
            url: '' + caminho + 'novaSenha',
            cache: false,
            processData: false,
            async: false,
            success: function (response) {
                console.log(response);
                //melhorar a forma de exibir esse aviso
                if (window.confirm('Senha atualizada com sucesso! Va para a pagina de login.'))
                {

                    window.location = caminho + 'login';
                } else
                {
                    die();
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
                alert("Falha na atualização da senha.");//melhorar a forma de exibir esse aviso
            }

        });
    } else {
        alert("senhas nao conferem");//melhorar a forma de exibir isso
    }
    return false;
}
