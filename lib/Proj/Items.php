<?php
/**
* 数据管理操作类
*/
class Items {
	var $pid;
	var $item;
	/**
	* 构造函数
	*/
	function __construct($pid) {
		$proj	= new Proj("","", "", "");
		if(!($proj->isExist($pid))){
			throw new Exception("Project is not existed.");
		}
		$this->pid = intval($pid);
		$this->item = new Item($pid, "");
		unset($proj);
	}
	
	/**
	* 获取记录
	*/
	public function getItems($pid){
		$proj	= new Proj("","", "", "");
		if(!($proj->isExist($pid))){
			throw new Exception("Project is not existed.");
		}
		unset($proj);
		
		$table	= TBPREFIX."items_".$this->pid;
		$return = array();
		$query = "select * from {$table} order by `id` desc";
		$result = mysql_query($query) or die(mysql_errno().":".mysql_error());
		while($row = mysql_fetch_array($result)){
			$return[] = $row;
		}
		return $return;
	}
	
	/**
	* 获取要显示的字段
	*/
	public function getShowParams($pid){
		$proj	= new Proj("","", "", "");
		$proj	= new Proj("","", "", "");
		if(!($proj->isExist($pid))){
			throw new Exception("Project is not existed.");
		}
		$params	= $proj->getParams($pid);
		$params_default_show	= array();
		if(is_array($params)){
			foreach($params as $param){
				if($param['default_show'] == 1){
					$params_default_show[] = $param;
				}
			}
			//var_dump($params_default_show);
			if(count($params_default_show) <= 0){
				$i = 0;
				foreach($params as $param){
					$params_default_show[] = $param;
					$i++;
					if($i >= 4){
						break;
					}
				}
			}/*else{	// $proj->getParam($pid)是按jindex大到小排序的, 但优先级时从小到大的, 下面用来重新排序???
				$params_default_show_temp = $params_default_show;
				$index = count($params_default_show) - 1;
				$i = 0;
				for(;$index>=0;$index--){
					$params_default_show[$i] = $params_default_show_temp[$index];
					$i++;
				}
			}*/
			return $params_default_show;
		}else{
			return array();
		}
	}
}
