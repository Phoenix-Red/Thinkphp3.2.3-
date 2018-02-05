<?php
/* 文章分类 */
namespace Home\Controller;
use Think\Controller;
class ClassController extends BaseController {

	public function index() {
		$id = I('get.id');
		$article_cate = D('article_cate');
		$cate = $article_cate -> select();
		$count = M('article') -> where(array('cate_id' => $id)) -> count();
		$p = getpage($count, C('PAGE_SIZE'));
		$show = $p -> show();
		$article = M('article') -> page(I('get.p')) -> where('a_views > 0') -> join('lxb_article_cate ON lxb_article_cate.cate_id = lxb_article.cate_id') -> where(array('lxb_article.cate_id' => $id)) -> limit(C('PAGE_SIZE')) -> order('create_time desc') -> select();
		$this -> assign('article', $article);
		$this -> assign('cate', $cate);
		$this -> assign('page', $show);
		$this -> display();
	}

}
?>