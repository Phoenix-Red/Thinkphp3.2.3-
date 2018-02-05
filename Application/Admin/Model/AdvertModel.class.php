<?php
namespace Admin\Model;
use Think\Model;
class AdvertModel extends CommonModel{
    protected $pk   = 'id';
    protected $tableName =  'advert';
    protected $token = 'advert';
    
    public function getAdvertTitle($title){
        $data = $this->find(array('where'=>array('title'=>$title)));
        return $this->_format($data);
    }
}
