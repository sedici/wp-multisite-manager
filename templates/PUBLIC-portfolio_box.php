<div 
    class='sites-portfolio-box' 
    style='background-color:<?php echo $data->box_color ?>' 
    id='<?php echo $data->site_id; ?> '
>
	<?php echo $data->site_screenshot ?>
    
    <span class='sites-portfolio-title' id='site-title'> <?php echo $data->site_title;?> </span>	
    <br>
	<span class='sites-portfolio-title' id='site-desc'> Descripción: </span>
    <p> <?php echo $data->site_description; ?> </div>