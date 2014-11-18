<?php
ob_start();
$sm = $this->getServiceManager();
$templatesEscaper = $sm->get('templatesEscaper');
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
    <title><?php echo $templatesEscaper->escapeHtml($sm->get('LSite\Main\Seo')->getPageTitle()); ?></title>
<?php 
$metaKeywords = $sm->get('LSite\Main\Seo')->getMetaKeywords();
$metaDescription = $sm->get('LSite\Main\Seo')->getMetaDescription();
if (!empty($metaKeywords)) :
?>
<meta http-equiv="keywords" content="<?php echo $templatesEscaper->escapeHtml($metaKeywords);?>" />
<?php 
endif; 
if (!empty($metaDescription)) :
?>
<meta http-equiv="description" content="<?php echo $templatesEscaper->escapeHtml($metaDescription);?>" />
<?php 
endif; 
?>
<script type="text/javascript" src="/js/jquery.js"></script>
<script type="text/javascript" src="/js/init.js"></script>
<script type="text/javascript">
lsite.languriprefix = '<?php echo $templatesEscaper->escapeJs($sm->get('lang')->getLangUrl()); ?>';
</script>
<script type="text/javascript" src="<?php echo $sm->get('lang')->getLangUrl(); ?>js/site-langcs.js"></script>
<?php
$headElements = $sm->get('LSite\Main\HtmlHead')->getHeadElements();
if (count($headElements) > 0) {
    foreach ($headElements as $headElement) {
        echo $headElement . PHP_EOL;
    }
}
?>
</head>
<body>
<?php echo $resultContent; ?>
</body>
</html>
<?php
$templateString = ob_get_contents();
ob_end_clean();
return $templateString;