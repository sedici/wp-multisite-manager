<div class='modal-container'> 

    <div class='modal-main-box'>
    <div class="modal-header">
         <button class='modal-close dot'>X</button> 

        <h1 class='modal-title'> <?php echo $data->site_title;?> </h1>	
    </div>
    <div class="modal-box">

        <div class="modal-img">
            <?php echo $data->site_screenshot ?>
        </div>

        <div class="modal-data">

            <span class='sites-portfolio-title'> Fecha de creacion: 
                <span class='modal-data-text'> <?php echo $data->site_fecha_creacion; ?> </span>
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
