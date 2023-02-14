(function($){

	// e es informacion sobre el evento
	$(document).on('click','.cta',function(e){
	 	e.preventDefault();
		box_id = e.target.parentElement.parentElement.id; /* Obtengo el id de la box que tengo que enviarle al server */
		
		jQuery.ajax({
			url : 
            type: 'post',
			data: {
				action: 'charge_modal',
				action: 'print_modal',
				id: box_id,
			},
			success: function(){
			    alert('Finalizo');
			},

			error : function(){
				alert('Disculpe, ocurrio un error');
			}

		});

	})		

})(jQuery);


