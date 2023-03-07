/* Esta funcion maneja la apertura del modal cuando se clickea en el elemento cta (boxes del portfolio) */
(function($){
	/* e es informacion sobre el evento */

	/* Detecta cuando se hace click en el box de un sitio */
	$(document).on('click','.cta',function(e){
	 	e.preventDefault();

		id = e.currentTarget.id; /* Obtengo el id de la box que tengo que enviarle al server */

		the_url = imjs_vars.url;
		
		jQuery.ajax({
			url : the_url,
            type: 'post',
			data : {
				'box_id': id,
				action: 'procesar_request_modal',
			},
			success: function(response){
			    console.log('Data sent');
				
				jQuery('body').append(response);
				jQuery('.modal').show();
			},

			error : function(e){
				console.log('An error occurred sending the data');
			}

		})

		})		

})(jQuery);

/* Esta funciona maneja el cierre del modal cuando se clickea en el elemento modal-close */
(function($){
	// e es informacion sobre el evento
	$(document).on('click','.modal-close',function(e){
	 	e.preventDefault();
		$(".modal-container").remove();
	})
})(jQuery);