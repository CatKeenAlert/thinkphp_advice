<?php
// 系统登录类
class LoginAction extends Action {

	public function index()
	{
		$this->display('login');
	}
	
	public function chklogin()
	{
		$my=array();
		$my['email']=$_POST['email'];
		$my['password']=$_POST['password'];
		$m=M('users');
		$arr=$m->where($my)->find();

//		var_dump($arr);
		if($arr>0)
		{
			$_SESSION['id'] = $arr['id'];
			$_SESSION['name'] = $arr['name'];
			$_SESSION['ustype']=$arr['ustype'];
//			var_dump($_SESSION['name']);
			$this->redirect('Index/index');
			
		}else
		{
			$this->error('用户名或密码错误，请重新提交!');
		}
		
	}
	
	public function reg()
	{
		$this->display('reg');
	}
	public function chkreg()
	{
		if($_SESSION['verify']!=md5($_POST['code']))
		{
			$this->error('验证码错误，请重新提交！');
		}else
		{
			$my=array();
			$my['name']=$_POST['name'];
			$my['email']=$_POST['email'];
			$my['password']=$_POST['password'];
			$my['ustype']="user";
			$m=M('users');
			$name=$my['email'];
			$has=$m->where("email='$name'")->find();
//			var_dump($my);
//			var_dump($has);
			if($has)
			{
				$this->error('以存在同样的公司邮箱用户，请重新注册');
			}
			$arr=$m->add($my);
			if($arr>0)
			{
				$this->success('注册成功，跳转到登陆页',U('Login/login'),2);
			}else
			{
				$this->error('注册失败，请重新注册');
			}
		}
		
	}
	
	public function logout()
	{
		$_SESSION=array();
		session_destroy();
		$this->redirect('login');
	}
}