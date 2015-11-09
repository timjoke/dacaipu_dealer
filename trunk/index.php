<?php

// change the following paths if necessary
$yii=dirname(__FILE__).'/../yii/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/main.php';

require dirname(__FILE__).'/protected/business/enum.php';
require dirname(__FILE__).'/protected/business/errorCode.php';
require dirname(__FILE__).'/protected/business/busOrder.php';
require dirname(__FILE__).'/protected/business/busSms.php';
require dirname(__FILE__).'/protected/business/busDiscount.php';
require dirname(__FILE__).'/protected/business/busBaiduMap.php';
require dirname(__FILE__).'/protected/business/busDish.php';
require dirname(__FILE__).'/protected/business/busDishCategory.php';
require dirname(__FILE__).'/protected/business/busUlitity.php';
require dirname(__FILE__).'/protected/business/busWechat.php';
require dirname(__FILE__).'/protected/business/busValidcode.php';
require dirname(__FILE__).'/protected/business/operResult.php';
require dirname(__FILE__).'/protected/business/busCoupon.php';
require dirname(__FILE__).'/protected/business/busKingHand.php';


// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);

require dirname(__FILE__).'/protected/business/MyUser.php';

Yii::createWebApplication($config)->run();