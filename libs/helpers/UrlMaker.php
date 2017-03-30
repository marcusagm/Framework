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
 * Description of DataGrid
 *
 * @package MaiaFW\Lib\Helper
 * @category Helpers
 * @version 1.0
 */
class UrlMaker
{

    /**
     * Monta uma URL completa para uma action informada pelos atributos.
     *
     * @param string $controller Nome do controller.
     * @param string $action Nome da action.
     * @param string $params Parâmetros a action deve receber.
     * @param string $module Nome do módulo caso houver.
     * @return string Retorna uma URL completa montada.
     */
    public static function toAction($controller, $action = null, $params = array(), $module = null)
    {
        $app = ConfigCore::getInstance();
        $return = $app->getAppBaseUrl();
        $return .= $module != null ? $module . '/' : '';
        $return .= $controller . '/';
        $return .= $action != null ? $action . '/' : '';
        $return .= count($params) > 0 ? join('/', $params) : '';
        return $return;
    }

    /**
     * Monta uma URL completa para uma action informada pelos atributos.
     *
     * Use para montar URLs onde os controller estão agrupados por um módulo.
     *
     * @param string $module Nome do módulo caso houver.
     * @param string $controller Nome do controller.
     * @param string $action Nome da action.
     * @param string $params Parâmetros a action deve receber.
     * @return string Retorna uma URL completa montada.
     */
    public static function toModuleAction($module, $controller, $action = null, $params = array())
    {
        $app = ConfigCore::getInstance();
        $return = $app->getAppBaseUrl();
        $return .= $module . '/';
        $return .= $controller . '/';
        $return .= $action != null ? $action . '/' : '';
        $return .= count($params) > 0 ? join('/', $params) : '';
        return $return;
    }

    /**
     * Monta uma URL completa baseada em uma rota.
     *
     * @param string $route Nome da rota.
     * @param string $controller Nome do controller.
     * @param string $action Nome da action.
     * @param string $params Parâmetros a action deve receber.
     * @param string $module Nome do módulo caso houver.
     * @param string $language Linguagem utilizada pela rota.
     * @return string Retorna uma URL completa montada.
     */
    public static function toRoute($route, $controller = null, $action = null, $params = array(), $module = null, $language = null)
    {
        $app = ConfigCore::getInstance();
        $routes = ConfigRoutes::getInstance();

        $routeRule = $routes->getRoute($route);

        $keywords = array(
            ':language',
            ':module',
            ':controller',
            ':action',
            ':params'
        );

        $keywordsPattern = array(
            $language,
            $module,
            $controller,
            $action,
            join('/', $params)
        );

        return $app->getAppBaseUrl() . str_replace($keywords, $keywordsPattern, $routeRule['path']);
    }
}
