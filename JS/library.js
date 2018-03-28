/** Auteur: Jessica Baertschi, Jean-Daniel Küenzi, Dario Genga
 * Titre: annuaire_stage
 * Description : Annuaire des entreprises permettant aux élèves souhaitant faire un stage d’avoir un outil qui les aidera pendant leurs recherches.
 * Version: 1.0.0
 * Date: 25.11.2016
 * Copyright: Entreprise Ecole CFPT-I © 2016-2017 */

/**
 * @author Dario GENGA
 */
var ELibrary = (function(){
	var _args = {}; // private

	return {
		init : function(Args) {
			_args = Args;
			// some other initialising
		},

		/**
		 * Gère les erreurs lors des appels ajax
		 * @param jqXHR		jQuery XMLHttpRequest
		 */
		errorJqXHR : function(jqXHR){
			var msg = '';
			switch(jqXHR.status){
			case 404 :
				msg = "page pas trouvée. 404";
				break;
			case 200 :
				msg = "probleme avec json. 200";
				break;

			} // End switch
			if (msg.length > 0){
				$("#info").html(msg);
				ELibrary.showHtmlElement("errorInfo", 10);
			}
		},

		/**
		 * Effectue un appel ajax et exécute une fonction en cas de succès
		 * @param string url		Le chemin vers le fichier qui va récupérer nos données
		 * @param string callback	Le nom de la fonction à exécuter après avoir reçu les données. Il ne faut pas mettre de parenthèses
		 * @param object params		Object qui contient tout les paramètres à envoyer
		 * @author Dario GENGA - dario.gng@eduge.ch
		 */
		get_data : function (url, callback, params = {}) {
			// Copier l'objet params dans une variable locale
			// qui sera simplement utilisées pour l'appel Ajax
			var dp = params;
			// On utilise le paramètre de la fonction qui est stocké sur le stack
			// pour créer un tableau qui contient les paramètres additionnels qui se 
			// trouvent après params.
			// Si on stocke ces paramètres dans un tableau créé dans cette function,
			// il sera détruit après l'appel Ajax et on aura plus rien lorsqu'on sera
			// rappelé de manière asynchrone.
			params = Array();
			for (var i = 3; i < arguments.length; i++){
				params.push(arguments[i]);
			}

			$.ajax({
				method: 'POST',
				url: url,
				data: dp,
				dataType: 'json',
				success: function (data) {
					var msg = '';

					switch (data.ReturnCode){
					case 0 : // tout bon
						// On récupère par params, notre tableau des arguments.
						params.unshift(data.Data);
						callback.apply(this, params);
						break;
					case 2 : // problème récup données
					case 3 : // problème encodage sur serveur
					default:
						msg = data.Message;
					break;
					}
				},
				error: function(jqXHR){
					ELibrary.errorJqXHR(jqXHR);
				}
			});

		},
		/**
		 * Construit une liste déroulante selon les données reçus
		 * @param string arData				Tableau JSON qui contient les domaines
		 * @param JQuery element			L'élément html qui va contenir la liste déroulante que l'on va créer
		 * @param string idSelect			L'ID (et l'attribut name) de notre select
		 * @param string classSelect		La classe de notre select
		 * @param string firstOptionText	Le texte du première élément de notre select
		 * @param bool idAndName			Si true le texte et la value des options correspondront respectivement aux colonnes id et name | sinon ils correspondront aux colonnes code et label
		 * @param bool firstOptionDisabled	Si true on désactive le première élément de notre select | sinon on le laisse activer
		 * @param string idMultiselect		L'ID du select qui doit être multiple, crée un select normal si vaut false
		 */
		createSelect : function (arData, element, idSelect, classSelect, firstOptionText, idAndName = true, firstOptionDisabled = false, idMultiselect = false) {
			var sel = $('<select id="' + idSelect + '" class="' + classSelect + '" name="' + idSelect + '">');
			var op = null;
			
			if (idMultiselect != false) {
				sel.attr('multiple', 'multiple');
			}
			else {
				op = $('<option value="0" selected>' + firstOptionText + '</option>');
				if (firstOptionDisabled) {
					op.attr('disabled', 'disabled');
				}
				sel.append(op);
			}

			if(idAndName) {
				arData.forEach(function(select){
					op = $('<option value="' + select.id + '">' + select.name + '</option>');
					sel.append(op);
				})
			}
			else {
				arData.forEach(function(select){
					op = $('<option value="' + select.code + '">' + select.label + '</option>');
					sel.append(op);
				})
			}
			element.append(sel);

			// Construit le multiselect et définit divers paramètres
			$('#' + idMultiselect).multiselect({
				nonSelectedText: 'Sélectionnez un ou plusieurs secteurs',
				nSelectedText: 'secteurs sélectionnés',
				allSelectedText: 'Tous les secteurs sont sélectionnés',
				numberDisplayed: 1
			});
			
		},
		
		/**
		 * Affiche ou masque les filtres de la page
		 * @param JQuery element		L'élément qui a appelé la fonction
		 * @param string classFilters	La classe des filtres à masquer
		 */
		showAndHideFilters : function (element, classFilters) {
			var status = element.val() // show pour afficher, hide pour masquer
			
			if (status == "show") {
				$(classFilters).show();
				element.attr("title", "Masquer les filtres");
				element.val("hide");
			}
			else if (status == "hide") {
				$(classFilters).hide();
				element.attr("title", "Afficher les filtres");
				element.val("show");
			}
		},
		/**
		 * @author GENGA Dario
		 * Filtre un tableau à partir d'une ou plusieurs liste déroulante
		 * @param string idSelect			L'ID de l'élément select avec lequel on filtre notre tableau
		 * @param string tableRows			Class de l'élément table sur lequel on va appliquer notre filtre
		 * @param int column				Le numéro de colonne sur lequel le filtre est basé (commence à 1)
		 * @param bool firstSelectFilter	Si true il s'agit du premier select qui filtre, si false il s'agit d'un autre select qui filtre
		 */
		filterTable : function (idSelect, tableRows, column, firstSelectFilter = true) {
			var optionSelected = $("#" + idSelect + " option:selected");
			
			// Si il s'agit du premier select qui filtre il faut réafficher les données qui ont été potentiellement filtré
			if (firstSelectFilter)
				$(tableRows).show();
			
			var selectedValue = optionSelected.val();
			// 0 signifie tout afficher, si la valeur de notre option est différente c'est qu'il faut filtrer
			if (selectedValue != 0) {
				var selectedText = optionSelected.text();
				$(tableRows).each(function() {
					// Récupère le texte de la cellule du tableau dans une colonne spécifique
					var thisText = $(this).find("td:nth-child(" + column + ")").text();
					// On recherche l'option sélectionnée dans le texte de la celulle du tableau
					$search = thisText.match(selectedText);
					if ($search == null) {
						$(this).hide();
					}
				});
			}
		},
		/**
		 * Filtre un tableau selon une date de début ou de fin
		 * @param string dateLimit		Date de début ou fin qui sert à indiquer la "limite" du filtrage
		 * @param bool begin			Si true il s'agit de la date de début, sinon il s'agit de la date de fin
		 * @param string tableRows		Les lignes de notre tableau sur lequel on va appliquer notre filtre
		 * @param int column			Le numéro de colonne sur lequel le filtre est basé (commence à 1)
		 */
		filterDate : function (dateLimit, begin, tableRows, column) {
			$(tableRows).each(function() {
				// Récupère le texte de la cellule du tableau dans une colonne spécifique
				var thisText = $(this).find("td:nth-child(" + column + ")").text();
				if (begin) {
					// Date de début
					if (thisText == 'Non définie' || thisText < dateLimit) {
						$(this).hide();
					}
				}
				else {
					// Date de fin
					if (thisText == 'Non définie' || thisText > dateLimit) {
						$(this).hide();
					}
				}
			});
		},
		/**
		 * Formate une date (yyyy-mm-dd)
		 * @param string inputDate	Il s'agit de l'élément html qui contient la date que l'on veut convertir
		 * @return string date		Retourne une date au format suivant : yyyy-mm-dd
		 */
		formatDate : function (dateToConvert) {
			var date = new Date(dateToConvert);
			var day = date.getDate(); // Récupère le jour du mois (1 à 31)
			var month = date.getMonth() + 1; // Récupère le mois (0 à 11) + 1
			var year = date.getFullYear(); // Récupère l'année (yyyy)
			
			if (day < 10)
				day = '0' + day;
			if (month < 10)
				month = '0' + month

			return date = year + '-' + month + '-' + day;
		},

		/**
		 * Récupèration  les commentaires non-validés
		 * @param int nbComment		Nombre de commentaire restant à valider	
		 * @param string element	L'élément html qui contient le badge pour le nombre de commentaire non validés
		 * @param string commTable	Le tableau des commentaires qu'il faut update
		 */
		loadUnvalidatedComments : function (nbComment, element, commTable) {
			var el = $('#' + element);
			el.html(nbComment);
			var s = "Il vous reste " + nbComment + " commentaire(s) à valider";
			el.attr('title', s);
			
			// Actualisation du tableau
			$('#' + commTable).trigger("update");
		
		},		

		/**
		 * @brief Afficher un élément html et le fait disparaître automatiquement
		 * 		  après un certain nombre de secondes.
		 * @param id L'identifiant de l'élément html
		 * @param displayTime (Optional) C'est le temps en secondes que le message reste affiché.
		 * 					  Default est 5 secondes.
		 * 				      Si 0 ou < 0 est spécifié, le message ne disparaît pas.
		 */
		showHtmlElement : function (id, displayTime=5) {
			var el = $('#'+id);
			if (el.length > 0){
				el.show( "slow", function(){
					// J'arrive ici une fois que j'ai montré mon élément html
					// C'est je veux le cacher après le displayTime
					if (displayTime > 0){
						setTimeout(function(){
							el.hide("slow");
						}, displayTime*1000);
					}
				});
			}
		},

	};
}());