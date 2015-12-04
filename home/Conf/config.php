<?php
return array(
	//'配置项'=>'配置值'
	'DB_PREFIX' => '',
	'DB_TYPE'=>'mysql',   //设置数据库类型
	'DB_HOST'=>'localhost',//设置主机
	'DB_NAME'=>'thinkphp',//设置数据库名
	'DB_USER'=>'root',    //设置用户名
	'DB_PWD'=>'',        //设置密码
	'DB_PORT'=>'3306',   //设置端口号
	//添加自己的模板变量规则
	'TMPL_PARSE_STRING'=>array(           
	'__CSS__'=>__ROOT__.'/assets/css',
	'__JS__'=>__ROOT__.'/assets/js',
	'__FONTS__'=>__ROOT__.'/assets/fonts',
	'__IMG__'=>__ROOT__.'/assets/i',
	),
);
?>