<?php
namespace Admin\Controller;
use Think\Controller;
class AdvertController extends BaseController {
    private $createadvert_fields = array('title', 'subtitle ','info','adverttype','addtime','imageurl','linker','phone','state','address','routecode','clickcount','updatetime','city_id','area_id','shop_id','pointx','pointy');
    private $editadvert_fields = array('title', 'subtitle ','info','adverttype','imageurl','linker','phone','state','address','routecode','updatetime','pointx','pointy','city_id','area_id','shop_id');
    private $createadvType_fields=array('name','note');
    private $editadvType_fields=array('name','note');
    
    public function index(){
        $advert = D('advert');
        $adverttype = D('adverttype');
        $count = $advert->count(); 
        $p = getpage($count,C('PAGE_SIZE'));
        $show = $p->show(); 
        $list = $advert->page(I('get.p'))->order('id desc')->limit(C('PAGE_SIZE'))->select();
        $list1 = $adverttype->select();
        $this->assign('page', $show); // 赋值分页输出
        $this->assign('list', $list);
        $this->assign('list1', $list1);
        $this->display();
    }


    public function add(){
        $adverttype = D('adverttype');
        $list = $adverttype->select();

        if (IS_POST) {
            $data = $this->addCheck();
            $obj = D('advert');
            if ($obj->add($data)) {
                $this->success("保存成功", U('Advert/index'));
                return;
            }else {
            $this->error('操作失败！');
            return;
         } 
        }
        $this->assign('list', $list);
        $this->display();
    }

    private function addCheck() {
        $param = I('post.');
        $data = $this->checkFields($param["data"], $this->createadvert_fields);
        $add_time = strtotime(date("Y-m-d H:i:s",time()));
        $data['title'] = trim(I('post.title', '', 'htmlspecialchars'));
        if (D('advert')->getAdvertTitle($data['title'])) {
            $this->error('标题已经存在');
            exit;
        }
        if (empty($data['title'])) {
            $this->error('标题不能为空');
        }
        $data['subtitle'] = trim(I('post.subtitle', '', 'htmlspecialchars'));
        if (empty($data['subtitle'])) {
            $this->error('子标题不能为空');
        }
        $data['adverttype'] = trim(I('post.adverttype', '', 'htmlspecialchars')); 
        $data['imageurl'] = trim(I('post.imageurl', '', 'htmlspecialchars'));
        $data['info'] = $_POST['info'];
        if (empty($data['info'])) {
            $this->error('广告内容不能为空');
        }
        $data['linker'] = trim(I('post.linker', '', 'htmlspecialchars'));
        if (empty($data['linker'])) {
            $this->error('联系人不能为空');
        }
        $data['phone'] = trim(I('post.phone', '', 'htmlspecialchars'));
        if (empty($data['phone'])) {
            $this->error('手机号码不能为空');
        }
        $data['state'] = trim(I('post.state', '', 'htmlspecialchars'));
        $data['routecode'] = implode(",",$_POST['routecode']);
        $data['address'] = trim(I('post.address', '', 'htmlspecialchars'));
        if (empty($data['address'])) {
            $this->error('地址不能为空');
        }
        $data['clickcount'] = 0;
        $data['addtime'] = $add_time;
        $data['updatetime'] = $add_time;
        return $data;
    }
    
    public function edit($id = 0) {
        if ($id = (int) $id) {
            $obj = D('advert');
            $adverttype = D('adverttype');
            $list = $adverttype->select();
            if (!$detail = $obj->find($id)) {
                $this->error('请选择要编辑的广告');
            }
            if (IS_POST) {
                $data = $this->editCheck();
                $data['id'] = $id;  
                if ($obj->save($data)) {
                    $this->success('操作成功', U('Advert/index'));
                } else {
                    $this->error('操作失败');
                }
            } else {
                $this->assign('list', $list);
                $this->assign('detail', $detail);
                $this->display();
            }
        } else {
            $this->error('请选择要编辑的广告');
        }
    }

