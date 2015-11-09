<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * busGoogleMap 的注释
 *
 * @作者 roy
 */
class BusGoogleMap {
    public function getAddrByGeo($lat,$lng)
    {
        $url = 'http://maps.googleapis.com/maps/api/geocode/json?latlng='.$lng.','.$lat.'&sensor=true';
        $data = busUlitity::get($url);
        $obj = json_decode($data);
        var_dump($obj);
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
    }
}
