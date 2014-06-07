<?php
func_need_login();	/**< 判断用户是否已登录 */
func_need_admin();	/**< 判断用户是否有管理权限 */
$token = isset($_POST['token'])?$_POST['token']:null;
if(func_verify_token($token)){	/**< 验证token */
	if(!isset($_POST['proj_name']) || !isset($_POST['proj_desc']) || !isset($_POST['proj_params'])){
		echo "1.填写不完整!";
		exit;
	}else if(trim($_POST['proj_name']) == "" || trim($_POST['proj_desc']) == "" || trim($_POST['proj_params']) == ""){
		echo "2.填写不完整!";
		exit;
	}else if(!is_json(trim($_POST['proj_params']))){
		echo "参数数据错误";
		exit;
	}else{
		$setting	= array(	/**< 初始化设置 */
			"perpage"		=> "23",
			"default_show"	=> "",
			"recaptcha_status"		=> 0,
			"mail_status"	=> 0
		);
		//echo $_POST['proj_name']."<br>".$_POST['proj_desc']."<br>".$_POST['proj_params'];
		$params_temp	= json_decode(trim($_POST['proj_params']), true);
		$index	= 0;
		$coll_name	= null;
		$coll_label	= null;
		foreach($params_temp as $value){
			$param_temp		= json_decode(trim($value));
			if(count($param_temp) != 8){
				echo "数据出错.";
				exit;
			}
			$param['name']	= $param_temp[0];
			$param['label']	= $param_temp[1];
			$param['method']	= $param_temp[2];
			$param['type']	= $param_temp[3];
			$param['case']	= $param_temp[4];
			$param['allow_null']	= $param_temp[5];
			$param['regex']	= $param_temp[6];
			$param['comment']	= $param_temp[7];
			$params[$index]	= $param;
			$coll_name[$index]	= $param['name'];
			$coll_label[$index]	= $param['label'];
			$index++;
		}
		if(in_array('id',$coll_name) || in_array('ID',$coll_name) || in_array('Id',$coll_name) || in_array('iD',$coll_name)){
			echo "参数名id为系统参数,不可用.";
			exit;
		}
		if(in_array('ei',$coll_name) || in_array('EI',$coll_name) || in_array('Ei',$coll_name) || in_array('eI',$coll_name)){
			echo "参数名ei为系统参数,不可用.";
			exit;
		}
		if(is_array($coll_name)){
			if(count(array_unique($coll_name)) != count($coll_name)){
				echo "参数名重复.";
				exit;
			}
		}
		if(is_array($coll_label)){
			if(count(array_unique($coll_label)) != count($coll_label)){
				echo "显示名重复.";
				exit;
			}
		}
		//var_dump($params);
		//var_dump($setting);
		$proj	= new Proj($_POST['proj_name'], $_POST['proj_desc'], $params, $setting);
		if($proj->add()){
			echo "添加成功";
			func_gohome();
		}else{
			echo "添加失败";
		}
	}
}else{
	echo "没有权限!";
}
