<?php

namespace Admin\Controller;

use Think\Controller;

header('Content-type:text/html;charset=utf-8');

class LiuyanController extends BaseController {
	
	private $edit_fields   = array('c_photo', 'c_name','c_content', 'c_time');

	public function index() {
		
		$Liuyan = D('Liuyan');		
		$count = $Liuyan -> count();
		$p = getpage($count, C('PAGE_SIZE'));
		$show = $p -> show();
		$list = $Liuyan -> page(I('get.p')) -> limit(C('PAGE_SIZE')) ->order('add_time desc')-> select();
		$newIp = new \Org\Util\IP();
        for ($i=0; $i < count($list); $i++) {
          $list[$i]['ip'] = getIpaddr($list[$i]['ip'],$newIp);
        } 
		$this -> assign('list', $list);
		$this -> assign('page', $show);
		$this -> display();
	}


	public function edit() {
		
		$detail = M('Liuyan')->where(array('id' => I('id')))->find();
        $this->assign('detail', $detail);
        $this->display();
		
	}

	public function runedit() {

		$id = I('id', '', htmlspecialchars);
		
		if (!IS_AJAX) {
            $this->error('提交方式不正确', U('Liuyan/edit'), 0);
        } else {
           
			$update_time = strtotime(date("Y-m-d H:i:s", time()));
			$data['c_content'] = $_POST['c_content'];
			if ($data['c_content'] == null) {
				$this -> error('回复内容不能为空');
				return;
			}		
			$data['c_photo'] = session('admin.userimg');
			$data['c_name'] = session('admin.username');	
			$data['c_time'] = $update_time;		

            M('Liuyan')->where('id='.$id)->save($data);
			
            $this->success('留言回复成功', U('Liuyan/index'), 1);
        }
	}



    public function del() {

        $p = I('p');
        M('Liuyan')->where(array('id' => I('id')))->delete();
        $this->redirect('index', array('p' => $p));

    }

}
