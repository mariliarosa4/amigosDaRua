/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function aplicarFiltro(caminho) {

    var inicio = $('#pickerDtInicio').val();
    var fim = $('#pickerDtFim').val();

    if (inicio != "" && fim != "") {

        window.location.href = caminho + 'filtragem/' + inicio + '/' + fim + '';
    } else {
        alert("Escolha um periodo");

    }
    return false;
}
