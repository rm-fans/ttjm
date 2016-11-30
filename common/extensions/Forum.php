<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/6/1
 * Time: 9:21
 */
class Forum
{
    const  Forumurl = 'http://218.89.241.79:98/mobcent/app/web/index.php?r=api/Uidiy/';
    /**
     * 社区精华
     */
    public static function Active(){
        $url= Forum::Forumurl.'Marrow';
        $contents = Utils::sendHttpRequest($url);
        $active=json_decode($contents['content']);
        return $active->body->data;
    }
    /**
     * 最新消息
     */
    public static function Newest(){
        $url=Forum::Forumurl.'New';
        $contents = Utils::sendHttpRequest($url);
        $newest=json_decode($contents['content']);
        return $newest->body->data;
    }
    /**
     * 社区达人
     */
    public static function Eredar(){
        $url=Forum::Forumurl.'Gooduser';
        $contents = Utils::sendHttpRequest($url);
        $eredar=json_decode($contents['content']);
        return $eredar->body->data;
    }
    /**
     * banner
     */
    public static function Banner(){
        $url=Forum::Forumurl.'Banner';
        $contents = Utils::sendHttpRequest($url);
        $banner=json_decode($contents['content']);
        return $banner->body->data;
    }
    /**
     * Information
     */
    public static function Information($id,$pageSize=4){
        $url=Forum::Forumurl.'Information/id/Information/id/'.$id.'/pagesize/'.$pageSize;
        $contents = Utils::sendHttpRequest($url);
        $information=json_decode($contents['content']);
        return $information->body;
    }


}