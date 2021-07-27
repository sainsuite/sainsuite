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
    
$App_Options = options(APPNAME);
$favicon = ($favicon = riake('favicon', $App_Options)) ? upload_url('media/thumb/'.$favicon) : upload_url('system/favicon.png', base_url());
?>

<!-- favicon -->
<link rel="shortcut icon" type="image/x-icon" href="<?php echo $favicon; ?>">
<link rel="canonical" href="<?php echo site_url();?>">
    
<!-- Site Title -->
<title><?php echo ($title = riake('site_title', $App_Options)) ? $title.' - ' : ''; ?> <?php echo riake('site_name', $App_Options); ?></title>