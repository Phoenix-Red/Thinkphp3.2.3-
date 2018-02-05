<?php
namespace Admin\Model;
use Think\Model;
class NoticeModel extends CommonModel{
    protected $pk   = 'id';
    protected $tableName =  'notice';
    protected $token = 'notice';
    
    public function getNoticeTitle($title){
        $data = $this->find(array('where'=>array('title'=>$title)));
        return $this->_format($data);
    }
}
