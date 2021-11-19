<?php
$BUTTONS = isset($BUTTONS) ? $BUTTONS : true;
?>
    <div class="sidebar pull-right">
<?php if ($BUTTONS) { ?>
        <div class="front-page-button flush-right">
<p>
<?php
    if ($cfg->getClientRegistrationMode() != 'disabled'
        || !$cfg->isClientLoginRequired()) { ?>
             <a href="open.php" style="display:block; text-align: left;" class="blue button"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-plus-fill" viewBox="0 -1 17 16">
  <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0zM9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1zM8.5 7v1.5H10a.5.5 0 0 1 0 1H8.5V11a.5.5 0 0 1-1 0V9.5H6a.5.5 0 0 1 0-1h1.5V7a.5.5 0 0 1 1 0z"/>
</svg><?php
                echo __(' Abrir un nuevo Ticket');?></a>
</p>
<?php } ?>
<p>
            <a href="view.php" style="display:block; text-align: left;" class="green button"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 -2 20 16">
  <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
</svg><?php
                echo __(' Ver estado de Ticket');?></a>
</p>
<p>
             <a href="./login.php" style="display:block; background-color: red; text-align: left;" class="red button">
<svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" fill="currentColor" class="bi bi-envelope" viewBox="0 -2 16 16" style="margin-right: 5px;">
  <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z"/>
</svg>

<?php
                echo __(' Iniciar Sesión');?> </a>
</p>
        </div>
<?php } ?>
        <div class="content"><?php
    if ($cfg->isKnowledgebaseEnabled()
        && ($faqs = FAQ::getFeatured()->select_related('category')->limit(5))
        && $faqs->all()) { ?>
            <section><div class="header"><?php echo __('Featured Questions'); ?></div>
<?php   foreach ($faqs as $F) { ?>
            <div><a href="<?php echo ROOT_PATH; ?>kb/faq.php?id=<?php
                echo urlencode($F->getId());
                ?>"><?php echo $F->getLocalQuestion(); ?></a></div>
<?php   } ?>
            </section>
<?php
    }
    $resources = Page::getActivePages()->filter(array('type'=>'other'));
    if ($resources->all()) { ?>
            <section><div class="header"><?php echo __('Other Resources'); ?></div>
<?php   foreach ($resources as $page) { ?>
            <div><a href="<?php echo ROOT_PATH; ?>pages/<?php echo $page->getNameAsSlug();
            ?>"><?php echo $page->getLocalName(); ?></a></div>
<?php   } ?>
            </section>
<?php
    }
        ?></div>
    </div>