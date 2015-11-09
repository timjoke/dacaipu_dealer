<?php

/**
 * 打折类逻辑实现
 *
 * @author roy
 */
class busDealerWechatReply
{
    public static $OPERAT_LIST = array(1 => "等于",2=>"包含");
    public static $CONTENT_TYPE_LIST = array(1 => "文本",2=>"图片");
    
    /**
     * 显示操作符
     * @param type $model
     * @return string
     */
    static function show_operat_str($operat)
    {
        $showname = '';
        switch ($operat)
        {
            case 1:
                $showname = '等于';
                break;
            case 2:
                $showname = '包含';
                break;
            default:
                break;
        }
        return $showname;
    }
    
    /**
     * 显示内容类型
     * @param type $model
     * @return string
     */
    static function show_content_type_str($content_type)
    {
        $showname = '';
        switch ($content_type)
        {
            case 1:
                $showname = '文本';
                break;
            case 2:
                $showname = '图片';
                break;
            default:
                break;
        }
        return $showname;
    }
}
