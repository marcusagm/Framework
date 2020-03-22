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
 * Description of Resource
 *
 * @package MaiaFW\Lib\Helper
 * @category Helpers
 * @version 1.0
 */
class Resource
{
    private $path = false;
    private $content = false;
    private $originalContent = false;

    public function __construct($resourcePath)
    {
        $this->path = $resourcePath;
        $this->getContent();

        return $this;
    }

    public function getContent()
    {
        if ($this->content !== false) {
            return $this->content;
        }

        ob_start();
        include( SYSROOT . 'resources' . DS . $this->path . '.res.php' );
        $message = ob_get_contents();
        ob_end_clean();
        $this->content = $message;
        $this->originalContent = $message;

        return $message;
    }

    public function getOriginalContent()
    {
        if ($this->originalContent === false) {
            return $this->getContent();
        }
        return $this->originalContent;
    }

    public function replaceKey( $key, $text )
    {
        $this->content = str_replace('{{' . $key . '}}', $text, $this->content);
        return $this;
    }
}
