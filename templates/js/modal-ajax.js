(function($){

	// e es informacion sobre el evento
	$(document).on('click','.cta',function(e){
	 	e.preventDefault();
		var id = e.target.parentElement.parentElement.id; /* Obtengo el id de la box que tengo que enviarle al server */
		jQuery.ajax({
			url : imjs_vars.url,
            type: 'POST',
			data : {
				box_id: id,
				action: 'charge_modal',
			},
			success: function(){
			    console.log('Exito');
			},

			error : function(e){
				console.log('Fallo');
			}

		})
		

	})		

})(jQuery);


