
        <h1> Administrar la red de multisitio </h1>

        <p>Este plugin de Wordpress permite administrar configuraciones gloables para todos los sitios
		dentro de una red de Multisitio. </p>

        <h2> Actualizar información de los CPT de sitios </h2>
        <button id='update-cpt-button' > Actualizar </button> <br></br>
       
       <?php $this->print_sites_count(); ?>
        <p id='update-result'></p>
        <br></br><h2> Sitios actuales </h2>
        <div id="nds-wp-list-table-demo">			
        <div id="nds-post-body">		
        <form id="nds-user-list-form" method="get">
    
        <?php   $this->cpt_list_table->prepare_items(); 
                $this->cpt_list_table->display(); 
        ?>
        </form>
            </div>			
        </div>