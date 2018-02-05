<?php

namespace Admin\Controller;

use Think\Controller;

header('Content-type:text/html;charset=utf-8');

class LinkController extends BaseController {

	public function index() {
		
		$Link = D('Link');		
		$count = $Link -> count();
		$p = getpage($count, C('PAGE_SIZE'));
		$show = $p -> show();
		$list = $Link -> page(I('get.p')) -> limit(C('PAGE_SIZE')) ->order('id desc')-> select();
		$this -> assign('list', $list);
		$this -> assign('page', $show);
		$this -> display();
	}
	
	//添加链接
    public function add(){
     
        $this->display();
    }

    public function runadd()
    {
        if (!IS_AJAX) {
            $this->error('提交方式不正确', U('Link/add'), 0);
        } else {
           
		    $create_time = strtotime(date("Y-m-d H:i:s", time()));
            $data['name'] = trim(I('post.name', '', 'htmlspecialchars'));
            $data['url'] = trim(I('post.url', '', 'htmlspecialchars'));
			$data['state'] = trim(I('post.state', '', 'htmlspecialchars'));
			$data['orderby'] = trim(I('post.orderby', '', 'htmlspecialchars')); 
			$data['create_time'] = $create_time; 
			$data['update_time'] = $create_time; 			                 
           	if ($data['name'] == null) {
				$this -> error('名称不能为空');
				return;
			}
			if ($data['url'] == null) {
				$this -> error('域名不能为空');
				return;
			}
			if ($data['orderby'] == null) {
				$this -> error('排序不能为空');
				return;
			}
			
            M('Link')->add($data);
			
            $this->success('栏目保存成功', U('Link/index'), 1);
        }
    }

	//编辑链接
	public function edit() {
		
		$detail = M('Link')->where(array('id' => I('id')))->find();
        $this->assign('detail', $detail);
        $this->display();
		
	}

	public function runedit() {

		$id = I('id', '', htmlspecialchars);
		
		if (!IS_AJAX) {
            $this->error('提交方式不正确', U('Link/edit'), 0);
        } else {
           
		    $update_time = strtotime(date("Y-m-d H:i:s", time()));
            $data['name'] = trim(I('post.name', '', 'htmlspecialchars'));
            $data['url'] = trim(I('post.url', '', 'htmlspecialchars'));
			$data['state'] = trim(I('post.state', '', 'htmlspecialchars'));
			$data['orderby'] = trim(I('post.orderby', '', 'htmlspecialchars')); 
			$data['update_time'] = $update_time; 
			                 
           	if ($data['name'] == null) {
				$this -> error('名称不能为空');
				return;
			}
			if ($data['url'] == null) {
				$this -> error('域名不能为空');
				return;
			}
			if ($data['orderby'] == null) {
				$this -> error('排序不能为空');
				return;
			}			

            M('Link')->where('id='.$id)->save($data);
			
            $this->success('栏目保存成功', U('Link/index'), 1);
        }
	}

	//删除链接
	public function del() {

		M('Link')->where(array('id' => I('id')))->delete();
        $this->redirect('index');
	}

}
