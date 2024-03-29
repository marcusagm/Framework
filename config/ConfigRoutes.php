<?php
/**
 * MaiaFW - Copyright (c) Marcus Maia (http://marcusmaia.com.br)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author     Marcus Maia (contato@marcusmaia.com.br)
 * @copyright  Copyright (c) Marcus Maia (http://marcusmaia.com.br)
 * @link       http://maiafw.marcusmaia.com.br MaiaFW
 * @license    http://www.opensource.org/licenses/mit-license.php MIT License
 */

/**
 * Configurações de rotas de requisições.
 *
 * Define rotas de URLs possíveis para receber requisições, permitindo perdonalizar
 * URLs e aponta-las para executar determinadas Actions de um Controller.
 *
 * @package MaiaFW\Config
 * @category Configurations
 * @version 1.0
 */
class ConfigRoutes extends Config
{

    /**
     *
     * @var array
     */
    private $_routes = array();

    /**
     *
     * @var array
     */
    private $_modules = array();

    /**
     *
     * @param type $name
     * @param string $path
     * @param type $controller
     * @param type $action
     * @param type $module
     * @param type $prefix
     */
    public function addRoute(
        $name,
        $path,
        $controller = null,
        $action = null,
        $module = null,
        $language = null,
        $prefix = null
    ) {
        if (substr($path, 0, 1) == '/') {
            $path = substr($path, 1);
        }

        $this->_routes[$name] = array(
            'path' => $path,
            'controller' => $controller,
            'action' => $action,
            'module' => $module,
            'language' => $language,
            'prefix' => $prefix
        );
    }

    /**
     *
     * @param string $name
     */
    public function addModule($name)
    {
        $this->_modules[] = $name;
    }

    /**
     *
     * @return array
     */
    public function getModules()
    {
        return $this->_modules;
    }

    /**
     *
     * @return array
     */
    public function getRoutes()
    {
        return $this->_routes;
    }

    /**
     *
     * @param string $name
     * @return array
     */
    public function getRoute($name)
    {
        return $this->_routes[$name];
    }
}
