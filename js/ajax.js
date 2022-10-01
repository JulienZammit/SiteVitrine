// Solution précédente merdique : 
// 1) request est une variable globale => on ne peut pas envoyer deux requetes ajax en meme temps => SOL = closure !
// 2) on ne peut pas proposer de valeurs par défaut pour type, donnees ou traitement 
// => passer un objet en paramètre avec des propriétés optionnelles 
// => ajax(url, {type, data, callback})
// NB : ajax devra pouvoir fonctionner même sans second argument
// 3) la fonction de traitement est trop technique
// => utiliser une fonction de traitement à qui on transmettra la réponse du serveur directement 

function ajax(url,oParams) {
	var oDefaut = {
		type: "POST", 	// ou "POST"
		data: {}, 		// données structurées en JSON 
		callback: function(rep) { console.log(rep); }
		// fonction destinataire de la réponse à intégrer dans la page 
	}; 
	
	// enrichir oParams avec les propriétés par défaut
	if (oParams == undefined) oParams = {}; 
	var oConfig = enrichir(oDefaut,oParams); 
	// => oConfig.type, oConfig.data et oConfig.callback existent 
	
	// structuration des donnees à envoyer à partir des données dans oConfig.data
	// exemple oConfig.data vaut {cle:"val1", cle2:"val2"} 
	// structure visée : cle=val1&cle2=val2&
	var donnees = "";  
	for(prop in oConfig.data) {
		donnees += prop + "=" + oConfig.data[prop] + "&"; 
	}
	console.log("Donnees envoyees : " + donnees);
	
	var request = new XMLHttpRequest(); // variable locale 
	// il faut l'enfermer dans le scope d'une fonction qui traitera la reponse 
	// cette fonction récupérera la réponse du serveur 
	// et appelera la fonction callback choisie par le développeur : oConfig.callback
	// à qui on fournira la réponse du serveur 
	
	var tr = function() {
		// il y a dans le scope de cette fonction la référence vers request
		// il y a aussi oConfig 
		// il faut l'appeler à chaque fois que... 
		if (request.readyState == 4) {
			if (request.status == 200) {
				console.log("Reponse recue : " + request.responseText);
				// la reponse est dans request.responseText;
				oConfig.callback(request.responseText);
			}
		}
	}; 

	if (oConfig.type=='GET') {
		request.open("GET", url+"?"+donnees, true); 
		// donnees doit être au format querystring
		donnees=null;
	}
	else {
		request.open("POST", url, true);
		request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	}

	request.onreadystatechange = tr;
	request.send(donnees);
}

 
 function enrichir(oStructure,oModif) {
 	var aux = {}; 
 	for(prop in oStructure) {
 		// si prop est modifiée dans oModif, on utilise la valeur de oModif
 		if (oModif[prop] != undefined) aux[prop] = oModif[prop]; 
 		else aux[prop] = oStructure[prop];
 	}
 	return aux; 
 }
 
console.log("Chargement librairie ajax : ajax(url,{type,data,callback}");




















