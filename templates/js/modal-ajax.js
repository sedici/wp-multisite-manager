(function($){
	// e es informacion sobre el evento
	$(document).on('click','.cta',function(e){
	 	e.preventDefault();
		 id = e.target.parentElement.parentElement.id; /* Obtengo el id de la box que tengo que enviarle al server */

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


(function($){
	// e es informacion sobre el evento
	$(document).on('click','.modal-close dot',function(e){
	 	e.preventDefault();
		id_close = e.target; 
		console.log(id_close);	
	})
});