/* Esta funcion se usa para calcular qué posiciones (posts de sitios) del array_sitios se agrega a la vista portfolio */

/* Se recibe la ultima posicion usada del arreglo array_sitios
 y el maximo del arreglo (sitios cargados) */
(function($){
    $(document).on('click','.show-more',function(e){
        e.preventDefault();

        var posts_being_showed = cd_vars.num;
        var the_url = cd_vars.url;
        
        jQuery.ajax({
			url : the_url,
            type: 'post',
			data : {
				res : 
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


        

    })

})(jQuery);