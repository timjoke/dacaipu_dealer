<?php

$this->renderPartial('_dealerTableOrderForm', array('dinner_table_name' => $dinner_table_name, 'reserv_date' => $reserv_date,
    'timepointlist' => $timepointlist, 'time_point' => $time_point,
    'contact_name' => $contact_name, 'contact_tel' => $contact_tel, 'isNewRecord' => $isNewRecord));
?>