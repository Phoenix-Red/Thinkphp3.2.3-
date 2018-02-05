<?php

namespace Admin\Controller;

use Think\Controller;

header('Content-type:text/html;charset=utf-8');

class NewsController extends BaseController {

    private $create_fields1 = array( 'catename', 'subtitle', 'sort', 'note');
    private $edit_fields1 = array( 'catename', 'subtitle', 'sort', 'note');
    private $create_fields = array('title', 'info', 'select', 'image_url','cate_id');
    private $edit_fields = array('title', 'info', 'select', 'image_url','cate_id');

    public function index() {
        $News = D('News');
		$Newscate = D('Newscate')->select();
        $count = $News->count(); // 查询满足要求的总记录数 

        $p = getpage($count, 5);
        $show = $p->show();
        $list = $News->page(I('get.p'))->limit(5)->select();
        $this->assign('list', $list);
		
		$this->assign('list1',$Newscate);
		
        $this->assign('page', $show);
        $this->display();
    }

    public function newscate() {
        $News = D('Newscate');
        $count = $News->count(); // 查询满足要求的总记录数 

        $p = getpage($count, C('PAGE_SIZE'));
        $show = $p->show();
        $list = $News->page(I('get.p'))->limit(C('PAGE_SIZE'))->select();
        $this->assign('list', $list);
        $this->assign('page', $show);
        $this->display();
    }

    public function edit($id = 0) {
        $obj = D('News');
        $list2=D('newscate')->select();
        if ($id = (int) $id) {
            if (!$detail = $obj->find($id)) {
                $this->error('请选择要编辑新闻');
            }
            if (IS_POST) {
                $data = $this->editCheck();
                $data['id'] = $id;
                if ($obj->save($data)) {
                    $this->success('操作成功', U('News/index'));
                    return;
                } else {
                    $this->error('操作失败');
                    return;
                }
            } else {
                $this->assign('list2', $list2);
			
                $this->assign('detail', $detail);
                $this->display();
            }
        } else {
            $this->error('请选择要编辑新闻');
        }
    }

    private function editCheck() {

        $param = I('post.');
        $data = $this->checkFields($param['data'], $this->edit_fields);
        $create_time = strtotime(date("Y-m-d H:i:s", time()));
        $data['update_time'] = $create_time;
        $data['title'] = trim(I('post.title', '', 'htmlspecialchars'));
		$data['keyword'] = trim(I('post.keyword', '', 'htmlspecialchars'));
        $data['info'] = $_POST['info'];
        $data['image_url'] = htmlspecialchars($data['image_url']);
		$data['cate_id'] = trim(I('post.cate_id', '', 'htmlspecialchars'));
        if ($data['title'] == null) {
            $this->error('标题不能为空');
            return;
        }
        if ($data['info'] == null) {
            $this->error('内容不能为空');
            return;
        }

        return $data;
    }

    public function editcate($id = 0) {
        $obj = D('Newscate');
        if ($id = (int) $id) {
            if (!$detail = $obj->find($id)) {
                $this->error('请选择要编辑新闻分类');
            }
            if (IS_POST) {
                $data = $this->editCheck1();
                $data['id'] = $id;
                if ($obj->save($data)) {
                    $this->success('操作成功', U('News/newscate'));
                    return;
                } else {
                    $this->error('操作失败');
                    return;
                }
            } else {

                $this->assign('detail', $detail);
                $this->display();
            }
        } else {
            $this->error('请选择要编辑新闻分类');
        }
    }

    private function editCheck1() {

        $param = I('post.');
        $data = $this->checkFields($param["data"], $this->edit_fields1);
        $create_time = strtotime(date("Y-m-d H:i:s", time()));
        $data['add_time'] = $create_time;
        $data['catename'] = trim(I('post.catename', '', 'htmlspecialchars'));
        $data['subtitle'] = trim(I('post.subtitle', '', 'htmlspecialchars'));
        $data['sort'] = trim(I('post.sort', '', 'htmlspecialchars'));
        $data['note'] = trim(I('post.note', '', 'htmlspecialchars'));
        if ($data['catename'] == null) {
            $this->error('分类名称不能为空');
            return;
        }
        if ($data['subtitle'] == null) {
            $this->error('子分类名称不能为空');
            return;
        }
        if ($data['sort'] == null) {
            $this->error('排序号不能为空');
            return;
        }
        return $data;
    }

    public function add() {
        $obj = D('News');
          $list2=D('Newscate')->select();
        if (IS_POST) {
            $data = $this->createCheck();

            if ($obj->add($data)) {
                $this->success("保存成功", U('News/index'));
                return;
            } else {
                $this->error('操作失败！');
                return;
            }
        }
        $this->assign('list2', $list2);
        $this->display();
    }

    private function createCheck() {

        $param = I('post.');
        $data = $this->checkFields($param["data"], $this->create_fields);
        $create_time = strtotime(date("Y-m-d H:i:s", time()));
        $data['add_time'] = $create_time;
        $data['title'] = trim(I('post.title', '', 'htmlspecialchars'));
		$data['keyword'] = trim(I('post.keyword', '', 'htmlspecialchars'));
        $data['info'] = $_POST['info'];       
        $data['image_url'] = htmlspecialchars($data['image_url']);
		$data['cate_id'] = trim(I('post.cate_id', '', 'htmlspecialchars'));
        if ($data['title'] == null) {
            $this->error('标题不能为空');
            return;
        }
        if ($data['info'] == null) {
            $this->error('内容不能为空');
            return;
        }

        return $data;
    }

    public function addcate() {
        $obj = D('Newscate');
        if (IS_POST) {
            $data = $this->createCheck1();

            if ($obj->add($data)) {
                $this->success("保存成功", U('News/newscate'));
                return;
            } else {
                $this->error('操作失败！');
                return;
            }
        }
        $this->display();
    }

    private function createCheck1() {

        $param = I('post.');
        $data = $this->checkFields($param["data"], $this->create_fields1);
        $create_time = strtotime(date("Y-m-d H:i:s", time()));
        $data['add_time'] = $create_time;
        $data['catename'] = trim(I('post.catename', '', 'htmlspecialchars'));
        $data['subtitle'] = trim(I('post.subtitle', '', 'htmlspecialchars'));
        $data['sort'] = trim(I('post.sort', '', 'htmlspecialchars'));
        $data['note'] = trim(I('post.note', '', 'htmlspecialchars'));
        
        if ($data['catename'] == null) {
            $this->error('分类名称不能为空');
            return;
        }
        if ($data['subtitle'] == null) {
            $this->error('子分类名称不能为空');
            return;
        }
        if ($data['sort'] == null) {
            $this->error('排序号不能为空');
            return;
        }
        return $data;
    }

    public function del() {
        $News = D('News');
        $id = I('get.id');
        $result = $News->where('id =' . $id . '')->delete();
        if ($result) {
            $this->success('删除成功', U('News/index'));
        } else {
            $this->error('删除失败');
        }
    }

    public function delcate() {
        $News = D('Newscate');
        $id = I('get.id');
        $result = $News->where('id =' . $id . '')->delete();
        if ($result) {
            $this->success('删除成功', U('News/newscate'));
        } else {
            $this->error('删除失败');
        }
    }

}
