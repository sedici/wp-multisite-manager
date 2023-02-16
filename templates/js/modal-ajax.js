(function($){
	// e es informacion sobre el evento
	$(document).on('click','.cta',function(e){
	 	e.preventDefault();
		id = e.target.parentElement.parentElement.id; /* Obtengo el id de la box que tengo que enviarle al server */



		jQuery.ajax({
			url : imjs_vars.url,
            type: 'post',
			data : {
				'box_id': id,
				action: 'charge_modal',
			},
			success: function(e){
			    console.log('Data sent');
				console.log(e);
			},

			error : function(e){
				console.log('An error occurred sending the data');
			}

		})
		

	})		

})(jQuery);


(function($){


});