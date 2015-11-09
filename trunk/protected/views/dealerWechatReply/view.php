<?php
/* @var $this DealerWechatReplyController */
/* @var $model DealerWechatReply */

$this->breadcrumbs=array(
	'Dealer Wechat Replies'=>array('index'),
	$model->reply_id,
);

$this->menu=array(
	array('label'=>'List DealerWechatReply', 'url'=>array('index')),
	array('label'=>'Create DealerWechatReply', 'url'=>array('create')),
	array('label'=>'Update DealerWechatReply', 'url'=>array('update', 'id'=>$model->reply_id)),
	array('label'=>'Delete DealerWechatReply', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->reply_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage DealerWechatReply', 'url'=>array('admin')),
);
?>

<h1>View DealerWechatReply #<?php echo $model->reply_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'reply_id',
		'dealer_id',
		'operat',
		'keyword',
		'content_id',
	),
)); ?>
