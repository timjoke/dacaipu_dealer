<?php
/* @var $this PayController */

$this->breadcrumbs=array(
	'Pay'=>array('/tenpay'),
	'ReturnUrl',
);
?>
<h1><?php echo $result->msg; ?></h1>

<p>
    <span id="sp_seconds">5</span> 秒钟后返回首页。
</p>

<script type="text/javascript">
    setTimeout('location.href="/"',5000);
    function roll_second()
    {
        $second = parseInt($('#sp_seconds').val());
        if($second > 0)
        {
            $('#sp_seconds').val($second-1);
            
            roll_second();
            
            setTimeout('roll_second();',1000);
        }
    }
    
    roll_second();
</script>
