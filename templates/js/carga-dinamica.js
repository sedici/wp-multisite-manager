/* Esta funcion se usa para calcular qué posiciones (posts de sitios) del array_sitios se agrega a la vista portfolio */

/* Se recibe la ultima posicion usada del arreglo array_sitios
 y el maximo del arreglo (sitios cargados) */
 (function($){
    $(document).on('click','.show-more',function(e){
        e.preventDefault();

        var count = $("#portfolio-count").val();
        var pagesCount = Math.ceil(cd_vars.tam_max / 3);
        var box_color = cd_vars.box_color;
        var the_url = cd_vars.url;
        var auxCount = parseInt(count);
        auxCount++;

        jQuery.ajax({
            url: the_url,
            type: 'post',
            data: {
                actual_count: auxCount,
                box_color: box_color,
                action: 'load_more'
            },
            success: function(response){
                $("#portfolio-count").val(auxCount);
                $(".sites-portfolio").append(response);
                // Muevo el botón "show-more" después de agregar las nuevas cajas
                $(".show-more").appendTo(".sites-portfolio");
                if(auxCount >= pagesCount){
                    $('.show-more').hide();
                }
            },
            error: function(e){
                console.log('An error occurred sending the data');
            }
        });
    });
})(jQuery);