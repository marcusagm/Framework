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
 * Esta classe contem várias funções para tratamento de variáveis do tipo string.
 * Toda variável que seja deste tipo, é recomendado que utilize esta classe para
 * suprir a necessidade de tipagem forte no PHP em aplicações orientadas a objetos.
 *
 * @package MaiaFW\Lib\Type
 * @category Types
 * @version 1.0
 */
class Text
{
    /**
     * Obtem o tamanho da string.
     *
     * @param string $value String a ser trabalhada
     * @param string [$encoding] Códificação utilizada
     * @return integer
     */
    public static function length($value, $encoding = null)
    {
        if ($encoding !== null) {
            return mb_strlen($value, $encoding);
        }
        return mb_strlen($value);
    }

    /**
     * Retorna a string escrita ao contrário, exemplo: "Exemplo" retorna "olpmexE"
     *
     * @param string $value String a ser trabalhada
     * @return void
     */
    public static function reverse($value)
    {
        return strrev($value);
    }

    /**
     * Retorna o caracter em uma determinada posição na string.
     *
     * @param string $value String a ser trabalhada
     * @return void
     */
    public static function charAt($value, $position)
    {
        return $value[$position];
    }

    /**
     * Verifica se existe uma um padrão na string atual. Este método aceita
     * expressões regulares.
     *
     * @param string $value String a ser trabalhada
     * @param string $pattern Texto ou expressão procurada.
     * @return boolean
     */
    public static function match($value, $pattern, &$returnMatches = false)
    {
        if ($returnMatches !== false) {
            return preg_match($pattern, $value, $returnMatches);
        }
        return preg_match($pattern, $value);
    }

    /**
     * Corta a string em um número determinado de caracteres, podendo iniciar de uma
     * determinada posição.
     *
     * @param string $value String a ser trabalhada
     * @param integer $limit Número máximo de caracteres.
     * @param integer $start[optional] Posição inicial de contagem.
     * @param string [$encoding] Códificação utilizada
     * @return void
     */
    public static function crop($value, $limit, $start = 0, $encoding = null)
    {
        // return mb_strcut($value, $start, $limit, $encoding);
        return substr($value, $start, $limit);
    }

    /**
     * Retorna a primeira posição de uma string dentro da atual.
     *
     * @param string $value String a ser trabalhada
     * @param string $search String desejada.
     * @param $offset[optional] Posição inicial para busca na string.
     * @param string [$encoding] Códificação utilizada
     */
    public static function indexOf($value, $search, $offset = 0, $encoding = null)
    {
        return mb_strpos($value, $search, $offset, $encoding);
    }

    /**
     * Divide a string em um array usando um delimitador como referencia, podendo
     * limitar o número máximo de caracteres dentro das partes criadas.
     *
     * @param string $value String a ser trabalhada
     * @param string $pattern Delimitador para separação.
     * @param integer $limit[optional] Limite máximo de caracteres para as partes
     * separadas.
     * @return array
     */
    public static function split($value, $pattern, $limit = -1)
    {
        return mb_split($pattern, $value, $limit);
    }

    /**
     * Localiza e substitui todos os trechos do padrão informado por um texto na
     * string atual.
     *
     * @param string $value String a ser trabalhada
     * @param string $pattern Expressão que se deseja substituir.
     * @param string $replacement Texto que substituirá a expressão.
     * @return void
     */
    public static function replace($value, $pattern, $replacement)
    {
        return mb_ereg_replace($pattern, $replacement, $value);
    }

    /**
     * Retira os espaços em branco do início e do fim da string atual.
     *
     * @param string $value String a ser trabalhada
     * @return void
     */
    public static function trim($value)
    {
        return trim($value);
    }

