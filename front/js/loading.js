'use strict';



let login ='';
let clubco ='';
console.log(login);
while(login.length <14){
	
	
		

	login =prompt('Veuillez entrez votre mail pour authentification');
	
}
ajaxRequest('GET', 'http://prj-cir2-web-api.monposte/request.php/user/?mail='+login, loadUser);
//let clubco =login =prompt('Veuillez entrez votre club ');


function loadUser(user){

	
	var emplacement = "";
	emplacement += displayUser(user['mail'], user['club']);
	$('#user').attr('mail', user['mail']);
	$('#user').attr('clubco', user['club']);
	$('#user').html(emplacement);
	clubco=document.getElementById('clubco');
	
	clubco = clubco.innerText || clubco.textContent;
	// console.log(clubco);
	// clubco = clubco.replace(' ', '_');
	// console.log(clubco);
	ajaxRequest('GET', 'http://prj-cir2-web-api.monposte/request.php/participants/?id=1&club='+clubco, loadOnList);
}


function displayUser(mail, club){
    var cycliste = "<div class='text-right'>" +
				"<div class='mailco'>" +mail + "</div><div id='clubco' value="+club+">"+ club+"</div></div>"
	return cycliste;
}

ajaxRequest('GET', 'http://prj-cir2-web-api.monposte/request.php/cycliste/?mail='+login, loadCyclists);

function loadCyclists(cyclistes){
	// document.getElementById("cyclistes").style.display = 'block';
	var id=0;
	var emplacement = '<br><table class="table table-dark">';
	emplacement +='<thead><tr><th scopz="col">ID</th><th scope="col">NOM</th><th scope="col">PR\&#201NOM</th><th scope="col">NUM_LICENCE</th><th scope="col">CLUB</th><th scope="col">MODIF</th></tr></thead>';
	//console.log(cyclistes);
	cyclistes.forEach( function(cycliste) {
		emplacement += displayCycliste(cycliste['nom'], cycliste['prenom'],cycliste['num_licence'], cycliste['club'], id);
		id ++;
	});
	emplacement += "</table>";
	$('#cycliste-list').html(emplacement);
}

//Renvoie une div pour chaque photo
function displayCycliste(nom, prenom,num_licence, club, id){
	
    var cycliste = "<tr><td>"+ id +"</td><td>"+
				nom + "</td><td> " + prenom + "</td><td> " + num_licence + "</td><td> " + club + "</td><td>" + 
				"<button type='button' class='btn btn-warning float-right mod' value='id'><i class='fa fa-edit'></i></button>"+
				"<button type='button' class='btn btn-warning float-left del' ><i class='fa fa-trash'></i></button></td></tr>";
	
	return cycliste;
}



function loadRaces(races){
	var emplacement = '<br><table class="table table-dark">';
	emplacement +='<thead><tr><th scope="col">ID</th><th scope="col">NOM</th><th scope="col">DATE</th><th scope="col">NB_TOUR</th><th scope="col">DISTANCE</th><th scope="col">NB_COUREUR</th><th scope="col">LONGUEUR</th><th scope="col">CLUB</th><th scope="col">MODIF</th></tr></thead>';
	//console.log(cyclistes);
	races.forEach( function(course) {
		emplacement += displayRaces(course['id'], course['libelle'],course['date'], course['nb_tour'],course['distance'],course['nb_coureur'], course['longueur_tour'],course['club']);
	});
	emplacement += "</table>";
	$('#courses-list').html(emplacement);
}

function displayRaces(id, libelle, date, nb_tour, distance, nb_coureur, longueur_tour,club){
    var cycliste = "<tr><td>" +
				id + "</td><td> " + libelle + "</td><td> " + date + "</td><td> " + nb_tour + "</td><td> " + distance + "</td><td> " + nb_coureur + "</td><td> " + longueur_tour + "</td><td> " + club + "</td>"+
				"<td><button type='button' class='btn btn-warning float-right mod' ><i class='fa fa-edit'></i></button></td></tr>";
	return cycliste;
}

