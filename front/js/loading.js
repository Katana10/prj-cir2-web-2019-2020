'use strict';

ajaxRequest('GET', 'http://prj-cir2-web-api.monposte/request.php/cycliste/', DisplayCyclists);
function loadCyclists(cyclistes){
	// document.getElementById("cyclistes").style.display = 'block';
	
	var emplacement = '<br><table class="table table-dark">';
	emplacement +='<thead><tr><th scope="col">NOM</th><th scope="col">PR\&#201NOM</th><th scope="col">NUM_LICENCE</th><th scope="col">CLUB</th></tr></thead>';
	console.log(cyclistes);
	cyclistes.forEach( function(cycliste) {
		emplacement += displayCycliste(cycliste['nom'], cycliste['prenom'],cycliste['num_licence'], cycliste['club']);
	});
	emplacement += "</table>";
	$('#cycliste-list').html(emplacement);
}

//Renvoie une div pour chaque photo
function displayCycliste(nom, prenom,num_licence, club){
    var cycliste = "<tr><td>" +
				nom + "</td><td> " + prenom + "</td><td> " + num_licence + "</td><td> " + club + "</td>"
				"<td><button type='button' class='btn btn-light float-right mod'"+ 
				"value= " + club + "><i class='fa fa-edit'></i></button>"+
				"<td></tr>";
	return cycliste;
}