    /**
     * Esta função retorna a string input preenchida na esquerda, direita ou ambos
     * os lados até o tamanho especificado. Se o parâmetro opcional 'padString' não
     * for indicado, input  é preenchido com espaços, se não é preenchido com os
     * caracteres de 'padString' até o limite.
     *
     * @param string $value String a ser trabalhada
     * @param integer $length Tamanho fixo desejado para a string.
     * @param string $padString[optional] String que preencherá os espaços que faltam
     * para atigir o limite, caso não seja informado, a string é completada com
     * espaço.
     * @param string $type[optional] Como será preenchido o espaço. Use 'left' para
     * adicionar os caracteres à esquerda da string, 'right' para adicionar na
     * direita, e 'both' para que os caracteres complementares sejam postos em torno
     * da string, deixando-a no centralizada.
     * @return void
     */
    public static function pad($value, $length, $padString = false, $type = false)
    {
        switch ($type) {
            case 'left':
                $type = 'STR_PAD_LEFT';
                break;

            case 'both':
                $type = 'STR_PAD_BOTH';
                break;

            case 'right':
                $type = 'STR_PAD_RIGHT';
                break;
        }
        return str_pad($value, $length, $padString, $type);
    }

    /**
     * Remove todas as tags PHP e HTML da string atual.
     *
     * @param string $value String a ser trabalhada
     * @return void
     */
    public static function stripTags($value, $allowable_tags = false)
    {
        return strip_tags($value, $allowable_tags);
    }

    /**
     * Remove todas as barras de escape da string.
     *
     * @param string $value String a ser trabalhada
     * @return void
     */
    public static function stripSlashes($value)
    {
        return stripslashes($value);
    }

    /**
     * Adiciona barras de escape ao lado dos caracteres especiais como aspas.
     *
     * @param string $value String a ser trabalhada
     * @return void.
     */
    public static function addSlashes($value)
    {
        return addslashes($value);
    }

    /**
     * Altera a string atual, deixando-a mais amigável a humanos, alterando strings
     * como 'Exemplo-De-Texto' ou 'Exemplo_De_Texto' para 'Exemplo de texto'.
     *
     * @param string $value String a ser trabalhada
     * @return void
     */
    public static function humanize($value)
    {
        return ucfirst(str_replace(array('_', '-'), ' ', $value));
    }

    /**
     * Elimina os caracteres especiais da string atual e utiliza um caracter (por
     * padrão '-') para separar as palavras, e deixa os caracteres todos minúsculos.
     *
     * @param string $value String a ser trabalhada
     * @return void
     */
    public static function normalize($value, $replace = "-")
    {
        $map = array(
            '/À|à|Á|á|å|Ã|â|Ã|ã/' => 'a',
            '/È|è|É|é|ê|ê|ẽ|Ë|ë/' => 'e',
            '/Ì|ì|Í|í|Î|î/' => 'i',
            '/Ò|ò|Ó|ó|Ô|ô|ø|Õ|õ/' => 'o',
            '/Ù|ù|Ú|ú|ů|Û|û|Ü|ü/' => 'u',
            '/ç|Ç/' => 'c',
            '/ñ|Ñ/' => 'n',
            '/ä|æ/' => 'ae',
            '/Ö|ö/' => 'oe',
            '/Ä|ä/' => 'Ae',
            '/Ö/' => 'Oe',
            '/ß/' => 'ss',
            '/[^\\w\\s]/' => ' ',
            '/\\s+/' => $replace,
            "/^{$replace}+|{$replace}+$/" => ''
        );
        return strtolower(preg_replace(array_keys($map), array_values($map), $value));
    }

    /**
     * Altera a string atual para o formato CamelCase. Por exemplo, o texto
     * 'Texto exemplo' ficará desta forma: 'TextoExemplo'.
     *
     * @param string $value String a ser trabalhada
     * @return void
     */
    public static function camelize($value)
    {
        return str_replace(' ', '', ucwords(str_replace(array('_', '-'), ' ', $value)));
    }

    /**
     * Altera a string no formato CamelCase para o separado por um determinado caractere.
     * Por exemplo, o texto 'TextoExemplo' ficará desta forma: 'texto_exemplo'.
     *
     * @return void
     */
    public static function underscore($value)
    {
        return strtolower(preg_replace('/(?<=\\w)([A-Z])/', '_\\1', $value));
    }

