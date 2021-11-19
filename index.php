<?php
require('client.inc.php');

require_once INCLUDE_DIR . 'class.page.php';

$section = 'home';
require(CLIENTINC_DIR.'header.inc.php');
?>
<div id="landing_page">
<?php include CLIENTINC_DIR.'templates/sidebar.tmpl.php'; ?>
<div class="main-content">
<?php
if ($cfg && $cfg->isKnowledgebaseEnabled()) { ?>
<div class="search-form">
    <form method="get" action="kb/faq.php">
    <input type="hidden" name="a" value="search"/>
    <input type="text" name="q" class="search" placeholder="<?php echo __('Search our knowledge base'); ?>"/>
    <button type="submit" class="green button"><?php echo __('Search'); ?></button>
    </form>
</div>
<?php } ?>
<div class="thread-body">

    <!-- <?php
    if($cfg && ($page = $cfg->getLandingPage()))
        echo $page->getBodyWithImages();
    else
        echo  '<h1>'.__('Welcome to the Support Center').'</h1>';
    ?> -->
    </div>

    <h1>Bienvenido al centro de Soporte de UTLD</h1>
    <p style="text-align: justify; text-justify: inter-word;">
    Para poder brindarle soporte técnico, la Universidad Tecnológica de la
    Laguna Durango utiliza un sistema de Tickets. Se le asignará un <strong>número</strong>
    de identificación a su solicitud, <strong>asegurese de recordar ese número</strong> para 
    poder revisar su pedido más tarde, ya sea para ver comentarios del encargado de soporte,
    reenviar la solicitud, agregar comentarios al encargado, o cancelar su solicitud.
    <hr>
    
    Si usted tiene un problema, y no lo ha reportado, haga click en <strong>Abrir un nuevo ticket.</strong>
    <br>
    Si usted tiene un problema, y no lo ha solucionado, haga click <strong>Ver Estado de un ticket</strong>
    </p>
</div>
<div class="clear"></div>

<div>
<?php
if($cfg && $cfg->isKnowledgebaseEnabled()){
    //FIXME: provide ability to feature or select random FAQs ??
?>
<br/><br/>
<?php
$cats = Category::getFeatured();
if ($cats->all()) { ?>
<h1><?php echo __('Featured Knowledge Base Articles'); ?></h1>
<?php
}

    foreach ($cats as $C) { ?>
    <div class="featured-category front-page">
        <i class="icon-folder-open icon-2x"></i>
        <div class="category-name">
            <?php echo $C->getName(); ?>
        </div>
<?php foreach ($C->getTopArticles() as $F) { ?>
        <div class="article-headline">
            <div class="article-title"><a href="<?php echo ROOT_PATH;
                ?>kb/faq.php?id=<?php echo $F->getId(); ?>"><?php
                echo $F->getQuestion(); ?></a></div>
            <div class="article-teaser"><?php echo $F->getTeaser(); ?></div>
        </div>
<?php } ?>
    </div>
<?php
    }
}
?>
</div>
</div>

<?php require(CLIENTINC_DIR.'footer.inc.php'); ?>
