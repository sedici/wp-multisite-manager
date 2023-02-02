(function($){

	$(document).on('click','#update-cpt-button',function(e){
	 	e.preventDefault();
		jQuery.ajax({
			url : ucpt_vars.url,
            type: 'post',
			data: {
				action: 'update_sites_cpt',
			},
			beforeSend: function(){
			    $('#update-result').html('Recuperando sitios ...');
			},
			success: function(resultado){
			    $('#update-result').html('Sitios recuperados correctamente');
                $('#update-result').css("color", "green");
                console.log(resultado);

			}

		});

	});

})(jQuery);

