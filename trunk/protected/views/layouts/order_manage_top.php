<?php
Yii::app()->clientScript->registerCssFile($this->get_static_url() . 'pc/css/jquery.loadmask.css');
Yii::app()->clientScript->registerScriptFile($this->get_static_url() . 'js/jquery.loadmask.js');
Yii::app()->clientScript->registerScript('neworders2', 'refreshNewOrders();');
Yii::app()->clientScript->registerScript('timer', 'setInterval("flashrightarea()",500);');
Yii::app()->clientScript->registerScript('neworders', 'setInterval("refreshNewOrders()",10000);');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>大菜谱</title>        
        <script type="text/javascript">
            function menuBarClick()
            {
                var $menuBar = $(".menuBar");
                var $leftArea = $(".LeftArea");
                var $middleArea = $(".MiddleArea");
                var ishide = $leftArea.is(":hidden");
                if (ishide == false)
                {
                    $leftArea.hide("slide");//隐藏侧边栏     
                    $menuBar.css("background-image", "url(<?php echo $this->get_static_url(); ?>pc/images/mini-right.png)");//图标箭头向右
                    $middleArea.css("width", "76%");
                }
                else
                {
                    $leftArea.show("slide");//显示侧边栏
                    $menuBar.css("background-image", "url(<?php echo $this->get_static_url(); ?>pc/images/mini-left.png)");//图标箭头向左
                    $middleArea.css("width", "63%");
                }

            }

            // 使用message对象封装消息  
            var message = {
                time: 0,
                title: document.title,
                timer: null,
                count: 0,
                // 显示新消息提示   
                show: function() {
                    var title = message.title.replace("【          】", "").replace("【您有" + message.count + "条订单待处理】", "");
                    // 定时器，设置消息切换频率闪烁效果就此产生   
                    message.timer = setTimeout(
                            function() {
                                message.time++;
                                message.show();
                                if (message.time % 2 == 0) {
                                    document.title = "【您有" + message.count + "条新的订单】" + title;
                                }
                                else {
                                    document.title = "【          】" + title;
                                }
                            },
                            600 // 闪烁时间差  
                            );
                    return [message.timer, message.title];
                },
                // 取消新消息提示   
                clear: function() {
                    clearTimeout(message.timer);
                    document.title = message.title;
                }
            };

            $(document).ready(function() {
                changeDivHeight();
                window.onresize = function() {
                    changeDivHeight();
                };
            });
            function changeDivHeight() {
//                var h = document.documentElement.clientHeight;//获取页面可见高度$('#complete').css('height');//
//                var headerHeight = $($(".HeaderArea").get(0)).css('height');
//                headerHeight = headerHeight.replace('px', '');
//                $($(".LeftArea").get(0)).css('height', h - headerHeight + 'px');
//高度
                var n;
                if (window.innerHeight) {//FF
                    n = window.innerHeight;
                } else {
                    n = document.documentElement.clientHeight;
                }
                var m = n - $($(".HeaderArea").get(0)).css('height').replace('px', '') - 1;
                $(".LeftArea").css("height", m);
                $(".menuBar").css("height", m);
                $(".MiddleArea").css("height", m);
            }
            
             
        </script>
    </head>
    <body>
        <div id="complete" style="min-width: 1024px; min-height: 500px;" >
            <div class="HeaderArea">
                <div class="LogoArea">
                    <?php
                    $dealer_id = $this->getDealerId();
                    $model = Dealer::model()->findByPk($dealer_id);
                    echo $model->dealer_name;
                    ?>

                </div>
                <div class="MenuArea">
                    <em id="tab_order" class="Ico_1" style="width: 180px;"><a href="<?php echo Yii::app()->request->hostInfo ?>/orders/index">网络订单处理</a></em>
                    <em id="tab_dealer" class="Ico_2" style="width: 180px;"><a href="<?php echo Yii::app()->request->hostInfo ?>/dishCategory/index">餐厅信息维护</a></em>
                    <em id="tab_report" class="Ico_3" style="width: 150px;"><a href="<?php echo Yii::app()->request->hostInfo ?>/Report/orderReport">报表分析</a></em>
                </div>  
                <div class="MemberArea">
                    <em style="cursor:pointer"
                        onclick="window.location.href = '<?php echo Yii::app()->request->hostInfo ?>/dealer/update/areaid/updatedealer'">
                        <?php echo Yii::app()->user->name; ?>，你好</em>
                    <em style="cursor:pointer"
                        onclick="window.location.href = '<?php echo Yii::app()->request->hostInfo ?>/dealer/reset_password'">
                        修改密码
                    </em>
                    <em style="cursor:pointer"
                        onclick="window.location.href = '<?php echo Yii::app()->request->hostInfo ?>/default/logout'">
                        退出
                    </em>
                </div>
            </div>

            <?php echo $content; ?>  
            <div class="RightArea" id="rightAreaTop" style="height:37px;">
                <h2 id="rightMsg">订单消息</h2>
            </div>
        </div>
        <div id="div_dialog" style="display:none;">
            <h2 class="title"><span id="dialog_title"></span>
                <span  class="CloseBtn">X</span></h2>            
            
        </div>
        <div id="iframe_layer" style="display:none;top:0;left:0;position: fixed;height: 100%;width: 100%;background:transparent; ">
		<div id='iframe_div' style="position:relative;">
			<div style="border-bottom:3px solid #9b1212;height:30px"><p id='iframe_title' style="height: 30px;margin: 0;"></p></div>
		</div>		
	</div>
        <div id="div_alert_dialog" style="display: none;">
            <span id="alert_dialog_message"></span>
        </div>
        <div id="div_confirm_dialog" style="display: none;">
            <span id="confirm_dialog_message"></span>
        </div>
        <audio name="order_audio" id="order_audio" src="<?php echo $this->get_static_url(); ?>pc/images/order2.mp3" type="audio/mpeg"/>
        <div style="clear: both"></div>
    </body>
</html>
