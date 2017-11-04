/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function salvarAcao(caminho, idAcao) {

    var local =$('.locais').map( function(){return $(this).val(); }).get();
    console.log(local);
    var data = $('#data').val();
    var hora = $('#hora').val();
    var detalhes = $('#detalhes').val();
    var selectedDoacoes = [];
    $(".input-list").find("input:checked").each(function (i, ob) {
        selectedDoacoes.push($(ob).val());
    });
    console.debug(selectedDoacoes);
    if (data!="" && hora!=""){
        
    
    var dataString = {
        local: local,
        data: data,
        hora: hora,
        categorias: selectedDoacoes,
        detalhes: detalhes,
        idAcao: idAcao
    };
    console.log(JSON.stringify(dataString));
    $.ajax({
        type: 'post',
        data: JSON.stringify(dataString),
        contentType: 'application/json',
        dataType: 'json',
        url: '' + caminho + 'salvarAcao',
        cache: false,
        processData: false,
        async: false,
        success: function (response) {
            console.log(response);
            alert("Ação registrada com sucesso para o dia " + data + " as " + hora + " em " + local);

        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(errorThrown);

        }

    });
    }else{
        alert("Data e hora não podem ficar em branco.");
         
    }
    return false;
}


function atualizarAcao(caminho, idAcao, array) {
//    var locais;
//   
// $(".locais").each( function () {
//       alert( $(this).val() );
//       alert($(this).attr('name'));
//       if ($(this).attr('name')){
//              var test = ['','Stackoverflow','stackoverflow.com'];
//       }
//     
//
//cString.push( test );
//   });
console.debug(array);
      var local =$('.locais').map( function(){return $(this).val(); }).get();
    console.log(local);
    var data = $('#data').val();
    var hora = $('#hora').val();
    var detalhes = $('#detalhes').val();
    var selectedDoacoes = [];
    $(".input-list").find("input:checked").each(function (i, ob) {
        selectedDoacoes.push($(ob).val());
    });
    console.debug(selectedDoacoes);
    if (data!="" && hora!=""){
        
    
    var dataString = {
        local: local,
        data: data,
        hora: hora,
        categorias: selectedDoacoes,
        detalhes: detalhes,
        idAcao: idAcao
    };
    console.log(JSON.stringify(dataString));
    $.ajax({
        type: 'post',
        data: JSON.stringify(dataString),
        contentType: 'application/json',
        dataType: 'json',
        url: '' + caminho + 'atualizarAcao',
        cache: false,
        processData: false,
        async: false,
        success: function (response) {
            console.log(response);
            alert("Ação registrada com sucesso para o dia " + data + " as " + hora + " em " + local);

        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log(errorThrown);

        }

    });
    }else{
        alert("Data e hora não podem ficar em branco.");
         
    }
    return false;
}
function initialize() {

    var acInputs = document.getElementsByClassName("locais");

    for (var i = 0; i < acInputs.length; i++) {

        var autocomplete = new google.maps.places.Autocomplete(acInputs[i]);
        autocomplete.inputId = acInputs[i].id;

        google.maps.event.addListener(autocomplete, 'place_changed', function () {
          
        });
    }
}
