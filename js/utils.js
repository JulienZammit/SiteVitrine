function trace(s) {
	window.console && console.log(s);
}

function mkDebug_v2(max_v2){
	var compteur_v2 = 0;
	var fn = function(s,resetcompteur) {
		// scope de la fonction fn : 
		// variables globales
		// variables locales de mkDebug_v2
		// max_v2, compteur_v2 et fn 
		// variables locales de fn : s 
		
		if (resetcompteur != undefined) {
			compteur_v2 = 0; 
			return; 
		}
		
		if (s == undefined) {
			trace(compteur_v2); 
			return;
		}
		if (compteur_v2<max_v2) {
			trace(s); 
			compteur_v2++;
		}
	};
	return fn; 
}
var debug = mkDebug_v2(5); 

function mkDebug_v3(max_v3){
	var compteur_v3 = 0;
	
	return {
			print: function(s) {
				if (compteur_v3<max_v3) {
					trace(s); 
					compteur_v3++;
				}
			}, 
			getCompteur : function() {return compteur_v3; },
			setCompteur : function(v) {compteur_v3=v; },
			getMax : function() {return max_v3; },
			setMax : function(v) {max_v3=v; },
		};  
}

var oDebug = mkDebug_v3(5);

function show(refOrId,display) {
	// affiche l'élément dont la référence ou l'id est fourni
	// le paramètre display doit valoir block par défaut


	if ((typeof refOrId) == "string") {
		refOrId = document.getElementById(refOrId);
	}
	
	if (display == undefined) display = "block";
	
	refOrId.style.display = display; 
}

function hide(refOrId) {
	// cache l'élément dont la référence ou l'id est fourni
	if ((typeof refOrId) == "string") {
		refOrId = document.getElementById(refOrId);
	}
	
	refOrId.style.display = "none";
	
}

function html(refOrId, v) {
	// affecte une valeur à l'élément dont la référence ou l'id est fourni; si val n'est pas fourni, on renvoie son contenu
	if ((typeof refOrId) == "string") {
		refOrId = document.getElementById(refOrId);
	}
	
	if (v == undefined) return refOrId.innerHTML; 
	else refOrId.innerHTML = v;
	
}

function val(refOrId, v) {
	// affecte une valeur à l'élément dont la référence ou l'id est fourni; si val n'est pas fourni, on renvoie son contenu
	// l'élément est un champ de formulaire
	
	// TODO : traiter aussi le cas des checkbox 
	
	if ((typeof refOrId) == "string") {
		refOrId = document.getElementById(refOrId);
	}
	
	// cas checkbox
	if (refOrId.type == "checkbox") {
		if (v == undefined) return refOrId.checked; 
		else refOrId.checked = v;
	} else {
		if (v == undefined) return refOrId.value; 
		else refOrId.value = v;
	 }
	
}

// TODO : produire une librairie de fonctions utils.js 
// Utiliser la librairie pour compléter js3_tryit

function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}

function redirect(page,delai){
	setTimeout(function(){
		document.location.href=page;
},delai);
}

console.log("Chargement lib utils (debug,oDebug, show,hide,html,val)");












