<?php
/* @var $this DealerWechatReplyContentController */
/* @var $model DealerWechatReplyContent */

$this->breadcrumbs=array(
	'Dealer Wechat Reply Contents'=>array('index'),
	$model->content_id,
);

$this->menu=array(
	array('label'=>'List DealerWechatReplyContent', 'url'=>array('index')),
	array('label'=>'Create DealerWechatReplyContent', 'url'=>array('create')),
	array('label'=>'Update DealerWechatReplyContent', 'url'=>array('update', 'id'=>$model->content_id)),
	array('label'=>'Delete DealerWechatReplyContent', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->content_id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage DealerWechatReplyContent', 'url'=>array('admin')),
);
?>

<h1>View DealerWechatReplyContent #<?php echo $model->content_id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'content_id',
		'dealer_id',
		'content_type',
		'content',
	),
)); ?>
