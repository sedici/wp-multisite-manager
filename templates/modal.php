<div class='modal-container'> 

    <div class='modal-main-box'>

        <?php echo $data->site_screenshot ?>

        <button class='modal-close'>X</button>

        <div class="barra-transparente">

            <span class='modal-subtitle' id='modal-site-title'> <?php echo $data->site_title;?> </span> 

            <div class='sub-barra-transparente'>

                <div id='modal-div-fecha-creacion' class='elemento-barra-modal'>
                    <span class='modal-subtitle'> Fecha de creacion: 
                        <span class='modal-data-text'> <?php echo $data->site_fecha_creacion; ?> </span> 
                    </span> 
                </div>

                <div id='modal-div-url' class='elemento-barra-modal'>
                    <span class='modal-subtitle'> URL: 
                        <a class='modal-data-text' id='link-al-sitio' href='<?php echo $data->site_URL; ?>'> <?php echo $data->site_URL; ?> </a>
                    </span> 
                </div>  
                
                <div id='modal-div-desc' class='elemento-barra-modal'>
                    <span class='modal-subtitle'> Descripción: 
                        <p id='modal-description-text' class='modal-data-text'> <?php echo $data->site_description; ?> </p>
                    </span>
                </div>

                
                <span class='modal-subtitle'>
                    <a target="_blank" id='link-modal-img' href='<?php echo $data->screenshot_url; ?>'> Toca para ver la imagen! </a>
                </span>

            </div>


        </div>

    </div>

</div>
