function obtiene_http_request()
{
    var req = false;
    try
    {
        req = new XMLHttpRequest(); /* p.e. Firefox */
    } catch (err1)
    {
        try
        {
            req = new ActiveXObject("Msxml2.XMLHTTP");
            /* algunas versiones IE */
        } catch (err2)
        {
            try
            {
                req = new ActiveXObject("Microsoft.XMLHTTP");
                /* algunas versiones IE */
            } catch (err3)
            {
                req = false;
            }
        }
    }
    return req;
}
var miPeticion = obtiene_http_request();
//***************************************************************************************
function from(id, ide, url) {
    var mi_aleatorio = parseInt(Math.random() * 99999999);//para que no guarde la p�gina en el cach�...
    var vinculo = url + "?id=" + id + "&rand=" + mi_aleatorio;
    //alert(vinculo);
    miPeticion.open("GET", vinculo, true);//ponemos true para que la petici�n sea asincr�nica
    miPeticion.onreadystatechange = miPeticion.onreadystatechange = function () {
        if (miPeticion.readyState == 4) {
            //alert(miPeticion.readyState);
            if (miPeticion.status == 200)
            {
                //alert(miPeticion.status);
                //var http=miPeticion.responseXML;
                var http = miPeticion.responseText;
                document.getElementById(ide).innerHTML = http;

            }
        } 
//        else {
//            document.getElementById(ide).innerHTML = "<img src='Recursos/imagenes/loading.gif' title='cargando...' />";
//
//        }
    }
    miPeticion.send(null);
}

function from2(id, ide, url, variable2) {
    var mi_aleatorio = parseInt(Math.random() * 99999999);//para que no guarde la p�gina en el cach�...
    var vinculo = url + "?id=" + id + "&variable=" + variable2 + "&rand=" + mi_aleatorio;
    //alert(vinculo);
    miPeticion.open("GET", vinculo, true);//ponemos true para que la petici�n sea asincr�nica
    miPeticion.onreadystatechange = miPeticion.onreadystatechange = function () {
        if (miPeticion.readyState == 4) {
            //alert(miPeticion.readyState);
            if (miPeticion.status == 200)
            {
                //alert(miPeticion.status);
                //var http=miPeticion.responseXML;
                var http = miPeticion.responseText;
                document.getElementById(ide).innerHTML = http;

            }
        } 
//        else {
//            document.getElementById(ide).innerHTML = "<img src='Recursos/imagenes/loading.gif' title='cargando...' />";
//
//        }
    }
    miPeticion.send(null);
}

function from3(area, ide, url, cargo) {
    if(document.getElementById("selArea").value != "0" && document.getElementById("selCargo").value != "0"){
        var mi_aleatorio = parseInt(Math.random() * 99999999);//para que no guarde la pagina en el cache...
        var vinculo = url + "?area=" + area + "&cargo=" + cargo + "&rand=" + mi_aleatorio;
        //alert(vinculo);
        miPeticion.open("GET", vinculo, true);//ponemos true para que la petici�n sea asincr�nica
        miPeticion.onreadystatechange = miPeticion.onreadystatechange = function () {
            if (miPeticion.readyState == 4) {
                //alert(miPeticion.readyState);
                if (miPeticion.status == 200)
                {
                    //alert(miPeticion.status);
                    //var http=miPeticion.responseXML;
                    var http = miPeticion.responseText;
                    document.getElementById(ide).innerHTML = http;

                }
            } 
    //        else {
    //            document.getElementById(ide).innerHTML = "<img src='Recursos/imagenes/loading.gif' title='cargando...' />";
    //
    //        }
        }
        miPeticion.send(null);
    }else{
        alert("Elija un área y un cargo");
    }
}

function from4(id, ide, url, variable1, variable2) {
    var mi_aleatorio = parseInt(Math.random() * 99999999);//para que no guarde la p�gina en el cach�...
    var vinculo = url + "?id=" + id + "&variable=" + variable1 + "&variable2=" + variable2 + "&rand=" + mi_aleatorio;
    //alert(vinculo);
    miPeticion.open("GET", vinculo, true);//ponemos true para que la petici�n sea asincr�nica
    miPeticion.onreadystatechange = miPeticion.onreadystatechange = function () {
        if (miPeticion.readyState == 4) {
            //alert(miPeticion.readyState);
            if (miPeticion.status == 200)
            {
                //alert(miPeticion.status);
                //var http=miPeticion.responseXML;
                var http = miPeticion.responseText;
                document.getElementById(ide).innerHTML = http;

            }
        } 
//        else {
//            document.getElementById(ide).innerHTML = "<img src='Recursos/imagenes/loading.gif' title='cargando...' />";
//
//        }
    }
    miPeticion.send(null);
}
//************************************************************************************************
function limpiar()
{
    document.form.reset();

}