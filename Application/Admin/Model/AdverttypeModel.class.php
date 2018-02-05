<?php
namespace Admin\Model;
use Think\Model;
class AdverttypeModel extends CommonModel{
    protected $pk   = 'id';
    protected $tableName =  'adverttype';
    protected $token = 'adverttype';
	
	public function getAdvertTypeTitle($name){
        $data = $this->find(array('where'=>array('name'=>$name)));
        return $this->_format($data);
    }
}
