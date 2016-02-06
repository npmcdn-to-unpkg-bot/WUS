<div class="personnal-menu">
    <div class="last-article-link active clickable">Derniers Articles</div>
    <div class="subscriptions-list-link clickable">Mes Abonnements</div>
</div>
<div class="data">
    <div class="last-article">
        <?php

        	require_once(dirname(__FILE__) . "/ajax/controller.last_article.php");
            echo lastArticle();

        ?>
    </div>
    <div class="subscriptions-list">
        <?php

            /*require_once(dirname(__FILE__) . "/ajax/controller.subscription.php");
            echo subscriptionsList();*/

        ?>
    </div>
</div>