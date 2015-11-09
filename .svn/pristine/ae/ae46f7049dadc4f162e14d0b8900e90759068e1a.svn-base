<style>
    li {
        list-style-type: none;
        float: left;
        width: 170px;
        margin-left: 20px;
        line-height: 25px;
    }
</style>
<div class="MiddleArea">
    <div class="ContentArea">
        <h2><span>查看套餐</span>
            <em class="Btn">
                <a href="#"  onclick="openDialogAuto('/dish/create/2', 'auto', 'auto', '套餐信息添加');
                        return false;"><strong>+</strong>添加套餐</a>
            </em>
            <em class="Btn">
                <a href="javascript:save();">保存</a>
            </em>
        </h2> 
        <div class="ContArea">
            <div class='BlockArea_4' style="padding-left:15px;padding-bottom:15px;">

                <span class="searchTitle">套餐名称：</span>
                <?php
                //$dish_data = CHtml::listData($all_dish_package, 'dish_id', 'dish_name');
                echo CHtml::dropDownList('dish_select', '', $all_dish_package, array('style' => 'width:200px;'));
                ?><span style="color:red;">&nbsp;&nbsp;(逗号后面表示套餐中最多菜品选择数量)</span>

            </div>

            <div class='BlockArea_4' style="padding-left:15px;padding-bottom:15px;">
<!--                <div><input type="checkbox" id="allSelect" class="checkbox">全选</div>-->
                <ul>
                    <?php
                    foreach ($all_dish as $key => $value)
                    {
                        ?>
                        <li height="31" style="vertical-align: middle;">
                            <div>
                                <input type="checkbox" id="<?php echo $key ?>" name="selectcb" class="checkbox">
                                <?php echo $value ?>
                            </div> 
                        </li>
                    <?php } ?>
                </ul>
                <div style="clear:both"></div>
            </div>
        </div>
    </div>
</div>


<script>
    document.getElementById('dish_select').onchange = function(event)
    {      
        $.get('getPackageDish/' + event.target.value, function(result)
        {
            if (result != '-1')
            {
                //document.getElementById('btnSave').disabled = false;
                selectCheckBoxByValue(false);
                var epc = eval("(" + result + ")");
                for (i = 0; i < epc.length; i++)
                {
                    document.getElementById(epc[i].dish_id).checked = true;
                }
            }
            else
            {
                alert('获取数据失败！');
                //document.getElementById('btnSave').disabled = true;
            }
        });
    };

    function save() {
        var dish_dropdown_list = document.getElementById('dish_select');
        var dish_id = dish_dropdown_list.value;
        if (dish_id == 0)
        {
            alert('请先选择套餐名称');
            return;
        }
        
        var select_count = parseInt(dish_dropdown_list.selectedOptions[0].label.split("-")[1]);
        if(getCheckedCount()< select_count)
        {
            alert('选择的菜品数量应不少于套餐的最多数量');
            return;
        }
        var allcbs = document.all['selectcb'];
        if (allcbs.length)
        {
            var selectDishStr = '';
            for (var i = 0; i < allcbs.length; i++)
            {
                if (allcbs[i].checked)
                {
                    selectDishStr += allcbs[i].id + ',';
                }
            }
            if (selectDishStr != '')
            {
                selectDishStr = selectDishStr.substr(0, selectDishStr.length - 1);
            }
        }
        $.post('UpdatePackageDish', {dish_id: dish_id, dish_id_select: selectDishStr}, function(result) {
            if (result == '-1')
            {
                alert('保存失败！');
            }
            else
            {
                alert('保存成功！');
            }
        });
    }
    ;

    function selectCheckBoxByValue(value)
    {
        var allcbs = document.all['selectcb'];
        if (allcbs.length)
        {
            for (var i = 0; i < allcbs.length; i++)
            {
                allcbs[i].checked = value;
            }
        }
    }
    
    function getCheckedCount()
    {
        var count = 0;
        var allcbs = document.all['selectcb'];
        if (allcbs.length)
        {
            for (var i = 0; i < allcbs.length; i++)
            {
                if(allcbs[i].checked)
                {
                    count++;
                }
            }
        }
        return count;
    }
</script>