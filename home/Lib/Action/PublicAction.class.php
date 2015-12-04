<?php
// 本类是公共方法和验证码
class PublicAction extends Action{
	public function code()
	{
		import('ORG.Util.Image');
		Image::buildImageVerify();
	}
}