ajaxRequest('GET', 'http://prj-cir2-web-api.monposte/request.php/courses/?mail='+login, loadRaces);



$('#courses-add').on('submit', (event) =>
{
  event.preventDefault();
  ajaxRequest('POST', 'http://prj-cir2-web-api.monposte/request.php/courses/', () =>
  {
    ajaxRequest('GET', 'http://prj-cir2-web-api.monposte/request.php/courses/', loadRaces);
  }, '?login=' + login + '&libelle=' + $('#libelle').val() + '&date=' + $('#date').val()+ '&nb_tour=' + $('#nb_tour').val() + '&distance=' + $('#distance').val() + '&nb_coureur=' + $('#nb_coureur').val() + '&longueur_tour=' + $('#longueur_tour').val() + '&club=' + clubco);

  
});

// $('#course-add').on('submit', '.new', function(){	
// 	let libelle = document.getElementById('libelle').value;
// 	let date = document.getElementById('date').value;
// 	let nb_tour = document.getElementById('nb_tour').value;
// 	let distance = document.getElementById('distance').value;
// 	let nb_coureur = document.getElementById('nb_coureur').value;
// 	let longueur_tour = document.getElementById('longueur_tour').value;
// 	let club = document.getElementById('club').value;
// 	console.log(libelle);
// 	let path = 'http://prj-cir2-web-api.monposte/request.php/cycliste/?login='+login+ '&libelle=' + libelle +'&date=' + date + '&nb_tour=' + nb_tour + '&distance=' + distance + '&nb_coureur=' + nb_coureur + '&logueur_tour=' + longueur_tour + '&club=' + club;
// 	ajaxRequest('PUT', path, function(){
// 		ajaxRequest('GET', 'http://prj-cir2-web-api.monposte/request.php/cycliste/', loadRaces);
// 	});
// });





function loadOnList(participants){
	// document.getElementById("cyclistes").style.display = 'block';
	// var clubco=document.getElementById('clubco');
	// clubco = clubco.innerText || clubco.textContent;
	//console.log(clubco);
	var emplacement = '<br><table class="table table-dark">';
	emplacement +='<thead><tr><th scopz="col">ID COURSES</th><th scope="col">NOM</th><th scope="col">PR\&#201NOM</th><th scope="col">POINTS</th><th scope="col">TEMPS</th><th scope="col">MODIF</th></tr></thead>';
	console.log(participants);
	participants.forEach( function(cycliste) {
		emplacement += displayOnlist(cycliste['id'], cycliste['nom'],cycliste['prenom'], cycliste['point'], cycliste['temps']);

	});
	emplacement += "</table>";
	$('#participant-list').html(emplacement);
}

function displayOnlist(id, nom, prenom,point, temps){
	
    var cycliste = "<tr><td>"+id+"</td><td>"+
				nom + "</td><td> " + prenom + "</td><td> " + point + "</td><td> " + temps + "</td><td>" + 
				"<button type='button' class='btn btn-warning float-right mod' value='id'><i class='fa fa-edit'></i></button>"+
				"<button type='button' class='btn btn-warning float-left del' ><i class='fa fa-trash'></i></button></td></tr>";
	
	return cycliste;
}



$('#participant-add').on('submit', (event) =>
{
  event.preventDefault();
  ajaxRequest('POST', 'http://prj-cir2-web-api.monposte/request.php/participants/', () =>
  {
    ajaxRequest('GET', 'http://prj-cir2-web-api.monposte/request.php/participants/?id=' + $('#id_course').val() + '&club=' + clubco, loadOnList);
  }, 'id=' + $('#id_course').val() + '&mail=' + $('#mail').val()+ '&dossart=' + $('#dossart').val() + '&club=' + clubco);
});