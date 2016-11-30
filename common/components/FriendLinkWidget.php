<?php

/**
 * 友情链接
 * Class FriendLinkWidget
 */
class FriendLinkWidget extends CWidget {

    public $type;

    public function init(){

        $friendLink = FriendlinkModel::model()->findAll(
            array(
                'condition'=>'is_effect=1',
                'order'=>'sort asc')
        );
        $html ='<ul>
            <span>友情链接：</span> ';
        foreach($friendLink as $f){
            $html.='<a href="'.$f->url.'" target="_blank">'.$f->title.'</a>';

        }
        $html.='</ul>';
        echo $html;
    }

}
