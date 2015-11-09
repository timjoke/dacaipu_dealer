<?php
/* @var $this DealerWechatReplyContentController */
/* @var $model DealerWechatReplyContent */

$this->breadcrumbs=array(
	'Dealer Wechat Reply Contents'=>array('index'),
	$model->content_id=>array('view','id'=>$model->content_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List DealerWechatReplyContent', 'url'=>array('index')),
	array('label'=>'Create DealerWechatReplyContent', 'url'=>array('create')),
	array('label'=>'View DealerWechatReplyContent', 'url'=>array('view', 'id'=>$model->content_id)),
	array('label'=>'Manage DealerWechatReplyContent', 'url'=>array('admin')),
);
?>

<h1>Update DealerWechatReplyContent <?php echo $model->content_id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>