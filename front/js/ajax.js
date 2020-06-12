function ajaxRequest(type, url, callback, data = null) {
    let xhr = new XMLHttpRequest();
    if (type == 'GET' && data != null)
        url += '?' + data;
    //console.log(url);
    xhr.open(type, url);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    console.log(url);
    console.log(data);

    xhr.onload = () => {
        //console.log(xhr.responseText);
        switch(xhr.status) {
            case 200:
            case 201:
                if(xhr.responseText.length != 0) callback(JSON.parse(xhr.responseText));
                break;
            default: 
                httpErrors(xhr.status);
        }
    };
    xhr.send(data);
}


function httpErrors(errorCode){
    let messages ={
        400: 'Requête incorrecte',
        401: 'Authentifiez-vous',
        403: 'Accès Refusé',
        404: 'Page non trouvé',
        500: 'Erreur interne du serveur',
        503: 'Service indisponible'
    };
    // $('#errors').html('<i class="fa fa-exclamation-circle"></i><strong>' +messages[errorCode]+'</strong>');
    // $('#errors').show();
    console.log(errorCode+ ':' + messages[errorCode]);
}



