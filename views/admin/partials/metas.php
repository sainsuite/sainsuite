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

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="IE=edge" http-equiv="X-UA-Compatible">
<meta content="on" http-equiv="cleartype"/>

<!-- Add Scale for mobile devices, -->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<meta name="description" content="<?php echo riake('site_description', $App_Options); ?>" />
<meta name="keywords" content="<?php echo riake('site_keywords', $App_Options); ?>" />
<meta name="author" content="<?php echo $this->aauth->config_vars['name']; ?>" />
<meta name="email" content="<?php echo $this->aauth->config_vars['email']; ?>" />
<meta name="website" content="<?php echo site_url(); ?>" />
<meta name="Version" content="<?php echo get('version'); ?>" />

<meta property="og:url" content="<?php echo site_url();?>">
<meta property="og:type" content="website" />
<meta property="og:title" content="<?php echo riake('site_title', $App_Options); ?>">
<meta property="og:description" content="<?php echo riake('site_description', $App_Options); ?>">
<meta property="og:image" content="<?=asset_url();?>preview.jpg" />
<meta name="og:image" content="<?=asset_url();?>preview.jpg" />

<meta name="twitter:title" content="<?php echo riake('site_title', $App_Options); ?>" />
<meta name="twitter:description" content="<?php echo riake('site_description', $App_Options); ?>" />
<meta property="twitter:image" content="<?=asset_url();?>preview.jpg" />
<meta content="true" name="HandheldFriendly"/>
<meta content="320" name="MobileOptimized"/>
<meta content="yes" name="apple-mobile-web-app-capable"/>
<meta content="black-translucent" name="apple-mobile-web-app-status-bar-style"/>
<meta content="telephone=no" name="format-detection"/>
<meta content="address=no" name="format-detection"/>

<link rel="icon" size="16x16" type="image/png" href="<?php echo $favicon; ?>"/>
<link rel="icon" size="96x96" type="image/png" href="<?php echo $favicon; ?>"/>
<link rel="icon" size="32x32" type="image/png" href="<?php echo $favicon; ?>"/>
<link rel="icon" size="192x192" type="image/png" href="<?php echo $favicon; ?>"/>
<link rel="apple-touch-icon" size="16x16" type="image/png" href="<?php echo $favicon; ?>"/>
<link rel="apple-touch-icon" size="96x96" type="image/png" href="<?php echo $favicon; ?>"/>
<link rel="apple-touch-icon" size="32x32" type="image/png" href="<?php echo $favicon; ?>"/>
<link rel="apple-touch-icon" size="192x192" type="image/png" href="<?php echo $favicon; ?>"/>

<!-- favicon -->
<link rel="shortcut icon" type="image/x-icon" href="<?php echo $favicon; ?>">
<link rel="canonical" href="<?php echo site_url();?>">

<!-- Site Title -->
<title><?php echo Polatan::get_title(); ?></title>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-CJPN0ZD9XT"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'G-CJPN0ZD9XT');
</script>