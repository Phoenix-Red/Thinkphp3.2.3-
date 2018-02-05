<?php

namespace Admin\Controller;

use Think\Controller;

header('Content-type:text/html;charset=utf-8');

class SaidController extends BaseController {


	public function index() {
		
		$Said = D('Said');		
		$count = $Said -> count();
		$p = getpage($count, C('PAGE_SIZE'));
		$show = $p -> show();
		$list = $Said -> page(I('get.p')) -> limit(C('PAGE_SIZE')) ->order('create_time desc')-> select();
		$this -> assign('list', $list);
		$this -> assign('page', $show);
		$this -> display();
	}


    public function add(){
     
        $this->display();
    }


    public function runadd()
    {
        if (!IS_AJAX) {
            $this->error('提交方式不正确', U('Said/add'), 0);
        } else {

			$create_time = strtotime(date("Y-m-d H:i:s", time()));
			$data['s_content'] = $_POST['s_content'];		
			$data['create_time'] = $create_time;		
			$data['s_from'] = getOS();
			$data['s_img'] = session('admin.userimg');	
			$data['s_writer'] = trim(I('post.s_writer', '', 'htmlspecialchars'));
			$data['s_view'] = trim(I('post.s_view', '', 'htmlspecialchars'));
			$data['create_ip'] = get_client_ip();

			if ($data['s_content'] == null) {
				$this -> error('说说内容不能为空');
				return;
			}			                 
			
            M('Said')->add($data);
			
            $this->success('说说发表成功', U('Said/index'), 1);
        }
    }


	public function edit() {
		
		$detail = M('Said')->where(array('s_id' => I('s_id')))->find();
        $this->assign('detail', $detail);
        $this->display();
		
	}

	public function runedit() {

		$s_id = I('s_id', '', htmlspecialchars);
		
		if (!IS_AJAX) {
            $this->error('提交方式不正确', U('Said/edit'), 0);
        } else {
           
			$create_time = strtotime(date("Y-m-d H:i:s", time()));
			$data['s_content'] = $_POST['s_content'];					
			$data['s_writer'] = trim(I('post.s_writer', '', 'htmlspecialchars'));
			$data['s_view'] = trim(I('post.s_view', '', 'htmlspecialchars'));
			if ($data['s_content'] == null) {
				$this -> error('说说内容不能为空');
				return;
			}			

            M('Said')->where('s_id='.$s_id)->save($data);
			
            $this->success('说说发表成功', U('Said/index'), 1);
        }
	}

    public function del() {

        $p = I('p');
        M('said')->where(array('s_id' => I('s_id')))->delete();
        $this->redirect('index', array('p' => $p));

    }

}
