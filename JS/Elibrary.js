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
			}
		},

		/**
		 * Effectue un appel ajax et exécute une fonction en cas de succès
		 * @param string url		Le chemin vers le fichier qui va récupérer nos données
		 * @param string callback	Le nom de la fonction à exécuter après avoir reçu les données. Il ne faut pas mettre de parenthèses
		 * @param object params		Object qui contient tout les paramètres à envoyer
		 * @author Dario GENGA - dario.gng@eduge.ch
		 */
		get_data : function (url, callback, params) {
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

					switch (data){
					case 1 : // tout bon
						// On récupère par params, notre tableau des arguments.
						params.unshift(data);
						callback.apply(this, params);
						break;
					default:
						msg = data;
					break;
					}
				},
				error: function(jqXHR){
					ELibrary.errorJqXHR(jqXHR);
				}
			});

		},
	};
}());