<?php
func_need_login();
header("location:".func_url("show", "proj_list"));
