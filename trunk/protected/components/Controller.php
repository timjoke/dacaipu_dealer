<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController//SBaseController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
    
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
        public $menu=array();

        
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
    
    private static $static_server_idx = 1;
    
    
    /**
     * 获得静态文件服务器地址，不带"http:",以/结尾，适用js、css；
     * @return string
     */
    public function get_static_url()
    {
        return busUlitity::get_static_url();
        
    }
    
    /**
     * 获得静态文件服务器地址，不带"http:",以/结尾，适用img；
     * @return type
     */
    public function get_http_static_url()
    {
        return 'http:'.$this->get_static_url();
    }

    /**
     * 获得当前登录用户，如未登录返回null;
     * @return Customer
     */
    public function getCustomer()
    {
        if(Yii::app()->user->isLogin()) return Yii::app()->user->customer();
        exit('请从微信进入.');
    }



    
    /**
     * 获得样式模板
     * @return type
     */
    public function get_theme()
    {
        return Yii::app()->theme->name;
    }
    
    
    /**
     * 获得当前时间
     * @return type
     */
    public function now()
    {
        return date('Y-m-d H:i:s',time());
    }
}