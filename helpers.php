<?php

function print_description($blank = false){
    if(get_post_meta(get_the_ID(),'site_description') and (!empty(get_post_meta(get_the_ID(),'site_description')[0]) ))
    {
            return get_post_meta(get_the_ID(),'site_description',true);
    }	
    else{
        if(!$blank){
            return "<span > No hay descripción </span>";
        }
    }
}



?>