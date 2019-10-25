<?php
/**
 * |-----------------------------------------------------------------------------------
 * @Copyright (c) 2014-2018, http://www.sizhijie.com. All Rights Reserved.
 * @Website: www.sizhijie.com
 * @Version: 思智捷信息科技有限公司
 * @Author : szjcomo 
 * |-----------------------------------------------------------------------------------
 */

namespace szjcomo\phputils;

/**
 * 身份证号码操作类
 */
class IdentityNum 
{

	/**
	 * [getSex 根据身份证号码计算性别]
	 * @author 	   szjcomo
	 * @createTime 2019-10-25
	 * @param      string     $identitynumber [身份证号码]
	 * @return     string                     [description]
	 */
	public static function getSex(string $identitynumber):string
	{
		if(empty($identitynumber) || !self::isIdentityNum($identitynumber)) return null;
		if(strlen($identitynumber) == 15){
			$sexint = (int) substr($identitynumber,14,1);
		} else {
        	$sexint = (int) substr($identitynumber, 16, 1);		
		}
		return $sexint % 2 === 0 ? '女' : '男';
	}

	/**
	 * [getAge 根据身份证号码计算年龄]
	 * @author 	   szjcomo
	 * @createTime 2019-10-25
	 * @param      string     $identitynumber [身份证号码]
	 * @param      integer    $addAge         [是否增加年龄]
	 * @return     integer                    [description]
	 */
	public static function getAge(string $identitynumber,$addAge = 0):int
	{
		if(empty($identitynumber) || !self::isIdentityNum($identitynumber)) return 0;
        $born = self::getBorn($identitynumber);
        if(empty($born)) return -1;
        $now_time = strtotime("now") + $addAge;
        $born_time = strtotime($born);
        $age = floor(($now_time - $born_time)/86400/365);
        return $age<0?-1:$age;
	}

