'use strict';

//chargement des cyclistes dans le cyclists et organisation en div grace à fillCyclist
function loadCyclists(cyclists){
    var club = "";
    cyclists.forEach(function(element){
		club += fillcyclist(element['mail'], element['nom'],element['prenom'],
		elment['num_licence'],element['date_naissance'],element['valide'],
		element['club'],element['code_insee'],element['categorie'],
		element['categorie_categorie_valeur']);
    });
    
    $('#cyclists').html(club);
    
}

//Renvoie une div pour chaque cyclist
function fillcyclist(mail, nom, prenom, num_licence, date_naissance, valide, club, code_insee, categorie, categorie_categorie_valeur){
	var cyclist_card = "<div class='col-xs-2 col-md-2'><a href='#'><p>mail :"+mail+"</p>"+
	"<p>nom :"+nom+"</p>"+"<p>prenom :"+prenom+"</p>"+"<p>numéro de licence :"+num_licence+"</p>"+
	"<p>date de naissance :"+date_naissance+"</p>"+"<p>inscription valide :"+valide+"</p>"+
	"<p>Club :"+club+"</p>"+"<p>Code INSEE :"+code_insee+"</p>"+"<p>categorie :"+categorie+
	" ("+categorie_categorie_valeur+")</p>"+"</a></div>";
    
    return cyclist_card;
}

/*//chargement de la photo dans photo et organisation en div grace à fillMaxi
function LoadCyclist(cyclist){
    ajaxRequest('GET', 'php/request.php/comments/?id='+photo['id'], loadComments);
    var emplacement = "";
    emplacement += fillMaxi(photo['id'], photo['src'], photo['title']);
    
    $('#photo').attr('photoid', photo['id']);
    $('#photo').html(emplacement);

    
}

//Renvoie une div pour la photo en grand
function fillMaxi(id, path, title) {
    var miniature = "<div class='col-xs-12 col-md-12'><a href='#'><h4>"+title+"</h4><img value="+id+" src = "+path+" class='img-thumbnail' ></a></div>";
    
    return miniature;
}*/

//Renvoie une div pour chaque commentaire avec des boutons pour supprimer et modifier
//A NOTER j'ai essayé de l'appeler displayComment au début mais ça ne marchait pas 
function fillComment(user, texte, id){
    var comment = "<div class='panel-body'>" +
				user + ": " + texte +
				"<button type='button' class='btn btn-light float-right mod'"+ 
				"value= " + id + "><i class='fa fa-edit'></i></button>"+
				"<button type='button' class='btn btn-light float-right del'"+
				"value= " + id + "><i class='fa fa-trash'></i></button></div><br>";
	return comment;
}

//charge les commmentaires de la photo choisie
function loadComments(elements){
    document.getElementById("comments").style.display = 'block';
	var emplacement = '<div class="panel panel-default"><br>';
	elements.forEach( function(comment) {
		emplacement += fillComment(comment['userLogin'], comment['comment'], comment['id']);
	});
	emplacement += "</div>";
	$('#comment-list').html(emplacement);
}




ajaxRequest('GET','php/request.php/photos/', loadPhotos);

//Attente de l'évènement pour cliquer sur une image
$('#thumbnail').on('click', 'img', function() {
    var id = $(event.target).attr('value');
    console.log(id);
    
    ajaxRequest('GET','php/request.php/photos/'+id, LoadPhoto);
   
});



//Attente de l'évènement pour modifier un commentaire
$('#comment-list').on('click', '.mod', () => {
	ajaxRequest('PUT', 'php/request.php/comments/' + 
		$(event.target).closest('.mod').attr('value'), () => {
			ajaxRequest('GET', 'php/request.php/comments/?id='+$('#photo').attr('photoid'), loadComments);
		}, 'comment=' + prompt('Nouveau commentaire: '));
});

//Attente de l'évènement pour supprimer un commentaire
$('#comment-list').on('click', '.del', () => {
	ajaxRequest('DELETE', 'php/request.php/comments/' + 
		$(event.target).closest('.del').attr('value'), () => {
			ajaxRequest('GET', 'php/request.php/comments/?id='+$('#photo').attr('photoid'), loadComments);
		});
});

//Attente de l'évènement pour poster un commentaire
$('#comments-add').on('submit', (event) => {
	event.preventDefault();
	ajaxRequest('POST', 'php/request.php/comments/', () => {
		ajaxRequest('GET', 'php/request.php/comments/?id='+ $('#photo').attr('photoid'), loadComments);
	}, 'id=' + $('#photo').attr('photoid') + '&comment=' + $('#textComment').val());
	$('#textComment').val('');
});