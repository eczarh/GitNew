<?php
ob_start();
$sm = $this->getServiceManager();
$templatesEscaper = $sm->get('templatesEscaper');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head>
<title><?= $sm->get('lang')->get('error-404-metatitle'); ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/css/error-404.css" rel="stylesheet" type="text/css" />
</head>
<body> 		
<div class="rr">
<div class="iss" >
<div class="main">
<div class="height-rr" style="background:url('/i/error-404/<?= $sm->get('lang')->getLangCode() ?>.png') center bottom no-repeat;">&nbsp;</div>
<div class="jump">&nbsp;</div>
<div class="mb-errors">
<div class="title-erbl"><?= $sm->get('lang')->get('error-404-title'); ?></div>
<div class="text-erbl">
<p><?= $sm->get('lang')->get('error-404-text'); ?></p>
<p><a href="<?= $sm->get('lang')->getLangUrl(); ?>" title="<?= $sm->get('lang')->get('mainpage_start'); ?>"><?= $sm->get('lang')->get('mainpage_start'); ?></a></p>
</div>
</div>
</div>
</div>
<div class="ih"></div>
</div>			
</body>	
</html>
<?php
$templateString = ob_get_contents();
ob_end_clean();
return $templateString;