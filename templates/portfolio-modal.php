<div class='modal-container'> 

    <div class='modal-main-box'>
    <div class="modal-header">
        <div class='modal-close dot'> <p>X</p> </div> 

        <h1 class='modal-title'> <?php echo $data->site_title;?> </h1>	
    </div>
    <div class="modal-box">

        <div class="modal-img">
            <?php echo $data->site_screenshot ?>
        </div>

        <div class="modal-data">

            <span class='sites-portfolio-title'> Fecha de creacion: 
                <p class='modal-data-text'> <?php echo $data->site_fecha_creacion; ?> </p>
            </span> 

            <span class='sites-portfolio-title'> URL: 
                <a class='modal-data-text' href='<?php echo $data->site_URL; ?>'> <?php echo $data->site_URL; ?> </a>
            </span> 

            <span class='sites-portfolio-title'> Descripción: </span> 
            <p class='modal-data-text'> <?php echo $data->site_description; ?> </p>

        </div>

    </div>
</div>

</div>
