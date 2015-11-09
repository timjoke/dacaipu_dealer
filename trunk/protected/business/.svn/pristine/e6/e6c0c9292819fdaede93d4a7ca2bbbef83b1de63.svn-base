<?php


/**
 * 百度地图API
 *
 * @作者 roy
 */
class BusBaiduMap
{
    private function endsWith($haystack,$needle)
    {
      $res=FALSE;
      $len=mb_strlen($haystack);
      $pos=$len-mb_strlen($needle);
      if(mb_strripos($haystack,$needle,0,"utf-8")==$pos)
         $res= TRUE;
      return $res;
    }
    
    
    public function getAddrByGeo($lat,$lng)
    {
        $url = 'http://api.map.baidu.com/geocoder?ak='.Yii::app()->params['baidu_map_key']
                .'&location='.$lat.','.$lng.'&output=json&pois=0';
        
        $data = busUlitity::get($url);
        $obj = json_decode($data);
        if($obj->status == 'OK')
        {
            return $obj->result->formatted_address;
        }
        else
        {
            return 'none';
        }
    }
    

    /**
     * 根据地址获得距离
     * @param type $fcity   起点城市
     * @param type $tcity   终点城市
     * @param type $start   起点地址
     * @param type $end     终点地址
     * @return type
     */
    public function getDistanceByAddr($fcity,$tcity,$start,$end)
    {
        $key = Yii::app()->params['baidu_map_key'];
        $fcity = urlencode($fcity);
        $tcity = urlencode($tcity);
        $start = urlencode($start);
        $end = urlencode($end);
        
        $url = "http://api.map.baidu.com/direction/v1?mode=driving&origin=$start&destination=$end&origin_region=$fcity&destination_region=$tcity&output=json&ak=$key&tactics=12";
        $data = busUlitity::get($url);
        $obj = json_decode($data);
        return $obj;
    }
}
