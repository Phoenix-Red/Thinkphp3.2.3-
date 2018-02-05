<?php
namespace Admin\Controller;
use Think\Controller;
class ArticleController extends BaseController {
	
    public function index(){
        
        $Article = D('Article');
        $article_cate = D('article_cate');
        $count = $Article->count(); 
        $p = getpage($count,C('PAGE_SIZE'));
        $show = $p->show(); 
        $list = $Article->page(I('get.p'))->order('a_id desc')->limit(C('PAGE_SIZE'))->select();
        $list1 = $article_cate->select();
        $this->assign('page', $show); 
        $this->assign('list', $list);
        $this->assign('list1', $list1);
        $this->display();
    }
 
	 /*
	  * 添加文章
	  */   
    public function add(){
    	
        $article_cate = D('article_cate');
        $list = $article_cate->select();//查询分类		
        $this->assign('list', $list);
        $this->display();
    }




    public function runadd()
    {
        if (!IS_AJAX) {
            $this->error('提交方式不正确', U('article/add'), 0);
        } else {
           
            $create_time          = strtotime(date("Y-m-d H:i:s",time()));
            $last_time            = strtotime(date("Y-m-d H:i:s",time()));
            $data['a_title']      = trim(I('post.a_title', '', 'htmlspecialchars'));        
            $data['cate_id']      = trim(I('post.cate_id', '', 'htmlspecialchars'));
            $data['photo']        = trim(I('post.photo', '', 'htmlspecialchars'));
            $data['a_keyword']    = trim(I('post.a_keyword', '', 'htmlspecialchars'));
            $data['a_remark']     = trim(I('post.a_remark', '', 'htmlspecialchars'));
            $data['a_content']    = $_POST['a_content'];
            $data['a_red']        = trim(I('post.a_red', '', 'htmlspecialchars'));
            $data['a_type']       = trim(I('post.a_type', '', 'htmlspecialchars'));
            $data['a_views']      = trim(I('post.a_views', '', 'htmlspecialchars'));
            $data['a_writer']     = trim(I('post.a_writer', '', 'htmlspecialchars'));
            $data['create_time']  = $create_time;
            $data['create_ip']    = get_client_ip();
            $data['last_time']    = $last_time;
            $data['a_from']       = getOS();

            if (empty($data['a_title'])) {
                $this->error('文章标题不能为空');
            }   
            if (empty($data['a_keyword'])) {
                $this->error('关键字不能为空');
            }        
            if (empty($data['a_remark'])) {
                $this->error('文章描述不能为空');
            }
            if (empty($data['a_content'])) {
                $this->error('内容不能为空');
            }
            
            M('Article')->add($data);

            $this->success('文章保存成功', U('article/index'), 1);
        }
    }

 
 
	 /*
	  * 编辑文章
	  */   
    public function edit() {

        $list = D('article_cate')->select();
        $detail = M('article')->where(array('a_id' => I('a_id')))->find();
        $this->assign('detail', $detail);
        $this->assign('list', $list);
        $this->display();

    }

    public function runedit() {

        $a_id = I('a_id', '', htmlspecialchars);
        
        if (!IS_AJAX) {
            $this->error('提交方式不正确', U('article/edit'), 0);
        } else {
           
            $last_time         = strtotime(date("Y-m-d H:i:s",time()));
            $data['a_title']   = trim(I('post.a_title', '', 'htmlspecialchars'));        
            $data['cate_id']   = trim(I('post.cate_id', '', 'htmlspecialchars'));
            $data['photo']     = trim(I('post.photo', '', 'htmlspecialchars'));
            $data['a_keyword'] = trim(I('post.a_keyword', '', 'htmlspecialchars'));
            $data['a_remark']  = trim(I('post.a_remark', '', 'htmlspecialchars'));
            $data['a_content'] = $_POST['a_content'];
            $data['a_red']     = trim(I('post.a_red', '', 'htmlspecialchars'));
            $data['a_type']    = trim(I('post.a_type', '', 'htmlspecialchars'));
            $data['a_views']   = trim(I('post.a_views', '', 'htmlspecialchars'));
            $data['a_writer']  = trim(I('post.a_writer', '', 'htmlspecialchars'));
            $data['create_ip'] = get_client_ip();
            $data['last_time'] = $last_time;
            $data['a_from']    = getOS();  

            if (empty($data['a_title'])) {
                $this->error('文章标题不能为空');
            }   
            if (empty($data['a_keyword'])) {
                $this->error('关键字不能为空');
            }        
            if (empty($data['a_remark'])) {
                $this->error('文章描述不能为空');
            }
            if (empty($data['a_content'])) {
                $this->error('内容不能为空');
            }          

            M('Article')->where('a_id='.$a_id)->save($data);
            
            $this->success('文章保存成功', U('Article/index'), 1);
        }
    }
                    
 
 
	 /*
	  *删除文章
	  */   
    public function del() {

        $p = I('p');
        M('article')->where(array('a_id' => I('a_id')))->delete();
        $this->redirect('index', array('p' => $p));

    }




	/*
	 *文章分类 
	 */	
	public function indextype() {
        $article_cate = D('article_cate');
        $count = $article_cate->count(); // 查询满足要求的总记录数 
        $p = getpage($count, C('PAGE_SIZE'));
        $show = $p->show();
        $list = $article_cate->page(I('get.p'))->limit(C('PAGE_SIZE'))->select();
        $this->assign('list', $list);
        $this->assign('page', $show);
        $this->display();
    }
	
	/*
	 * 添加文章分类
	 */
    public function addtype(){
     
        $this->display();
    }

    public function runaddtype()
    {
        if (!IS_AJAX) {
            $this->error('提交方式不正确', U('Link/add'), 0);
        } else {
           
        $data['cate_name'] = trim(I('post.cate_name', '', 'htmlspecialchars'));
        $data['orderby'] =  trim(I('post.orderby', '', 'htmlspecialchars'));
        if ($data['cate_name'] == null) {
            $this->error('分类名称不能为空');
            return;
        }
        if ($data['orderby'] == null) {
            $this->error('排序不能为空');
            return;
        }
            
            M('article_cate')->add($data);
            
            $this->success('分类保存成功', U('article/indextype'), 1);
        }
    }





    /*
     * 编辑文章分类
     */	
    public function edittype() {
        
        $detail = M('article_cate')->where(array('cate_id' => I('cate_id')))->find();
        $this->assign('detail', $detail);
        $this->display();
        
    }

    public function runedittype() {

        $cate_id = I('cate_id', '', htmlspecialchars);
        
        if (!IS_AJAX) {
            $this->error('提交方式不正确', U('article/edittype'), 0);
        } else {
           
            $data['cate_name'] = trim(I('post.cate_name', '', 'htmlspecialchars'));
            $data['orderby'] =  trim(I('post.orderby', '', 'htmlspecialchars'));
            if ($data['cate_name'] == null) {
                $this->error('分类名称不能为空');
                return;
            }
            if ($data['orderby'] == null) {
                $this->error('排序不能为空');
                return;
            }           

            M('article_cate')->where('cate_id='.$cate_id)->save($data);
            
            $this->success('栏目保存成功', U('article/indextype'), 1);
        }
    }


	/*
	 * 删除分类
	 */
    public function deltype() {

        $p = I('p');
        M('article_cate')->where(array('cate_id' => I('cate_id')))->delete();
        $this->redirect('indextype', array('p' => $p));
    }

}
