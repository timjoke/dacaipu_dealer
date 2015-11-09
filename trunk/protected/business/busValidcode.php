<?php

require_once  'carbon.php';
use Carbon\Carbon;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * busValidcode 的注释
 *
 * @作者 roy
 */
class busValidcode
{
    public function check()
    {
        $result = new OperResult();
        $session_id = Yii::app()->session->sessionId;
        
        $session_key = 'validcode_status'.$session_id;
        $last_valid_time = Yii::app()->session[$session_key];
        $validcode_ts = Yii::app()->params['validcode_ts'];
        $now = new Carbon();
        if(isset($last_valid_time))
        {
            $ts = $now->diffInSeconds($last_valid_time);
            if($now > $last_valid_time && $ts <= $validcode_ts*60)
            {
                //失败，未达到时间间隔
                $result->code = SUCCESS;
                $result->seconds = $validcode_ts * 60-$ts;
                $result->message = '未到可发送间隔';
            }
            else
            {
                $result->code = 1;
            }
        }
        else
        {
            $result->code = 1;
        }
        
        return $result;
    }
    
    
    /*
     * 发送短信验证码
     */
    public function send_validcode($mobile,$dealer_id)
	{
        $result = new OperResult();
        $dealer = Dealer::model()->findByPk($dealer_id);
        if((!isset($dealer)) || 
                $dealer->dealer_status == DEALER_STATUS_OFFLINE ||
                $dealer->dealer_status == DEALER_STATUS_STOP)
        {
            $result->code = ERR_DEALER_NOT_FOUND;
            $result->message = '商家不存在，或已被停用';
            return $result;
        }
        
        if(preg_match("/^[1][358]\d{9}$/", $mobile))
        {
            $session_id = Yii::app()->session->sessionId;
            $session_key = 'validcode_status'.$session_id;
            $last_valid_time = Yii::app()->session[$session_key];
            $validcode_ts = Yii::app()->params['validcode_ts'];
            
            if(isset($last_valid_time))
            {
                $ts = Carbon::now()->diffInSeconds($last_valid_time);
                if($ts <= $validcode_ts * 60)
                {
                    //失败，未达到时间间隔
                    $result->code = ERR_MESSAGE_SEND_NO_LONGGER;
                    $result->seconds = $validcode_ts * 60 - $ts;
                    $result->message = '未到可发送间隔';
                    
                    return $result;
                }
                
            }
            
            //超过最大数量
            $count = ValidCode::model()->GetCountPerDay($mobile);
            
            if($count > 4)
            {
                $result->code = ERR_MESSAGE_SEND_MAX_TIMES;
                $result->message = '已达到最大发送数量：每次5次';

                return $result;
            }
            
            $sms = new Sms();
            $dealer = Dealer::model()->findByPk($dealer_id);
            $code = $this->random_number(Yii::app()->params['validcode_len']);
            $validcode_ts = Yii::app()->params['validcode_ts'];
            $msg = sprintf(
                    Yii::app()->params['validcode_msg'],
                    $code,
                    $dealer->dealer_name,
                    $validcode_ts);
            
            $trans = Yii::app()->db->beginTransaction();
            try{
                $bsms = new busSms();
                $sendRes = $bsms->send($mobile, $msg);
                
                //保存验证码
                $validModel = new ValidCode();
                $validModel->code_content = $code;
                $validModel->code_valid_minutes = $validcode_ts;
                $validModel->code_mobile = $mobile;
                $validModel->code_create_time = date('Y-m-d H:i:s',time());
                
                $validModel->save();
                
                //短信
                $sms = new Sms();
                $sms->sms_content = $msg;
                $sms->sms_receiver = $mobile;
                $sms->sms_type = 1;
                $sms->sms_status = $sendRes ? 1:0;
                $sms->sms_create_time = date('Y-m-d H:i:s',time());
                
                $sms->save();
                
                $trans->commit();
                
                $result->code = SUCCESS;
                $result->seconds = $validcode_ts * 60;
                Yii::app()->session[$session_key] = Carbon::now();
                Yii::app()->session['validcode'.$mobile] = $code;
                Yii::log($code);
            }
            catch (Exception $ex) {
                $trans->rollback();
                Yii::log($ex->getMessage(),  CLogger::LEVEL_ERROR);
                echo $ex->getMessage();
                $result->code = ERR_EXCEPTION;
            }
        }
        else
        {
            $result->code = ERR_MOBILE_FORMAT;
            $result->message = '手机号格式错误';
        }
        
        
        return $result;
	}
    
    
    /**
     * 检查验证码是否正确
     * @param type $mobile
     * @param type $validcode
     * @return Bool
     */
    public function check_validcode($mobile,$validcode)
    {
        return Yii::app()->session['validcode'.$mobile] == $validcode;
    }


    /**
     * 生成随机数验证码
     * @param int $length 长度
     * @return string
     */
    public function random_number($length)
    {
        $output='';
        for ($a = 0; $a < $length; $a++) {
            $output .= rand(0, 9);
        }
        return $output;
    }
    
    
    public function random_words($length)
    {
        $chars = 'ABDFETYPNK';
        $code = $this->random_number(4);
        $code2 = '';
        for ($idx = 0; $idx < strlen($code); $idx++) 
        {
            $code2 .= $chars[$code[$idx]];
        }
        
        return $code2;
    }
}
