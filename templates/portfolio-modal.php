<div id='modal-container'> 

    <div class='modal-main-box'>

    <div class='modal-close dot'> <p>X</p> </div> 

    <span class='modal-title'> <?php echo $data->site_title;?> </span>	

    <div class="modal-box">

        <div class="modal-img">
            <?php echo $data->site_screenshot ?>
        </div>

        <div class="modal-data">

            <span class='sites-portfolio-title'> Fecha de creacion: 
                <p> <?php echo $data->site_fecha_creacion; ?> </p>
            </span> 

            <br>

            <span class='sites-portfolio-title'> URL: 
                <a href='<?php echo $data->site_URL; ?>'> <?php echo $data->site_URL; ?> </a>
            </span> 

            <br>
                
            <p> 
                <span class='sites-portfolio-title'> Descripción: </span>  <?php echo $data->site_description; ?> 
            </p>

        </div>

    </div>
</div>

</div>
