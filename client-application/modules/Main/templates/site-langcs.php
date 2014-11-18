<?php
ob_start();
$sm = $this->getServiceManager();
$templatesEscaper = $sm->get('templatesEscaper');
?>
lsite.langcs = []
<?php
$langConstants = $sm->get('lang')->getLangConstants();
foreach ($langConstants as $langConstantName => $langConstantValue) :
?>
lsite.langcs['<?= $templatesEscaper->escapeJS($langConstantName); ?>'] = '<?= $templatesEscaper->escapeJS($langConstantValue); ?>';<?= "\r\n"; ?>
<?php
endforeach;
$templateString = ob_get_contents();
ob_end_clean();
return $templateString;