<div>
    <?php
    echo CHtml::encode($data['table_name']);
    if ($data['orderCount'] > 0) {
        echo sprintf('<span style="cursor:pointer" onclick="openDialogAuto(\'viewTableByOrdersIndex?table_id=%u&reserv_date=%s&tablename=%s\',\'auto\',\'auto\',\'查看桌台订单\'); return false;">查看订单(%u)</span>'
                , $data['table_id'], $reserv_date, $data['table_name'], $data['orderCount']);
    }
    ?>
</div>
