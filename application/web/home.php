<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="google-site-verification" content="vsJj-7905o1qp71_AeKEM0_pZrA_eY52zxnnuKr3Ouk" />
        <meta name="description" content="<?php  echo $this->config->meta->description; ?>" />
        <meta property="og:title" content="<?php  echo $this->config->og->title; ?>" />
        <meta property="og:type" content="<?php  echo $this->config->og->type; ?>" />
        <meta property="og:url" content="<?php  echo $this->config->og->url; ?>" />
        <meta property="og:image" content="<?php  echo $this->config->og->image; ?>" />
        <meta property="og:description" content="<?php  echo $this->config->og->description; ?>" />
        <meta property="og:site_name" content="<?php  echo $this->config->og->site_name; ?>" />
        <meta name=”viewport” content=”width=device-width, initial-scale=1”>
        <link rel="shortcut icon" title="shortcut icon" type="image/png" href=<?php  echo $this->config->favicon; ?> />
        <title><?php  echo $this->config->meta->title; ?></title>
        <?php $this->loadCSS(); ?>

    </head>
    
    <body>        
    	
        <page>
    	    <?php require('header.php'); ?>
    	    <?php require('content.php'); ?>
    	    <?php require('footer.php'); ?>
            <input type='hidden' id='is_connect' value="0" />
        </page>

        <?php $this->loadJS(); ?>

        <noscript>
            <div id="noscript-content">
                <div id="noscript">Veuillez activer le Javascript de votre navigateur Web.
                </div>
            </div>
        </noscript>

    </body>
</html>