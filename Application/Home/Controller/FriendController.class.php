<?php
namespace Home\Controller;
use Think\Controller;
class FriendController extends BaseController {

    public function index() {
		$this->QQ = M('qquser')->field(true)->select();
		$this->count = M('qquser') -> count();
        $this->display();
    }

}