    /**
     * Codifica a string atual para HTML, alterando todos os caracteres especiais
     * para a tabela de códigos dos caracteres.
     *
     * @param string $value String a ser trabalhada
     * @param string [$encoding] Códificação utilizada
     * @return void
     */
    public static function htmlEncode($value, $encoding = null)
    {
        return htmlentities($value, ENT_QUOTES, $encoding);
    }

    /**
     * Decodifica a string, removendo os códigos de caracteres especiais para
     * caracteres comuns.
     *
     * @param string $value String a ser trabalhada
     * @param string [$encoding] Códificação utilizada
     * @return void
     */
    public static function htmlDecode($value, $encoding = null)
    {
        return html_entity_decode($value, ENT_QUOTES, $encoding);
    }

    /**
     * Torna todos os caracteres minúsculos.
     *
     * @param string $value String a ser trabalhada
     * @param string [$encoding] Códificação utilizada
     * @return void
     */
    public static function toLower($value, $encoding = null)
    {
        if ($encoding !== null) {
            return mb_strtolower($value, $encoding);
        }
        return mb_strtolower($value);
    }

    /**
     * Torna todos os caracteres maiúsculos.
     *
     * @param string $value String a ser trabalhada
     * @param string [$encoding] Códificação utilizada
     * @return void
     */
    public static function toUpper($value, $encoding = null)
    {
        if ($encoding !== null) {
            return mb_strtoupper($value, $encoding);
        }
        return mb_strtoupper($value);
    }

    /**
     * Torna o primeiro caracter da string atual, maiúsculo.
     *
     * @param string $value String a ser trabalhada
     * @return void
     */
    public static function upperFirst($value)
    {
        return ucfirst($value);
    }

    /**
     * Torna o primeiro caracter da string atual, minúsculo.
     *
     * @param string $value String a ser trabalhada
     * @return void
     */
    public static function lowerFisrt($value)
    {
        return lcfirst($value);
    }

    /**
     * Torna o primeiro caracter de cada palavra maiúsculo.
     *
     * @param string $value String a ser trabalhada
     * @return void
     */
    public static function upperWords($value)
    {
        return ucwords($value);
    }

    /**
     * Contabiliza quantas palavras existem na string atual.
     *
     * @param string $value String a ser trabalhada
     * @return integer
     */
    public static function countWords($value)
    {
        $aditionalCaracters = 'ÀàÁáåÃâÃã';
        $aditionalCaracters .= 'ÈèÉéêêẽËë';
        $aditionalCaracters .= 'ÌìÍíÎî';
        $aditionalCaracters .= 'ÒòÓóÔôøÕõ';
        $aditionalCaracters .= 'ÙùÚúůÛûÜü';
        $aditionalCaracters .= 'çÇ';
        $aditionalCaracters .= 'ñÑ';
        return str_word_count($value, 0, $aditionalCaracters);
    }

    /**
     * Embaralha aleatóriamente os caracteres da string atual.
     *
     * @param string $value String a ser trabalhada
     * @return void
     */
    public static function shuffle($value)
    {
        return str_shuffle($value);
    }

    /**
     * Criptografa a string atual usando o hash md5.
     *
     * @param string $value String a ser trabalhada
     * @return void
     */
    public static function md5($value)
    {
        return md5($value);
    }

    /**
     * Criptografa a string atual usando uma chave como referência.
     *
     * @param string $value String a ser trabalhada
     * @return void
     */
    public static function crypt($value, $salt)
    {
        return crypt($value, $salt);
    }

    /**
     * Troca as quebras de linha por '<br />'.
     *
     * @param string $value String a ser trabalhada
     * @return void
     */
    public static function newLineToBreak($value, $is_xhtml = true)
    {
        return nl2b($value, $is_xhtml);
    }
}
