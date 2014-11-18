<?php
ob_start();
$sm = $this->getServiceManager();
$templatesEscaper = $sm->get('templatesEscaper');
if (count($navigation) > 0):
?><ul><?php
    foreach ($navigation as $navigationElement) {
        echo '<li>';
        if (empty($navigationElement['link'])) {
            echo '<span>' . $templatesEscaper->escapeHtml($navigationElement['title']) . '</span>';
        } else {
            echo '<a href="'. $templatesEscaper->escapeHtmlAttr($navigationElement['link']) . '" title="' . $templatesEscaper->escapeHtmlAttr($navigationElement['title']) . '">' . $templatesEscaper->escapeHtml($navigationElement['title']) . '</a>';
        }
        echo '</li>';
    }
?></ul><?php
endif;
$templateString = ob_get_contents();
ob_end_clean();
return $templateString;