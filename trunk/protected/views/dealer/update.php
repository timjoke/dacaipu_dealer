<?php

$this->renderPartial('_form', array('dealer_takeout' => $dealer_takeout,
    'weixin_subscribe' => $weixin_subscribe, 'auto_accept_order' => $auto_accept_order,
    'send_message_accepted_order' => $send_message_accepted_order,
    'model' => $model, 'picurl_logo' => $picurl_logo,
));
?>