	/**
	 * [getBorn 根据身份证号码计算生日]
	 * @author 	   szjcomo
	 * @createTime 2019-10-25
	 * @param      string     $identitynumber [身份证号码]
	 * @return     string                     [description]
	 */
	public static function getBorn(string $identitynumber):string
	{
		if(empty($identitynumber) || !self::isIdentityNum($identitynumber)) return null;
        $birthday = ""; 
        if(strlen($identitynumber) == 15){
        	$birthday = '19'.substr($identitynumber,6,6);
        } else {
        	$birthday = substr($identitynumber,6,8);
        }
        $birthday = preg_replace('/(.{4})(.{2})/',"$1-$2-",$birthday);
        return $birthday;
	}
	/**
	 * [getZodiac 计算生肖]
	 * @author 	   szjcomo
	 * @createTime 2019-10-25
	 * @param      string     $identitynumber [身份证号码]
	 * @return     [type]                     [description]
	 */
	public static function getZodiac(string $identitynumber):string
	{
		if(empty($identitynumber) || !self::isIdentityNum($identitynumber)) return null;
	    $start = 1901;
	    $born = self::getBorn($identitynumber);
	    if(empty($born)) return '';
	    $end = date('Y',strtotime($born));
	    $x = ($start - $end) % 12;
	    $val = '';
	    if ($x == 1 || $x == -11) $val = '鼠';
	    if ($x == 0)              $val = '牛';
	    if ($x == 11 || $x == -1) $val = '虎';
	    if ($x == 10 || $x == -2) $val = '兔';
	    if ($x == 9 || $x == -3)  $val = '龙';
	    if ($x == 8 || $x == -4)  $val = '蛇';
	    if ($x == 7 || $x == -5)  $val = '马';
	    if ($x == 6 || $x == -6)  $val = '羊';
	    if ($x == 5 || $x == -7)  $val = '猴';
	    if ($x == 4 || $x == -8)  $val = '鸡';
	    if ($x == 3 || $x == -9)  $val = '狗';
	    if ($x == 2 || $x == -10) $val = '猪';
	    return $val;
	}
	/**
	 * [getStarsign 计算星座]
	 * @author 	   szjcomo
	 * @createTime 2019-10-25
	 * @param      string     $identitynumber [身份证号码]
	 * @return     [type]                     [description]
	 */
	public static function getStarsign(string $identitynumber):string
	{
		if(empty($identitynumber) || !self::isIdentityNum($identitynumber)) return null;
		$born = self::getBorn($identitynumber);
		if(empty($born)) return '';
		$time = strtotime($born);
		$b = date('Y',$time);
		$m = (int)date('m',$time);
		$d = (int)date('d',$time);
	    $val = '';
	    if(($m == 1 && $d <= 21) || ($m == 2 && $d <= 19)){
	        $val = "水瓶座";
	    }else if (($m == 2 && $d > 20) || ($m == 3 && $d <= 20)){
	        $val = "双鱼座";
	    }else if (($m == 3 && $d > 20) || ($m == 4 && $d <= 20)){
	        $val = "白羊座";
	    }else if (($m == 4 && $d > 20) || ($m == 5 && $d <= 21)){
	        $val = "金牛座";
	    }else if (($m == 5 && $d > 21) || ($m == 6 && $d <= 21)){
	        $val = "双子座";
	    }else if (($m == 6 && $d > 21) || ($m == 7 && $d <= 22)){
	        $val = "巨蟹座";
	    }else if (($m == 7 && $d > 22) || ($m == 8 && $d <= 23)){
	        $val = "狮子座";
	    }else if (($m == 8 && $d > 23) || ($m == 9 && $d <= 23)){
	        $val = "处女座";
	    }else if (($m == 9 && $d > 23) || ($m == 10 && $d <= 23)){
	        $val = "天秤座";
	    }else if (($m == 10 && $d > 23) || ($m == 11 && $d <= 22)){
	        $val = "天蝎座";
	    }else if (($m == 11 && $d > 22) || ($m == 12 && $d <= 21)){
	        $val = "射手座";
	    }else if (($m == 12 && $d > 21) || ($m == 1 && $d <= 20)){
	        $val = "魔羯座";
	    }
	    return $val;
	}
	/**
	 * [repairIdentity 17位身份证号码自动补全]
	 * @author 	   szjcomo
	 * @createTime 2019-10-25
	 * @param      string     $identitynumber [身份证号码]
	 * @return     [type]                     [description]
	 */
	public static function repairIdentity(string $identitynumber):string
	{
        if (strlen($identitynumber) == 17) {
            $str = str_split($identitynumber);
            $sum = 0;
            $xs = [7,9,10,5,8,4,2,1,6,3,7,9,10,5,8,4,2];
            foreach ($str as $k => $v) {
                $sum+=$v*$xs[$k];
            }
            $dy = [1,0,'X',9,8,7,6,5,4,3,2];
            $identitynumber .= $dy[$sum%11];
        }
        $rule = '/(^[1-9]\d{5}(18|19|([23]\d))\d{2}((0[1-9])|(10|11|12))(([0-2][1-9])|10|20|30|31)\d{3}[0-9Xx]$)|(^[1-9]\d{5}\d{2}((0[1-9])|(10|11|12))(([0-2][1-9])|10|20|30|31)\d{2}$)/';
        if (1 === preg_match($rule, (string) $identitynumber)) {
            return $identitynumber;
        } else {
            return false;
        }
	}
	/**
	 * [isIdentityNum 严格的身份证号码验证]
	 * @author 	   szjcomo
	 * @createTime 2019-10-25
	 * @param      string     $id [身份证号码]
	 * @return     boolean        [description]
	 */
	public static function isIdentityNum(string $id):bool
	{
		$id = strtoupper($id);
		$regx = "/(^\d{15}$)|(^\d{17}([0-9]|X)$)/";
		$arr_split = array();
		if(!preg_match($regx, $id)){
			return FALSE;
		}
		if(15==strlen($id)) {
			$regx = "/^(\d{6})+(\d{2})+(\d{2})+(\d{2})+(\d{3})$/";
			@preg_match($regx, $id, $arr_split);
			$dtm_birth = "19".$arr_split[2] . '/' . $arr_split[3]. '/' .$arr_split[4];
			if(!strtotime($dtm_birth)){
			  	return FALSE;
			} else {
			  	return TRUE;
			}
		} else {
		    $regx = "/^(\d{6})+(\d{4})+(\d{2})+(\d{2})+(\d{3})([0-9]|X)$/";
		    @preg_match($regx, $id, $arr_split);
		    $dtm_birth = $arr_split[2] . '/' . $arr_split[3]. '/' .$arr_split[4];
		    if(!strtotime($dtm_birth)) {
		      	return FALSE;
		    } else {
				$arr_int = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);
				$arr_ch = array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');
				$sign = 0;
				for ( $i = 0; $i < 17; $i++ ){
					$b = (int) $id{$i};
					$w = $arr_int[$i];
					$sign += $b * $w;
				}
				$n = $sign % 11;
				$val_num = $arr_ch[$n];
				if ($val_num != substr($id,17, 1)){
					return FALSE;
				} else {
					return TRUE;
				}
		    }
	  	}
	}

}