<div class='modal-container'> 

    <div class='modal-main-box'>

        <button class='modal-close dot'>X</button>

        <?php echo $data->site_screenshot ?>

        <div class="barra-transparente">

            <span class='modal-subtitle' id='modal-site-title'> <?php echo $data->site_title;?> </span> 

            <div class='sub-barra-transparente'>

                <div id='elem-bar-modal2' class='elemento-barra-modal'>
                    <span class='modal-subtitle'> Fecha de creacion: 
                        <p class='modal-data-text'> <?php echo $data->site_fecha_creacion; ?> </p> 
                    </span> 
                </div>

                <div id='elem-bar-modal3' class='elemento-barra-modal'>
                    <span class='modal-subtitle'> URL: 
                        <a class='modal-data-text' id='link-al-sitio' href='<?php echo $data->site_URL; ?>'> <?php echo $data->site_URL; ?> </a>
                    </span> 
                </div>  
                
                <div id='elem-bar-modal4' class='elemento-barra-modal'>
                    <span class='modal-subtitle'> Descripción: 
                        <p class='modal-data-text'> <?php echo $data->site_description; ?> </p>
                    </span>
                </div>
            </div>


        </div>


    </div>

</div>
