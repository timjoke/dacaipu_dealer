<?php
/* @var $this DealerWechatReplyContentController */
/* @var $model DealerWechatReplyContent */

$this->breadcrumbs=array(
	'Dealer Wechat Reply Contents'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List DealerWechatReplyContent', 'url'=>array('index')),
	array('label'=>'Manage DealerWechatReplyContent', 'url'=>array('admin')),
);
?>

<h1>Create DealerWechatReplyContent</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>