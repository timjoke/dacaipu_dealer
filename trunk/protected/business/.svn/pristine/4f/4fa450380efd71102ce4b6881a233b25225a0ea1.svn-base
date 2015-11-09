<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * busUlitity 的注释
 *
 * @作者 roy
 */
class busUlitity
{

    static function arrayToObject($e)
    {
        if (gettype($e) != 'array')
            return;
        foreach ($e as $k => $v)
        {
            if (gettype($v) == 'array' || getType($v) == 'object')
            {
                $e[$k] = (object) self::arrayToObject($v);
            }
        }
        return (object) $e;
    }

    static function objectToArray($e)
    {
        $e = (array) $e;
        foreach ($e as $k => $v)
        {
            if (gettype($v) == 'resource')
                return;
            if (gettype($v) == 'object' || gettype($v) == 'array')
                $e[$k] = (array) self::objectToArray($v);
        }
        return $e;
    }

    /**
     * 检测是否手机号
     * @param type $mobile
     * @return type
     */
    static function is_mobile($mobile)
    {
        return preg_match("/^[1][358]\d{9}$/", $mobile);
    }

    /**
     * 
     * @param string  $url
     */
    static function get($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // 获取数据返回  
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true); // 在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回  
        return curl_exec($ch);
    }

    /**
     * 发送post请求
     * @param type $url
     * @param type $data
     * @return type
     */
    static function post($url, $data = array())
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // post数据
        curl_setopt($ch, CURLOPT_POST, 1);
        // post的变量
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }

    /**
     * 上传图片
     * @param type $imgFile
     * @param int $pictype 图片类型 1 商家logo；2 菜品图片；
     * @param int $entity_id 实体id
     * @param int $biztype 具体业务内的类型 1 商家logo 或 菜品图片
     */
    static function UploadImg($imgFile, $pictype, $entity_id, $biztype)
    {
        if (isset($imgFile))
        {
            $filetype = $imgFile->type;
            $extensionName = $imgFile->extensionName;
            $pos = strpos($filetype, 'image');
            if ($pos === false)
            {
                //提示不是图片
                return '上传的文件不是图片';
            }
            elseif ($pos == 0)
            {
                //上传图片
                $pic = pic::model()->findByAttributes(array('entity_id' => $entity_id, 'pic_type' => $pictype));
                $filefullpach = '';
                if (!isset($pic))
                {//图片信息在数据库中不存在
                    //判断文件夹是否存在 图片文件夹格式 参数img_upload_dir+图片类型_id_具体业务内的类型
                    $dir_date = date("Ym");
                    $dir_full = Yii::app()->params['img_upload_dir'] . 'upload/' . $dir_date . '/';
                    if (!is_dir($dir_full))
                    {
                        mkdir($dir_full);
                    }
                    $newfilename = $pictype . '_' . $entity_id . '_' . $biztype . '.' . $extensionName;
                    $relpath = 'upload/' . $dir_date . '/' . $newfilename; //相对路径 用于图片保存数据库
                    $pic = new Pic;
                    $pic->entity_id = $entity_id;
                    $pic->pic_type = $pictype;
                    $pic->pic_url = $relpath;
                    $pic->save();
                    $filefullpach = $dir_full . $newfilename;
                }
                else
                {
                    $filefullpach = Yii::app()->params['img_upload_dir'] . $pic->pic_url;
                }

                if ($imgFile->saveAs($filefullpach) == FALSE)
                {
                    //提示保存文件错误
                    return '保存文件出错，请联系管理员';
                }
                else
                {//保存文件对象到数据库
                }
            }
        }
        else
        {
            return -3;
        }
        return '上传图片成功';
    }

    /**
     * 格式化金钱类型的字符串，保留两位小数
     * @param string $model 
     * @return string
     */
    static function formatMoney($money,$num=2)
    {
        $s = floatval($money);
        $money = sprintf("%.2f", $s);
        return $money;
    }

    /**
     * 格式化日期类型字符串 将字符串格式化为 y-M-d h:m
     * @param string $date
     * @return string
     */
    static function formatDate($date)
    {
        return busUlitity::getDatestr($date, 0, 16);
    }

    /**
     * 格式化日期类型字符串 将字符串格式化仅有时间 格式为 h:m
     * @param string $date
     * @return string
     */
    static function formatOnlyTime($date)
    {
        return busUlitity::getDatestr($date, 11, 5);
    }

    /**
     * 格式化日期时间字符串
     * @param string $date 待格式化的原始字符串
     * @param int $index 起始索引
     * @param int $length 长度
     * @return string 
     */
    static function getDatestr($date, $index, $length)
    {
        if (isset($date) == FALSE)
        {
            return '';
        }
        elseif (strlen($date) == 19)
        {
            return substr($date, $index, $length);
        }
        else
        {
            return $date;
        }
    }

    /**
     * 隐藏字符串中的数字
     * @param type $model
     * @return type
     */
    static function hideNumber($model)
    {
        for ($i = 0; $i < 10; $i++)
        {
            $model = str_replace($i, '*', $model);
        }
        return $model;
    }

    static function array_insert($myarray, $value, $position = 0)
    {
        $fore = ($position == 0) ? array() : array_splice($myarray, 0, $position);
        $fore[] = $value;
        $ret = array_merge($fore, $myarray);
        return $ret;
    }

    /**
     * 列表控件如果没有数据需要显示的提示
     * @param type $data 列表控件的数据源
     */
    static function dataEmptyMessage($data)
    {
        if ($data->itemCount == 0)
        {
            echo '<div class="emptyArea">' . DATAEMPTYMESSAGE . '</div>';
        }
    }

    /**
     * 将两个json字符串连接到一起
     * [{ "firstName": "Brett" }] 和 [{ "secondName": "bill" }] 连接后为[{ "firstName": "Brett" },{ "secondName": "bill" }]
     * @param string $json_a
     * @param string $json_b
     * @return string
     */
    static function joinjson($json_a, $json_b)
    {
        if ($json_a == '[]' && $json_b == '[]')
        {
            return '[]';
        }
        elseif ($json_a == '[]')
        {
            return $json_b;
        }
        elseif ($json_b == '[]')
        {
            return $json_a;
        }
        else
        {
            $json_a = substr($json_a, 0, strlen($json_a) - 1);
            $json_b = substr($json_b, 1, strlen($json_b));
            return $json_a . ',' . $json_b;
        }
    }

    /**
     * 时间差 
     * @param string $beginDate_str
     * @param string $endDate_str
     * @return int 天数
     */
    static function DateSubDay($beginDate_str, $endDate_str)
    {
        $beginDate = strtotime($beginDate_str);
        $endDate = strtotime($endDate_str);
        $day = floor(($endDate - $beginDate) / 86400);
        return $day;
    }

    /**
     * 报表使用的x轴时间列表，如果为时间差大于一天显示日期格式，其他情况显示一天的小时格式。
     * @param type $beginDate 
     * @param type $endDate
     * @return type  json格式，不包含最外层的中括号
     */
    static function X_reportjsArray($beginDate, $endDate)
    {
        $list = array();

        $days_sub = busUlitity::DateSubDay($beginDate, $endDate);
        if ($days_sub > 0)
        {//日期格式
            $beginDate_time = strtotime($beginDate);

            for ($i = 0; $i < $days_sub + 1; $i++)
            {
                $time_temp = date('m-d', strtotime('+' . $i . ' day', $beginDate_time));
                array_push($list, '\'' . $time_temp . '\'');
            }
        }
        else
        {//小时格式
            for ($i = 0; $i < 24; $i++)
            {
                array_push($list, $i);
            }
        }
        $list = implode(',', $list);
        return $list;
    }

    private static $static_server_idx = 1;

    /**
     * 获得静态文件服务器地址，不带"http:",以/结尾，适用js、css；
     * @return string
     */
    public static function get_static_url()
    {
        $default_url = '//192.168.2.10:8002/';
        if (Yii::app()->params['local_test'] === FALSE)
        {
            if (self::$static_server_idx > 5)
            {
                self::$static_server_idx = 1;
            }

            $url = '//img' . self::$static_server_idx . '.dacaipu.cn/';

            self::$static_server_idx++;

            return $url;
        }
        else
        {
            return $default_url;
        }
    }

    /**
     * 获得静态文件服务器地址，不带"http:",以/结尾，适用img；
     * @return type
     */
    public static function get_http_static_url()
    {
        return 'http:' . busUlitity::get_static_url();
    }

}
