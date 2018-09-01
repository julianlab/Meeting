/*window.onload = function(){
    document.getElementById('municipio_select').addEventListener('change',function(){
        //console.log('cambia');
        var provincia = document.getElementById('provincia_select').value;
        var municipios = '';
        $.ajax({
            method: "POST",
            data: provincia,
            url: "{{ path('ajax_municipios') }}",
            dataType: 'json',
            success: function(data){
                //console.log('entra');
                municipios = JSON.parse(data.municipios);
                putMunicipios(municipios);
            }
        });
    });
    document.getElementById('comunidad_select').addEventListener('change',function(){

         Este método va a hacer una llamada ajax de un PHP que recopile
         los datos para rellenar el siguiente select.
         Para ello:
         ·Llama con ajax a un php y le pasa por parametros la comunidad.
         ·Recibe un json con las provincias.
         ·Inserta las provincias en el select

        console.log('catrfgbhmbia');
        var comunidad = document.getElementById('comunidad_select').value;
        var provincias = '';
        $.ajax({
            method: "POST",
            data: comunidad,
            url: "{{ path('ajax_provincias') }}",
            dataType: 'json',
            success: function(data){
                provincias = JSON.parse(data.provincias);
                putProvincias(provincias);
            }
        });
    });
}
function putProvincias(provincias){
    $('#provincia_select').find('option').remove();
    $.each(provincias, function (i, item) {
        $('#provincia_select').append($('<option>', {
            value: item.id,
            text : item.provincia
        }));
    });
}
function putMunicipios(municipios){
    //$('#municipio_select').find('option').remove();
    //console.log('entra');
    $.each(municipios, function (i, item) {
        $('#municipio_select').append($('<option>', {
            value: item.id,
            text : item.comunidad
        }));
    });
}*/