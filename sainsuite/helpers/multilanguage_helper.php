<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * SainSuite
 *
 * Engine Management System
 *
 * @package     SainSuite
 * @author	    Buddy Winangun
 * @license	    MIT License. For full terms see the file LICENSE.
 * @link        https://github.com/saintekno/sainsuite
 * @filesource
 */

if (! function_exists('translate')) 
{
    // Alias of "translate"
    function __($code, $templating = 'core')
    {
        return translate($code, $templating);
    }

    // Alias of __, but echo instead
    function _e($code, $templating = 'core')
    {
        echo __($code, $templating);
    }

    // Echo Translation filtered with addslashes
    function _s($code, $templating = 'core' )
    {
        return addslashes(__($code, $templating));
    }

    /**
     * Get translated text
    **/
    function translate($code, $textdomain = 'core')
    {
        $instance = get_instance();
        global $LangFileHandler, $PoParsed;

        $text_domains = $instance->config->item('text_domain');

        if (in_array($textdomain, array_keys($text_domains))) 
        {
            $lang_file = $text_domains[ $textdomain ] . '/' . $instance->config->item('site_language') . '.po';

            if ( is_file($lang_file) ) {
                if (! isset($LangFileHandler[ $textdomain ])) {
                    $LangFileHandler[ $textdomain ] = new Sepia\FileHandler($lang_file);
                    $PoParsed[ $textdomain ] = new Sepia\PoParser($LangFileHandler[ $textdomain ]);
                    $PoParsed[ $textdomain ]->parse();
                    $PoParsed[ $textdomain ]->AllEntries = $PoParsed[ $textdomain ]->entries();

                    foreach ($PoParsed[ $textdomain ]->AllEntries as $key => $entry) {
                        $newKey = str_replace('<##EOL##>', '', $key);
                        if ($key !== $newKey) 
                        {
                            $PoParsed[ $textdomain ]->AllEntries[ $newKey ] = $entry;
                            unset($PoParsed[ $textdomain ]->AllEntries[ $key ]); //unset key
                        }
                    }
                }

                return implode('', riake('msgstr', riake($code, $PoParsed[ $textdomain ]->AllEntries, array( 'msgstr' => array( $code ) ))));
            }
        }
        return $code;
    }
}