'use strict';

//chargement des cyclistes dans le cyclists et organisation en div grace à fillCyclist
function loadCyclists(cyclists){
    var club = "";
    cyclists.forEach(function(element){
		club += fillCyclists(element['mail'], element['nom'],element['prenom'],
		elment['num_licence'],element['date_naissance'],element['valide'],
		element['club'],element['code_insee'],element['categorie'],
		element['categorie_categorie_valeur']);
    });
    
    $('#cyclists').html(club);
    
}

//Renvoie une div pour chaque cyclist
function fillCyclists(mail, nom, prenom, num_licence, date_naissance, valide, club, code_insee, categorie, categorie_categorie_valeur){
	var cyclist_card = "<div class='col-xs-2 col-md-2'><a href='#'><div value="+mail+"><p>mail :"+mail+"</p>"+
	"<p>nom :"+nom+"</p>"+"<p>prenom :"+prenom+"</p>"+"<p>numéro de licence :"+num_licence+"</p>"+
	"<p>date de naissance :"+date_naissance+"</p>"+"<p>inscription valide :"+valide+"</p>"+
	"<p>Club :"+club+"</p>"+"<p>Code INSEE :"+code_insee+"</p>"+"<p>categorie :"+categorie+
	" ("+categorie_categorie_valeur+")</p>"+"</div></a></div>";
    
    return cyclist_card;
}

function loadCyclist(cyclist){
    var card = "";
	card = fillCyclists(element['mail'], element['nom'],element['prenom'],
	elment['num_licence'],element['date_naissance'],element['valide'],
	element['club'],element['code_insee'],element['categorie'],
	element['categorie_categorie_valeur']);
    
    $('#cyclist').html(card);
    
}

//Renvoie une div pour le cycliste sélectionné avec des boutons pour modifier 
function fillCyclist(mail, nom, prenom, num_licence, date_naissance, valide, club, code_insee, categorie, categorie_categorie_valeur){
    var cyclist_card = "<div class='col-xs-2 col-md-2'><a href='#'><p>mail :"+mail+"</p>"+
	"<p>nom :"+nom+"</p>"+"<p>prenom :"+prenom+"</p>"+"<p>numéro de licence :"+num_licence+"</p>"+
	"<p>date de naissance :"+date_naissance+"</p>"+"<p>inscription valide :"+valide+"</p>"+
	"<p>Club :"+club+"</p>"+"<p>Code INSEE :"+code_insee+"</p>"+"<p>categorie :"+categorie+
	" ("+categorie_categorie_valeur+")</p>"+"<button type='button' class='btn btn-light float-right mod'"+
	"value= " + mail + "><i class='fa fa-edit'></i></button>"+"</a></div>";
    
    return cyclist_card;
				
}

//Method Put
$('#cyclist-card').off('click').on('click', '.mod', () =>{
	ajaxRequest('PUT', 'http://prj-cir2-web-api.monposte/request.php/cyclistes/' + $(event.target).closest('.mod').attr('value'), () =>{
		ajaxRequest('GET', 'http://prj-cir2-web-api.monposte/request.php/cyclistes/', loadCyclists);
	}, 'modificate=' + prompt('Modification du champ :'));
});

//Attente de l'évènement pour cliquer sur une image
$('#cyclistes').on('click', 'img', function() {
    var id = $(event.target).attr('value');
    console.log(id);
    
    ajaxRequest('GET','http://prj-cir2-web-api.monposte/request.php/cyclistes/'+id, loadCyclist);
   
});*/

ajaxRequest('GET', 'http://prj-cir2-web-api.monposte/request.php/cycliste/', loadCyclists);

//Attente de l'évènement pour modifier un commentaire
$('#comment-list').on('click', '.mod', () => {
	ajaxRequest('PUT', 'php/request.php/comments/' + 
		$(event.target).closest('.mod').attr('value'), () => {
			ajaxRequest('GET', 'php/request.php/comments/?id='+$('#photo').attr('photoid'), loadComments);
		}, 'comment=' + prompt('Nouveau commentaire: '));
});