    private function editCheck() {
        $param = I('post.');
        $data = $this->checkFields($param['data'], $this->editadvert_fields);
        $update_time = strtotime(date("Y-m-d H:i:s",time()));
        $data['title'] = trim(I('post.title', '', 'htmlspecialchars'));
        if (empty($data['title'])) {
            $this->error('标题不能为空');
        }
        $data['subtitle'] = trim(I('post.subtitle', '', 'htmlspecialchars'));
        if (empty($data['subtitle'])) {
            $this->error('子标题不能为空');
        }
        $data['adverttype'] = trim(I('post.adverttype', '', 'htmlspecialchars')); 
        $data['imageurl'] = trim(I('post.imageurl', '', 'htmlspecialchars'));
        $data['info'] = $_POST['info'];
        if (empty($data['info'])) {
            $this->error('广告内容不能为空');
        }
        $data['linker'] = trim(I('post.linker', '', 'htmlspecialchars'));
        if (empty($data['linker'])) {
            $this->error('联系人不能为空');
        }
        $data['phone'] = trim(I('post.phone', '', 'htmlspecialchars'));
        if (empty($data['phone'])) {
            $this->error('手机号码不能为空');
        }
        $data['state'] = trim(I('post.state', '', 'htmlspecialchars'));
        $data['routecode'] = implode(",",$_POST['routecode']);
        $data['address'] = trim(I('post.address', '', 'htmlspecialchars'));
        if (empty($data['address'])) {
            $this->error('地址不能为空');
        }
        $data['updatetime'] = $update_time;
        return $data;
    }                     
    
    public function del() {
        $advert = D('advert');
        $id = I('get.id');
        $result = $advert->where('id =' . $id . '')->delete();
        if ($result) {
            $this->success('删除成功', U('Advert/index'));
        } else {
            $this->error('删除失败');
        }
    }
    
    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	/**
	 * 广告类型
	 */
	 public function indextype(){
            $adverttype = D('adverttype');
            $count = $adverttype->count(); 
            $p = getpage($count,C('PAGE_SIZE'));
            $show = $p->show(); 
            $list = $adverttype->page(I('get.p'))->order('id asc')->limit(C('PAGE_SIZE'))->select();
            $this->assign('page', $show); // 赋值分页输出
            $this->assign('list', $list);
            $this->display();
	 }
	 /*
	  * 添加广告类型
	  */
	 public function addtype(){
            if (IS_POST) {
            $data = $this->addtypeCheck();
            $obj = D('adverttype');
            if ($obj->add($data)) {
                $this->success("保存成功", U('Advert/indextype'));
                return;
            }else {
                    $this->error('操作失败！');
                    return;
                } 
            }
            $this->display();
            }
            private function addtypeCheck(){
                   $param = I('post.');
           $data = $this->checkFields($param["data"], $this->createadvType_fields);
                   $data['name'] = trim(I('post.name', '', 'htmlspecialchars'));
           if (D('adverttype')->getAdvertTypeTitle($data['name'])) {
               $this->error('标题已经存在');
               exit;
           }
           if (empty($data['name'])) {
               $this->error('标题不能为空');
           }
           $data['note'] = trim(I('post.note', '', 'htmlspecialchars'));
           if(empty($data['note'])){
                   $this->error('内容不能为空');
           }
           return $data;
	 }
	 /*
	  * 编辑广告类型
	  */
	  public function edittype($id=0){
	  	$obj = D('adverttype');
	  	if ($id = (int) $id) {
            if (!$detail = $obj->find($id)) {
                $this->error('请选择要编辑的广告类型');
            }
            if (IS_POST) {
                $data = $this->editTypeCheck();
                $data['id'] = $id;  
                if ($obj->save($data)) {
                    $this->success('操作成功', U('Advert/indextype'));
                } else {
                    $this->error('操作失败');
                }
            } else {
                $this->assign('detail', $detail);
                $this->display();
            }
        } else {
            $this->error('请选择要编辑的广告');
        }
	  }
	 private function editTypeCheck(){
            $param = I('post.');
            $data = $this->checkFields($param["data"], $this->editadvType_fields);
                    $data['name'] = trim(I('post.name', '', 'htmlspecialchars'));
            if (empty($data['name'])) {
                $this->error('标题不能为空');
            }
                    $data['note'] = trim(I('post.note', '', 'htmlspecialchars'));
                    if(empty($data['note'])){
                            $this->error('内容不能为空');
                    }
                    return $data;
	 }
	 public function deltype() {
            $adverttype = D('adverttype');
            $id = I('get.id');
            $result = $adverttype->where('id =' . $id . '')->delete();
            if ($result) {
                $this->success('删除成功', U('Advert/indextype'));
            } else {
                $this->error('删除失败');
            }
        }
}

      