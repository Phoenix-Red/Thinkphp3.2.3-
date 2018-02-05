<?php

namespace Home\Controller;
use Think\Controller;

class LiuyanController extends BaseController {

    public function index() {
     		
        $liuyan = D('liuyan');        
        $count = M('liuyan') -> count();
        $p = getpage($count,7);		
        $show = $p->show(); 
        $list = $liuyan ->page(I('get.p'))->order('id desc')->limit(7)->select();  
		$newIp = new \Org\Util\IP();
        for ($i=0; $i < count($list); $i++) {
          $list[$i]['ip'] = getIpaddr($list[$i]['ip'],$newIp);
        }    
        $this->assign('page', $show); // 赋值分页输出
        $this->assign('list', $list);      
        $this->display();
    
    }

    public function verify() {
        ob_clean();
        $verify = new \Think\Verify();
        $verify->codeSet = '0123456789';
        $verify->fontSize = '14px';
        $verify->imageW = 95;
        $verify->imageH = 30;
        $verify->length = 4;
        $verify->useCurve = false;
        $verify->useNoise = false;
        $verify->entry();
    }


	public function addContent() {
        $obj = D('liuyan');
		$txt_check = I('post.txt_check');
		
        if (IS_POST) {
            $create_time = strtotime(date("Y-m-d H:i:s", time()));
            $data['add_time'] = $create_time;
            $data['username'] = I('post.username');
            $data['email'] = I('post.email');
            $data['content'] = I('post.content');
			$data['txt_check'] = I('post.txt_check');
			
			$data['ip'] = get_client_ip();
			$data['from'] = getOs();						
	        if (check_verify($txt_check) == false) {
	            $this->error('验证码错误');
	        }
            if ($data['username'] == null) {
                $this->error('昵称不能为空');
                exit;
            }
            if ($data['email'] == null) {
                $this->error('邮箱不能为空');
                exit;
            }
            if ($data['content'] == null) {
                $this->error('留言内容不能为空');
                exit;
            }

			$data['photo'] = session('head');
		
            if ($obj->add($data)) {
            	
                $this->success("提交成功，请等待管理员回复!", U('liuyan/index'));
                return;
            } else {
                $this->error('操作失败！');
                return;
            }
        }

        $this->display();
    }

}

?>