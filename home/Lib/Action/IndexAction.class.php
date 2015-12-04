<?php
// 本类由系统自动生成，仅供测试用途
class IndexAction extends Action {
	
	Public function _initialize()
	{
		//前缀方法
		if(!isset($_SESSION['id']))
		{
			$this->redirect('Login/login');
		}
		
	}
    public function index(){
		$this->display('index');
    }
	
	public function upload()
	{
		if($_SESSION['verify']!=md5($_POST['code']))
		{
			$this->error('验证码错误，请重新提交！');
		}
		$my=array();
		$my['title']=$_POST['title'];
		$my['name']=$_POST['name'];
		$my['type']=$_POST['type'];
		$my['time']=$_POST['time'];
		$my['content']=$_POST['content'];
		$my['uid']=$_POST['uid'];
//		var_dump($my);
		switch($my['type'])
		{
			case "1":$my['type']="工作 / Work";break;
			case "2":$my['type']="生活 / Life";break;
			case "3":$my['type']="娱乐 / Entertainment";break;
			case "4":$my['type']="情感 / Emotional";break;
		}
		
		$m=M('advices');
		$arr=$m->add($my);
		if($arr>0)
		{
			$this->success('提交成功',U('Index/adlist'),2); 
		}else
		{
			$this->error('提交失败，请重新提交');
		}
		
//		var_dump($my);
	}

    public function help()
    {
    	$this->display('help');
    }

    public function adlist()
    {
		import('ORG.Util.Page'); // 导入分页类
		load('extend');
		$m=M('advices');
		$count=$m->count();// 查询满足要求的总记录数 $map表示查询条件
    	$Page=new Page($count,8);// 实例化分页类 传入总记录数
    	$show=$Page->show();// 分页显示输出
		
		$arr=$m->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
//		var_dump($arr);
		$this->assign('advice',$arr);
		$this->assign('page',$show);

    	$this->display('adlist');
    }
	public function delete()
	{
		$id=$_GET['id'];
		$m=M('advices');
		$arr=$m->where("id='$id'")->delete();
		$m2=M('message');
		$arr2=$m2->where("adid='$id'")->delete();
//		var_dump($arr);
		if($arr>0)
		{
			$this->redirect('Index/adlist');
		}else
		{
			$this->error('删除错误，请重新删除.');
		}
	}
	
	public function advice()
	{
		$id=$_GET['id'];
		$m=M('advices');
		$arr=$m->find($id);
		
		$m2=M('message');
		$arr2=$m2->where('adid='.$id)->select();
		
		
//		var_dump($arr2);
//		var_dump($arr);
		$this->assign('ad',$arr);
		$this->assign('mes',$arr2);
		$this->display('advice');
	}
	public function huifu()
	{
		//admin回复
		$my=array();
		$my['id']=$_POST['id'];
		$my['chk']=$_POST['chk'];
		$my['ok']='1';
		$m=M('advices');
		$arr=$m->save($my);
		if($arr>0)
		{
			$this->success('回复成功',U('Index/adlist'),2);
		}else
		{
			$this->error('提交错误,请重新填写.');
		}
	}
	
	public function message()
	{
		$my=array();
		$my['name']=$_POST['name'];
		$my['content']=$_POST['content'];
		$my['adid']=$_POST['adid'];
		$my['time']=$_POST['time'];
		$my['uid']=$_SESSION['id'];
//		var_dump($my);
		$m=M('message');
		$arr=$m->add($my);
		if($arr>0)
		{
			$this->redirect('Index/advice?id='.$my['adid']);
		}else
		{
			$this->error('留言错误');
		}
	}
	
	public function aduserinfor()
	{
		$m=M('users');
		$id=$_SESSION['id'];
		$arr=$m->find($id);
//		var_dump($arr);
		$this->assign('user',$arr);
		$this->display('aduserinfor');
	}
	public function chkuser()
	{
		$data=array();
		$data['name']=$_POST['name'];
		$data['password']=$_POST['newpassword'];
		
		$password=$_POST['password'];
		
		$m=M('users');
		$id=$_SESSION['id'];
		$arr=$m->find($id);
//		var_dump($arr);
		if($password!=$arr['password'])
		{
			$this->error('原始密码不正确，请重新提交');
		}else
		{
			$arr2=$m->where("id='$id'")->save($data);
			if($arr2>0)
			{
				$this->success('资料修改成功',U('Login/logout'));
			}else
			{
				$this->error('资料修改错误，请重新修改');
			}
		}
		
	}
	

}