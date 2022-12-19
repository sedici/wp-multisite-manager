<?php

namespace Wp_multisite_manager\Core;

/**
 * Registra todas las acciones y filtros del plugin.
 * */

/**
 * Registrar todas las acciones y filtros del plugin.
 *
 * Ejecutar función para ejecutar la lista de acciones y filtros.
 */
class Loader
{

    /**
     * Acciones registradas en wordpres
     *
     * @var      array    $actions Acciones que se registran cuando se carga el plugin 
     */
    protected $actions;

    /**
     * The array of filters registered with WordPress.
     *
     * @var      array    $filters    Filtros que se registran cuando se carga el plugin.
     */
    protected $filters;

    
    public function __construct()
    {

        $this->actions = array();
        $this->filters = array();

    }

    /**
     *
     * @param    string $hook             El nombre de la acción de WordPress que se está registrando.
     * @param    object $component        Instancia de la clase en la que se define la acción.
     * @param    string $callback         Nombre de la función en el componente $component donde se define la acción.
     * @param    int    $priority         Opcional. La prioridad a la que se debe registrar la función. El valor predeterminado es 10.
     * @param    int    $accepted_args    Opcional. El número de argumentos que se deben pasar a la devolución de llamada $. El valor predeterminado es 1.
     */
    public function add_action($hook, $component, $callback, $priority = 10, $accepted_args = 1)
    {
        $this->actions = $this->add($this->actions, $hook, $component, $callback, $priority, $accepted_args);
    }

    /**
     *
     * @param    string $hook             El nombre de la filtro de WordPress que se está registrando.
     * @param    object $component        Instancia de la clase en la que se define el filtro.
     * @param    string $callback         Nombre de la función en el componente $component donde se define el filtro.
     * @param    int    $priority         Opcional. La prioridad a la que se debe registrar la función. El valor predeterminado es 10.
     * @param    int    $accepted_args    Opcional. El número de argumentos que se deben pasar a la devolución de llamada $. El valor predeterminado es 1.
     */
    public function add_filter($hook, $component, $callback, $priority = 10, $accepted_args = 1)
    {
        $this->filters = $this->add($this->filters, $hook, $component, $callback, $priority, $accepted_args);
    }

    /**
     * Registra acciones y hooks en una coleccion. 
     *
     * @access   private
     * @return   array    
     */
    private function add($hooks, $hook, $component, $callback, $priority, $accepted_args)
    {

        $hooks[] = array(
            'hook' => $hook,
            'component' => $component,
            'callback' => $callback,
            'priority' => $priority,
            'accepted_args' => $accepted_args,
        );

        return $hooks;

    }

    /**
     * Registra  filters y acciones en WordPress.
     *
     * @since    1.0.0
     */
    public function run()
    {

        foreach ($this->filters as $hook) {
            add_filter($hook['hook'], array($hook['component'], $hook['callback']), $hook['priority'], $hook['accepted_args']);
        }

        foreach ($this->actions as $hook) {
            add_action($hook['hook'], array($hook['component'], $hook['callback']), $hook['priority'], $hook['accepted_args']);
        }

    }

}
