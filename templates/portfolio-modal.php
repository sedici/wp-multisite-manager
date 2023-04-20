<div class='modal-container'> 

    <div class='modal-main-box'>

        <div class="modal-columna1">
            <div class="modal-img">
                <?php echo $data->site_screenshot ?>
            </div>
        </div>  

        

        <div class="modal-columna2">
            <div id="modal-header">
                <h1 class='modal-title'> <?php echo $data->site_title;?> </h1>	

                <button class='modal-close dot'>X</button>
                
            </div>
            
            <div class="modal-data">

                <span class='modal-subtitle'> Fecha de creacion: 
                    <span class='modal-data-text'> <?php echo $data->site_fecha_creacion; ?> </span>
                </span> 

                <span class='modal-subtitle'> URL: 
                    <a class='modal-data-text' href='<?php echo $data->site_URL; ?>'> <?php echo $data->site_URL; ?> </a>
                </span> 

                <span class='modal-subtitle'> Descripción: </span> 
                <p class='modal-data-text'> <?php echo $data->site_description; ?> </p>

            </div>
        </div>


    </div>

</div>
