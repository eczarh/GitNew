<?php
ob_start();
$sm = $this->getServiceManager();
$templatesEscaper = $sm->get('templatesEscaper');
?>
<h1>It works</h1>
<?php
$templateString = ob_get_contents();
ob_end_clean();
return $templateString;