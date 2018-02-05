<?php

/* 首页 */

namespace Home\Controller;

use Think\Controller;

class PublicController extends BaseController {

    public function nav() {
        $cate = M('article_cate') -> where('pid !=0') -> select();
		$this -> assign('cate', $cate);
		$this -> display();
    }
	
}
