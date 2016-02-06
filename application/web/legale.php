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
        <link rel="shortcut icon" title="shortcut icon" type="image/png" href=<?php  echo $this->config->favicon; ?> />
        <title><?php  echo $this->config->meta->title; ?></title>
        <?php $this->loadCSS(); ?>

    </head>
    
    <body>        
    	
        <page>

            <?php include('header.php'); ?>

            <?php
                require_once(dirname(__FILE__) . "/php/class.document.php");

                global $app;
                global $bdd;
                global $_TABLES;



                $content_html = "<content>
                                    <div class='options'>
                                    </div>
                                    <div class='articles'>
                                        %%document%%
                                    </div>
                                    <div class='informations'>
                                    </div>
                                </content>";

                $name = $app->router()->getCurrentRoute()->getParams()['name'];

                if(!is_null($bdd) && !is_null($_TABLES)) {
                    $objDocument = new Document($bdd, $_TABLES);
                    $item = $objDocument->getDocument($name);

                    if(!is_null($item)) {
                        $iframe = $item->path;
                        $content_html = str_replace('%%document%%', $iframe, $content_html);
                        echo($content_html);
                    }
                    else {
                        // 404
                        echo "404 Not Found";
                    }
                }
                else {
                    error_log("BDD ERROR : " . $bdd);
                    error_log("TABLES ERROR : " . $_TABLES);
                }
            ?>

            <?php include('footer.php'); ?>
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