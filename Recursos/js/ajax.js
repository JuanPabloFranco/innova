var http = createRequestObject();
var objectId = '';


function createRequestObject(htmlObjectId) {
    var obj;
    var browser = navigator.appName;

    objectId = htmlObjectId;

    if (browser == "Microsoft Internet Explorer") {
        obj = new ActiveXObject("Microsoft.XMLHTTP");
    } else {
        obj = new XMLHttpRequest();
    }
    return obj;
}

function sendReq(serverFileName, variableNames, variableValues) {
    var paramString = '';

    variableNames = variableNames.split(',');
    variableValues = variableValues.split(',');

    for (i = 0; i < variableNames.length; i++) {
        paramString += variableNames[i] + '=' + variableValues[i] + '&';
    }
    paramString = paramString.substring(0, (paramString.length - 1));

    if (paramString.length == 0) {
        http.open('get', serverFileName);
    } else {
        http.open('get', serverFileName + '?' + paramString);
    }
    http.onreadystatechange = handleResponse;
    http.send(null);
}

function handleResponse() {

    if (http.readyState == 4) {
        responseText = http.responseText;
        document.getElementById(objectId).innerHTML = responseText;
    }
}

function load(str)
{
    var xmlhttp;

    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else
    {// code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function ()
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
        {
            document.getElementById("myDiv").innerHTML = xmlhttp.responseText;
        }
    }
    xmlhttp.open("POST", "proc.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send("q=" + str);
}