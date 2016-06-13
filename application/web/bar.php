<?php
                require_once(dirname(__FILE__) . "/php/class.bar.php");

                global $app;
                global $bdd;
                global $_TABLES;

                $content_html = "
                <!DOCTYPE html>
                <html xmlns:og=\"http://ogp.me/ns#\">
                    <head>
                        <meta charset=\"utf-8\" />
                        <meta name=\"google-site-verification\" content=\"vsJj-7905o1qp71_AeKEM0_pZrA_eY52zxnnuKr3Ouk\" />
                        <meta name=\"description\" content=\"" . $this->config->meta->description . "\" />
                        <meta property=\"og:title\" content=\"%%article_title%%\" />
                        <meta property=\"og:type\" content=\"article\" />            
                        <meta property=\"og:url\" content=\"%%article_url%%\" />
                        <meta property=\"og:image\" content=\"%%article_image%%\" />
                        <meta property=\"og:image:height\" content=\"%%article_image_height%%\" />
                        <meta property=\"og:image:width\" content=\"%%article_image_width%%\" />
                        <meta property=\"og:description\" content=\"%%article_description%%\" />
                        <meta property=\"og:site_name\" content=\"%%article_website%%\" />
                        <meta property=\"og:locale\" content=\"fr_FR\" />  

                        <link rel=\"shortcut icon\" title=\"shortcut icon\" type=\"image/png\" href=\"" . $this->config->favicon . "\" />
                        <title>" . $this->config->meta->title . "</title>
                        " . $this->loadCSS() . "

                    </head>
                    
                    <body>        
                        
                        <page>
                                <header class='bar'>
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
                                            <span id='share_text' onclick=\"window.open('https://www.facebook.com/sharer/sharer.php?u=%%url_share%%', 'facebook_share', 'height=320, width=640, toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, directories=no, status=no');\">Partage cet article</span>
                                        </div>
                                        <div class='link'>
                                            <span href='#' id='share' onclick=\"window.open('https://www.facebook.com/sharer/sharer.php?u=%%url_share%%', 'facebook_share', 'height=320, width=640, toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, directories=no, status=no');\"></span>
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
                        $content_html = str_replace('%%url_share%%', ('http://' . $_SERVER['HTTP_HOST'] . $app->router()->getCurrentRoute()->getName() . $to . '#' . $item->url), $content_html);

                        $content_html = str_replace('%%article_title%%', $item->title, $content_html);
                        $content_html = str_replace('%%article_url%%', ('http://' . $_SERVER['HTTP_HOST'] . $app->router()->getCurrentRoute()->getName() . $to . '#' . $item->url), $content_html);
                        $content_html = str_replace('%%article_description%%', $item->description, $content_html);
                        $content_html = str_replace('%%article_website%%', $item->website, $content_html);
                        $content_html = str_replace('%%article_image%%', $item->image, $content_html);
                        $content_html = str_replace('%%article_image_height%%', $item->height_image, $content_html);
                        $content_html = str_replace('%%article_image_width%%', $item->width_image, $content_html);

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