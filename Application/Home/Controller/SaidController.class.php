<?php
namespace Home\Controller;
use Think\Controller;
class SaidController extends BaseController {

    public function index() {
		
		//说说
		$Said = D('Said');		
		$count = $Said -> count();
		$p = getpage($count, C('PAGE_SIZE'));
		$show = $p -> show();
		$list = $Said ->where('s_view !=0')-> page(I('get.p')) -> limit(C('PAGE_SIZE')) ->order('create_time desc')-> select();
		$newIp = new \Org\Util\IP();
        for ($i=0; $i < count($list); $i++) {
          $list[$i]['create_ip'] = getIpaddr($list[$i]['create_ip'],$newIp);
        }
		$this -> assign('list', $list);
		$this -> assign('page', $show);
		$this -> display();

    }

}
