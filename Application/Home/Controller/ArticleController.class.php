<?php

/* 文章 */

namespace Home\Controller;
use Think\Controller;
class ArticleController extends BaseController {

	public function index() {

    	$a_id=intval($_GET['a_id']);    
     	$Article=M('article');
        $this->Article = $Article->where(array('a_id' => $a_id))->find();		
		$detail=$Article->find($a_id);		
		$v['a_views'] = $detail['a_views'] + 1;
        $Article->where(array('a_id' => $a_id))->save($v);		
        $this->up = $Article->where('a_views !=0 AND a_id <' . $a_id)->order('a_id desc')->limit(1)->find();
        $this->down = $Article->where('a_views !=0 AND a_id >' . $a_id)->order('a_id')->limit(1)->find();
		$cate = M('article_cate')-> select();		    
		$this->assign('cate',$cate);
      	$this->display();
    }

}

?>