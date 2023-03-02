<div id='modal-container'> 

    <div class='modal'>

    <div class='modal-close dot'> <p>X</p> </div> 
    <span class='modal-title'> <?php echo $data->site_title;?> </span>	

    <div class="modal-box">
        <div class="modal-img">
            <?php echo $data->site_screenshot ?>
        </div>
        <div class="modal-data">
            <br>
            <p> <span class='sites-portfolio-title'> Descripción: </span>  <?php echo $data->site_description; ?> </p>
        </div>
    </div>
</div>

</div>
