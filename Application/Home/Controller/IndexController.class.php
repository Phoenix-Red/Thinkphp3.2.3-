<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends BaseController {

    public function index() {

		    $article = D('Article');
		    $article_cate = D('article_cate');
		    $cate = $article_cate -> select();
		    $count = M('article')->count();
        $p = getpage($count, 6);
		    $show = $p -> show();		
        $list = $article->page(I('get.p'))->join('lxb_article_cate ON lxb_article_cate.cate_id = lxb_article.cate_id') -> order('a_id desc')-> limit(6)->select();
       	$this -> assign('list', $list);
       	$this -> assign('page', $show);
        $this->display();
    }

}
