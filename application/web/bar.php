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

            <?php
                require_once(dirname(__FILE__) . "/php/class.bar.php");

                global $app;
                global $bdd;
                global $_TABLES;

                $content_html = "<header class='bar'>
                                    <div class='site'>
                                        <div class='logo_site'>
                                            <img src='%%logo_site%%' alt='%%alt_logo_site%%'>
                                        </div>
                                        <div class='informations_site'>
                                            <div class='title'>
                                                <label class='title'>%%title_site%%</label>
                                            </div>
                                            <div class='button'>
                                                <a href='#' id='sabonner_site'></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='menu'>
                                        <a href='#' id='menu'></a>
                                    </div>
                                    <div class='logo'>
                                        <a href='#' title='logo' id='logo'></a>
                                    </div>
                                    <div class='social'>
                                        <div class='title'>
                                            <a href='#' id='share_text'>Partage cet article</a>
                                        </div>
                                        <div class='link'>
                                            <a href='#' id='share'></a>
                                        </div>
                                    </div>
                                </header>
                                <content>
                                    <div class='div-iframe'>%%iframe%%</div>
                                </content>";

                $to = $app->router()->getCurrentRoute()->getParams()['to'];
                $guid = str_replace('/', '', explode('#', $to)[0]);

                if(!is_null($bdd) && !is_null($_TABLES)) {
                    $bar = new Bar($bdd, $_TABLES);
                    $item = $bar->getItem($guid);

                    if(!is_null($item)) {
                        $iframe = "<iframe width='100%' height='100%' scrolling='auto' frameborder='0' src=" . $item->url . "></iframe>";
                        $content_html = str_replace('%%iframe%%', $iframe, $content_html);
                        $content_html = str_replace('%%logo_site%%', $item->logo, $content_html);
                        $content_html = str_replace('%%alt_logo_site%%', $item->website, $content_html);
                        $content_html = str_replace('%%title_site%%', $item->website, $content_html);
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