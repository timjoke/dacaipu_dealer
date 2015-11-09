<?php
    $btp = new busTenpay();
    $reqHandler = $btp->get_request_handler();
    $reqUrl = $reqHandler->getRequestURL();
    
?>
<br/><a href="<?php echo $reqUrl ?>" target="_blank">财付通支付</a>
<form action="<?php echo $reqHandler->getGateUrl() ?>" method="post" target="_blank">
<?php
$params = $reqHandler->getAllParameters();
foreach($params as $k => $v) {
	echo "<input type=\"hidden\" name=\"{$k}\" value=\"{$v}\" />\n";
}
?>
<input type="submit" value="财付通支付">
</form>