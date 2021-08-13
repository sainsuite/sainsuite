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
    
?>

<!DOCTYPE html>
<HTML class="no-js" lang="en">
<HEAD>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="IE=edge" http-equiv="X-UA-Compatible">
    <meta content="on" http-equiv="cleartype"/>

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <?php include('partials/meta.php');?>
    
    <link rel="stylesheet" href="<?=fasset_url();?>css/style.bundle.css" type="text/css" />
</HEAD>
<BODY class="body">
    <div id="wrapper">
        <div id="content">
            <?php include('partials/header.php');?>
            
            <?php include('pages/'.$pages.'.php');?>
        </div>
    </div>

    <!-- javascript -->
    <script src="<?=fasset_url();?>js/plugins.bundle.js" type="text/javascript"></script>
    <script src="<?=fasset_url();?>js/scripts.bundle.js" type="text/javascript"></script>
</BODY>
</HTML>