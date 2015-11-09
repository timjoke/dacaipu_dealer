<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * busWechat 的注释
 *
 * @作者 roy
 */
class BusWechat
{

    //$_GET参数
    public $signature;
    public $timestamp;
    public $nonce;
    public $echostr;
    //
    public $token;
    public $debug = false;
    public $msg;
    public $setFlag = false;

    /**
     * __construct
     *
     * @param mixed $params
     * @access public
     * @return void
     */
    public function __construct($params)
    {
        foreach ($params as $k1 => $v1)
        {
            if (property_exists($this, $k1))
            {
                $this->$k1 = $v1;
            }
        }
    }

    /**
     * valid
     *
     * @access public
     * @return void
     */
    public function valid()
    {
        //valid signature , option
        if ($this->checkSignature())
        {
            echo $this->echostr;
            Yii::app()->end();
        }
    }

    /**
     * 获得用户发过来的消息（消息内容和消息类型  ）
     *
     * @access public
     * @return void
     */
    public function init()
    {
        $postStr = empty($GLOBALS["HTTP_RAW_POST_DATA"]) ? '' : $GLOBALS["HTTP_RAW_POST_DATA"];
        if ($this->debug)
        {
            $this->log($postStr);
        }
        if (!empty($postStr))
        {
            $this->msg = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
        }
    }

    /**
     * makeEvent
     *
     * @access public
     * @return void
     */
    public function makeEvent()
    {
        
    }

    /**
     * 回复文本消息
     *
     * @param string $text
     * @access public
     * @return void
     */
    public function makeText($text = '')
    {
        $createTime = time();
        $funcFlag = $this->setFlag ? 1 : 0;
        $textTpl = "<xml>
            <ToUserName><![CDATA[{$this->msg->FromUserName}]]></ToUserName>
            <FromUserName><![CDATA[{$this->msg->ToUserName}]]></FromUserName>
            <CreateTime>{$createTime}</CreateTime>
            <MsgType><![CDATA[text]]></MsgType>
            <Content><![CDATA[%s]]></Content>
            <FuncFlag>%s</FuncFlag>
            </xml>";
        $data = sprintf($textTpl, $text, $funcFlag);
        return $data;
    }

    /**
     * 根据数组参数回复图文消息
     *
     * @param array $newsData
     * @access public
     * @return void
     */
    public function makeNews($newsData = array())
    {
        $createTime = time();
        $funcFlag = $this->setFlag ? 1 : 0;
        $newTplHeader = "<xml>
            <ToUserName><![CDATA[{$this->msg->FromUserName}]]></ToUserName>
            <FromUserName><![CDATA[{$this->msg->ToUserName}]]></FromUserName>
            <CreateTime>{$createTime}</CreateTime>
            <MsgType><![CDATA[news]]></MsgType>
            <ArticleCount>%s</ArticleCount><Articles>";
        $newTplItem = "<item>
            <Title><![CDATA[%s]]></Title>
            <Description><![CDATA[%s]]></Description>
            <PicUrl><![CDATA[%s]]></PicUrl>
            <Url><![CDATA[%s]]></Url>
            </item>";
        $newTplFoot = "</Articles>
            </xml>";

        $content = '';
        $itemsCount = count($newsData);
        foreach ($newsData as $item)
        {
            $content .= sprintf($newTplItem, $item['title'], $item['description'], $item['picurl'], $item['url']);
        }


        $header = sprintf($newTplHeader, $itemsCount);
        $footer = sprintf($newTplFoot, $funcFlag);

        return $header . $content . $footer;
    }

    /**
     * reply
     *
     * @param mixed $data
     * @access public
     * @return void
     */
    public function reply($data)
    {
        if ($this->debug)
        {
            $this->log($data);
        }
        echo $data;
    }

    /**
     * checkSignature
     *
     * @access private
     * @return void
     */
    private function checkSignature()
    {
        $tmpArr = array($this->token, $this->timestamp, $this->nonce);
        sort($tmpArr);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);

        if ($tmpStr == $this->signature)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * log
     *
     * @access private
     * @return void
     */
    private function log($log)
    {
        if ($this->debug)
        {
            file_put_contents(Yii::getPathOfAlias('application') . '/runtime/weixin_log.txt', var_export($log, true) . "\n\r", FILE_APPEND);
        }
    }

    /**
     * 根据关键字回复微信消息
     * @param type $dealer_id
     * @param type $content
     * @return type
     */
    public function keywords($dealer_id, $content)
    {
        try
        {
            $content = strtolower($content);
            $replies = DealerWechatReply::model()->findAllByAttributes(array(
                'dealer_id' => $dealer_id,),array('order' => 'operat ASC'));

            foreach ($replies as $reply)
            {
                $rc = DealerWechatReplyContent::model()->findByPk($reply->content_id);
                //等于
                if ($reply->operat == 1 && $content == $reply->keyword)
                {
                    $rp = $this->makeText($rc->content);
                    $this->reply($rp);
                    return true;
                }
                //包含
                else if (stripos($content, $reply->keyword) !== false)
                {
                    $rp = $this->makeText($rc->content);
                    $this->reply($rp);
                    return true;
                }
            }

            return false;
        } 
        catch (Exception $e)
        {
            echo 'error:';
            echo $e->getMessage();
            $rp = $this->makeText($e->getMessage());
            $this->reply($rp);
            return true;
        }
    }

}
