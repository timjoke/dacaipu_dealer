<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => '大菜谱',
    'timeZone' => 'Asia/Chongqing',
    'language' => 'zh_cn',
    'defaultController' => 'default',
    // preloading 'log' component
    'preload' => array('log', 'kint'),
    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.components.*',
        'application.business.*',
    ),
    'modules' => array(
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => '123',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters' => array('127.0.0.1', '192.168.*', '::1'),
        ),
    ),
    // application components
    'components' => array(
        'user' => array(
            // enable cookie-based authentication
            'class' => 'MyUser',
            'guestName' => '访客',
            'allowAutoLogin' => true,
            'loginUrl' => '/default/login'
        ),
        'kint' => array(
            'class' => 'ext.Kint.Kint',
        ),
        'yexcel' => array(
            'class' => 'ext.yexcel.Yexcel'
        ),
//        'cache' => array(
//            'class' => 'CMemCache',
//            //'useMemcached' => true,
//            'keyPrefix' => 'dacaipu',
//            'servers' => array(
//                array(
//                    'host' => '192.168.2.10',
////                    'host'=>'127.0.0.1',
//                    'port' => 11211,
//                ),
//            ),
//        ),
        #角色验证组件
//        'authManager' => array(;
//            'class' => 'CDbAuthManager',
//            'itemTable' => 'AuthItem',
//            'itemChildTable' => 'AuthItemChild',
//            'assignmentTable' => 'AuthAssignment',
//            'defaultRoles' => array('CUSTOMER'),
//            'showErrors' => false,
//        ),
        'authManager' => array(
            // Path to SDbAuthManager in srbac module if you want to use case insensitive
            //access checking (or CDbAuthManager for case sensitive access checking)
            'class' => 'application.modules.srbac.components.SDbAuthManager',
            //// The database component used 
            'connectionID' => 'db',
            // The itemTable name (default:authitem) 
            'itemTable' => 'auth_item',
            // The assignmentTable name (default:authassignment)
            'assignmentTable' => 'auth_assignment',
            // The itemChildTable name (default:authitemchild) 
            'itemChildTable' => 'auth_item_child',
            'defaultRoles' => array('访客',),
        ),
        // uncomment the following to enable URLs in path-format
        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            'rules' => array(
                '' => 'site/index',
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ),
        ),
        // uncomment the following to use a MySQL database
        'db' => array(
            'connectionString' => 'mysql:host=192.168.2.10;dbname=dacaipu',
//            'connectionString' => 'mysql:host=127.0.0.1;dbname=dacaipu',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => '123',
            'charset' => 'utf8',
            'enableProfiling' => false,
            'enableParamLogging' => false,
        ),
        'errorHandler' => array(
            // use 'site/error' action to display errors
            'errorAction' => 'site/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error,info',
                ),
            // uncomment the following to show log messages on web pages
            /*
              array(
              'class' => 'CWebLogRoute',
              'levels' => 'error', //级别为trace
              #'categories' => 'system.db.*' //只显示关于数据库信息,包括数据库连接,数据库执行语句
              ),
             */
            ),
        ),
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => array(
        /* 短信参数 - start */
        'sms_server_url' => 'tcp://192.168.2.10:55558',
        'validcode_len' => 6, //短信验证码长度
        'validcode_msg' => '[%s]%s短信验证码，%s分钟内有效！此验证码也是您的登录密码，请妥善保管！', //短信验证码内容格式
        'validcode_ts' => 3, //短信验证码发送间隔/有效时间（分钟）
        /* 短信参数  - end */
        /* 百度地图 api key */
        'baidu_map_key' => '055ef4c97b41083a19d96052acb08cbb',
        'img_upload_dir' => '//img1.dacaipu.cn/www/img1.dacaipu.cn/',
        'local_test' => TRUE,
        'tenpay_partner' => '1900000113',
        'tenpay_key' => 'e82573dc7e6136ba414f2e2affbe39fa',
        'tenpay_return_url' => 'http://dcpct.yong8.cn/tenpay/returnurl',
        'tenpay_notify_url' => 'http://dcpct.yong8.cn/tenpay/notifyurl',
        'tenpay_order_prefix' => 'TEST',
    ),
);
