<?php
namespace Admin\Model;
use Think\Model;
class NewsModel extends CommonModel{
    protected $pk   = 'id';
    protected $tableName =  'news';
    protected $token = 'news';
    
    public function getid($id){
        $data = $this->find(array('where'=>array('id'=>$id)));
        return $this->_format($data);
    }
}
