zjut-zxht
=========

精弘网络招新后台

### AUTHOR
[zeng.ambulong@gmail.com](mailto:zeng.ambulong@gmail.com)

### RELEASE INFORMATION
*ZJUT-ZXHT 1.0*

### SYSTEM REQUIREMENTS

PHP 5.2.0 or later; we recommend using the
latest PHP version whenever possible.

### INSTALLATION

Import the file `./jhzx.sql` to your MySQL database

Config the php file `./config.php`
```php
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
	'siteintro'		=>	'精弘网络招新管理',		/**< 网站简介 */
	'keywords'		=>	'精弘, 精弘网络, 招新, 管理',		/**< 网站关键字 */
	'description'	=>	'精弘网络招新管理',		/**< 网站描述 */
	'admin_mail'	=>	'admin@localhost'			/**< 管理员邮箱 */
);
$config['timezone']		=	'Asia/Shanghai';	/**< 时区 */
$config['debug']		=	1;				/**< 是否开启调试模式 */
```

If you want to open 'new message alert', you need to config PHPMailer in file `./function.php` at line 200 to 233

You can can change the administartor's username 'zjut' in table 'jh_users', the default password is 'jinghong'

###Reporting Potential Security Issues

If you have encountered a potential security vulnerability in this project, please report it to us at [zeng.ambulong@gmail.com](mailto:zeng.ambulong@gmail.com). We will work with you to verify the vulnerability and patch it.

###Want to contribute?

Fork us!

### LICENSE

This software is licenced under the [LGPL 2.1](http://www.gnu.org/licenses/lgpl-2.1.html). Please read LICENSE for information on the
software availability and distrib

### ACKNOWLEDGEMENTS

This is a project for [精弘网络](http://www.zjut.com)
