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
 *
 * @package MaiaFW\Lib\Type
 * @category Types
 * @version 1.0
 */
class FwObject
{

    /**
     * @property ConfigCore
     */
    protected $_app = null;

    /**
     * @property ConfigCore
     */
    protected $App = null;

    function __construct()
    {
        $this->_app = ConfigCore::getInstance();
        $this->App = ConfigCore::getInstance();
    }

    function __destruct()
    {

    }
}
