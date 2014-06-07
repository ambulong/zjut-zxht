<?php
$config['dbHost']		=	'localhost';	/**< 数据库地址 */
$config['dbUser']		=	'jhtest';		/**< 数据库用户名 */
$config['dbPwd']		=	'jhtest';		/**< 数据库密码 */
$config['database']		=	'jhzx';			/**< 数据库名 */
$config['charset']		=	'utf8';
$config['tbPrefix']		=	'jh_';			/**< 表前缀 */
$config['urlroot']		=	'http://localhost/ht';	/**< 网站地址 */
$config['site']			=	array(
	'sitename'		=>	'招新管理',			/**< 网站名 */
	'siteintro'		=>	'精弘网络招新管理',	/**< 网站简介 */
	'keywords'		=>	'精弘, 精弘网络, 招新, 管理',		/**< 网站关键字 */
	'description'	=>	'精弘网络招新管理',	/**< 网站描述 */
	'admin_mail'	=>	'admin@localhost'	/**< 管理员邮箱 */
);
$config['timezone']		=	'Asia/Shanghai';	/**< 时区 */
$config['debug']		=	1;				/**< 是否开启调试模式 */

/**< 邮箱发信配置请到function.php的最后一个函数func_mail()填写 */
?>
