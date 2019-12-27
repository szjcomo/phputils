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
use \think\Image as tpImage;
/**
 * 常用工具类
 */
class Tools
{
	/**
	 * [appResult 统一格式返回值]
	 * @author szjcomo
	 * @DateTime 2019-10-25
	 * @param    string     $info  [description]
	 * @param    mixed      $data  [description]
	 * @param    boolean    $err   [description]
	 * @param    integer    $error [description]
	 * @return   array             [description]
	 */
	public static function appResult(string $info,$data = null,$err = true,$error = 0)
	{
		return ['info'=>$info,'data'=>$data,'err'=>$err,'error'=>$error];
	}
	/**
	 * [sendResult 统一返回值格式]
	 * @author   szjcomo
	 * @dateTime 2019-10-25
	 * @param    string     $info  [description]
	 * @param    mixed      $data  [description]
	 * @param    boolean    $err   [description]
	 * @param    integer    $error [description]
	 * @return   array             [description]
	 */
	public static function sendResult(string $info = null,$data = null,$err = true,$error = 0)
	{
		return ['info'=>$info,'data'=>$data,'err'=>$err,'error'=>$error];
	}

    /**
     * [curl_get 发送get请求]
     * author: szjcomo
     * time  : 2019/10/25
     * @param string $url
     * @param array $header
     */
	public static function curl_get(string $url,array $header = [],$debug = false,$Swoole = false)
    {
        if(extension_loaded("Swoole") && $Swoole) {
           return HttpClient::curl_get($url,$header);
        } else {
        	return self::org_curl_get($url,$header,$debug);
        }
    }
    /**
     * [curl_post 发送post请求]
     * @author 	   szjcomo
     * @createTime 2019-10-25
     * @param      string     $url    [description]
     * @param      [type]     $data   [description]
     * @param      array      $header [description]
     * @param      boolean    $debug  [description]
     * @param      boolean    $Swoole [description]
     * @return     [type]             [description]
     */
    public static function curl_post(string $url,$data,array $header = [],$debug = false,$Swoole = false)
    {
        if(extension_loaded("Swoole") && $Swoole){
           return HttpClient::curl_post($url,$data);
        } else {
        	return self::org_curl_post($url,$data,$header,$debug);
        }
    }
    /**
     * [image 图像处理]
     * @author        szjcomo
     * @createTime 2019-10-26
     * @param      string     $fileName [description]
     * @return     [type]               [description]
     */
    public static function image(string $fileName)
    {
        return tpImage::open($fileName);
    }

    /**
     * [org_curl_get php fpm原生的curl请求方式]
     * @author 	   szjcomo
     * @createTime 2019-10-25
     * @param      string     $url    [description]
     * @param      array      $header [description]
     * @param      boolean    $debug  [description]
     * @return     [type]             [description]
     */
    public static function org_curl_get(string $url,array $header = [],$debug = false)
    {
		try{
			$ch = curl_init();  
			curl_setopt($ch, CURLOPT_URL, $url);  
			curl_setopt($ch, CURLOPT_HEADER, 0);
			if(!empty($header)) curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);  
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);  
			$data = curl_exec($ch);  
			if (curl_errno($ch))  return curl_error($ch);//捕抓异常
			curl_close($ch);
			$debug && print_r($data);
			return $data;
		} catch(\Exception $err){
			if($debug) print_r($err);
			return false;
		}
    }
    /**
     * [org_curl_post 原生的php fpm post请求]
     * @author 	   szjcomo
     * @createTime 2019-10-25
     * @param      string     $url      [description]
     * @param      array      $postdata [description]
     * @param      array      $header   [description]
     * @param      boolean    $debug    [description]
     * @return     [type]               [description]
     */
    public static function org_curl_post(string $url,$postdata = [],array $header = [],$debug = false)
    {
		try{
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			if(!empty($header)) curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);    
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);  
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);  
			$data = curl_exec($ch);
			if (curl_errno($ch)) return curl_error($ch);//捕抓异常
			curl_close($ch);
			$debug && print_r($data);
			return $data;			
		} catch(\Exception $err){
			if($debug) print_r($err);
			return false;
		}
    }

	/**
	 * [Recursion 递归子节点操作]
	 * @Author    como
	 * @DateTime  2019-08-29
	 * @copyright 思智捷管理系统
	 * @version   [1.5.0]
	 * @param     array       $data      [description]
	 * @param     int|integer $pid       [description]
	 * @param     string      $field     [description]
	 * @param     string      $childName [description]
	 */
	public static function Recursion(array $data, $pid = 0, $field = 'id', $childName = 'child')
	{
		$tree = array();
		foreach($data as $key=>$val){
			if($val['pid'] == $pid){
				$val[$childName] = self::Recursion($data,$val[$field],$field,$childName);
				$tree[] = $val;
			}
		}
		return $tree;
	}

	/**
	 * [parentsRecurtion 递归获取所有的父节点]
	 * @author 	   szjcomo
	 * @createTime 2019-10-25
	 * @param      array       $data  [description]
	 * @param      int|integer $cid   [description]
	 * @param      string      $field [description]
	 * @return     mixed              [description]
	 */
	public static function parentsRecurtion(array $data, $cid = 0, $field = 'id')
	{
		static $result = [];
		if($cid == 0) return 0;
		foreach($data as $key=>$val){
			if($val[$field] == $cid){
				$result[] = $val;
				if($val['pid'] != 0){
					self::parentsRecurtion($data,$val['pid'],$field);
				}
			}
		}
		return $result;
	}

	/**
	 * [recursionToArray 将递归后的数组转化成一维数组]
	 * @author 	   szjcomo
	 * @createTime 2019-10-25
	 * @param      array      $data      [description]
	 * @param      string     $childName [description]
	 * @return     array                 [description]
	 */
	public static function recursionToArray(array $data, $childName = 'child')
	{
		$list = array();
		foreach($data as $key=>$val){
			$tempChild = $val[$childName];
			unset($val[$childName]);
			$list[] = $val;
			if(is_array($tempChild) && !empty($tempChild)){
				$temparr = self::RecursionToArray($tempChild);
				$list = array_merge($list,$temparr);
			}
		}
		return $list;
	}
    /**
     * [createDirectory 创建目录]
     * @author 	   szjcomo
     * @createTime 2019-10-25
     * @param string  $dirPath     需要创建的目录
     * @param integer $permissions 目录权限
     * @return bool
     */
    public static function createDirectory(string $dirPath, $permissions = 0755)
    {
        if (!is_dir($dirPath)) {
            try {
                return mkdir($dirPath, $permissions, true) && chmod($dirPath, $permissions);
            } catch (\Throwable $throwable) {
                return false;
            }
        } else {
            return true;
        }
    }

    /**
     * [cleanDirectory 清空一个目录]
     * @author 	     szjcomo
     * @createTime   2019-10-25
     * @param string $dirPath       需要创建的目录
     * @param bool   $keepStructure 是否保持目录结构
     * @return bool
     */
    public static function cleanDirectory(string $dirPath, $keepStructure = false)
    {
        $scanResult = static::scanDirectory($dirPath);
        if (!$scanResult) return false;
        try {
            foreach ($scanResult['files'] as $file) unlink($file);
            if (!$keepStructure) {
                krsort($scanResult['dirs']);
                foreach ($scanResult['dirs'] as $dir) rmdir($dir);
            }
            return true;
        } catch (\Throwable $throwable) {
            return false;
        }
    }
    /**
     * [deleteDirectory 删除一个目录]
     * @author 	   szjcomo
     * @createTime 2019-10-25
     * @param      string     $dirPath [传入目录]
     * @return     bool                [description]
     */
    public static function deleteDirectory(string $dirPath)
    {
        $dirPath = realpath($dirPath);
        if (!is_dir($dirPath)) return false;
        if (!static::cleanDirectory($dirPath)) return false;
        return rmdir(realpath($dirPath));
    }
    /**
     * [copyDirectory 复制目录]
     * @author 	   szjcomo
     * @createTime 2019-10-25
     * @param      string     $source    [源位置]
     * @param      string     $target    [目标位置]
     * @param      boolean    $overwrite [是否覆盖目标文件]
     * @return     boolean               [true/false]
     */
    public static function copyDirectory(string $source, string $target, $overwrite = true)
    {
        $scanResult = static::scanDirectory($source);
        if (!$scanResult) return false;
        if (!is_dir($target)) self::createDirectory($target);
        try {
            $sourceRealPath = realpath($source);
            foreach ($scanResult['files'] as $file) {
                $targetRealPath = realpath($target) . '/' . ltrim(substr($file, strlen($sourceRealPath)), '/');
                static::copyFile($file, $targetRealPath, $overwrite);
            }
            return true;
        } catch (\Throwable $throwable) {
            return false;
        }
    }
    /**
     * 移动目录到另一位置
     * @param string $source    源位置
     * @param string $target    目标位置
     * @param bool   $overwrite 是否覆盖目标文件
     * @return bool
     * @author : evalor <master@evalor.cn>
     */
    public static function moveDirectory($source, $target, $overwrite = true)
    {
        $scanResult = static::scanDirectory($source);
        if (!$scanResult) return false;
        if (!is_dir($target)) self::createDirectory($target);

        try {
            $sourceRealPath = realpath($source);
            foreach ($scanResult['files'] as $file) {
                $targetRealPath = realpath($target) . '/' . ltrim(substr($file, strlen($sourceRealPath)), '/');
                static::moveFile($file, $targetRealPath, $overwrite);
            }
            static::deleteDirectory($sourceRealPath);
            return true;
        } catch (\Throwable $throwable) {
            return false;
        }
    }
    /**
     * 复制文件
     * @author : evalor 
     * @param string $source    源位置
     * @param string $target    目标位置
     * @param bool   $overwrite 是否覆盖目标文件
     * @return bool
     */
    public static function copyFile($source, $target, $overwrite = true)
    {
        if (!file_exists($source)) return false;
        if (file_exists($target) && $overwrite == false) return false;
        elseif (file_exists($target) && $overwrite == true) {
            if (!unlink($target)) return false;
        }
        $targetDir = dirname($target);
        if (!self::createDirectory($targetDir)) return false;
        return copy($source, $target);
    }
    /**
     * 创建一个空文件
     * @param $filePath
     * @param $overwrite
     * @author : evalor 
     * @return bool
     */
    public static function touchFile($filePath, $overwrite = true)
    {
        if(file_exists($filePath) && $overwrite == false) {
            return false;
        } elseif(file_exists($filePath) && $overwrite == true) {
            if(!unlink($filePath)) {
                return false;
            }
        }
        $aimDir = dirname($filePath);
        if(self::createDirectory($aimDir)) {
            try {
                return touch($filePath);
            } catch (\Throwable $throwable) {
                return false;
            }
        } else {
            return false;
        }
    }
    /**
     * 创建一个有内容的文件
     * @param      $filePath
     * @param      $content
     * @param bool $overwrite
     * @author : evalor 
     * @return bool
     */
    public static function createFile($filePath, $content, $overwrite = true)
    {
        if(static::touchFile($filePath, $overwrite)) {
            return (bool)file_put_contents($filePath, $content);
        } else {
            return false;
        }
    }
    /**
     * 移动文件到另一位置
     * @param string $source    源位置
     * @param string $target    目标位置
     * @param bool   $overwrite 是否覆盖目标文件
     * @return bool
     * @author : evalor 
     */
    public static function moveFile($source, $target, $overwrite = true)
    {
        if(!file_exists($source)) return false;
        if (file_exists($target) && $overwrite == false) return false;
        elseif(file_exists($target) && $overwrite == true) {
            if(!unlink($target)) return false;
        }
        $targetDir = dirname($target);
        if (!self::createDirectory($targetDir)) return false;
        return rename($source, $target);
    }
    /**
     * [scanDirectory 遍历目录]
     * @author   szjcomo
     * @DateTime 2019-10-25
     * @param string $dirPath
     * @return array|bool
     */
    public static function scanDirectory($dirPath)
    {
        if(!is_dir($dirPath)) return false;
        $dirPath = realpath($dirPath) . '/';
        $dirs = array( $dirPath );
        $fileContainer = array();
        $dirContainer = array();
        try {
            do {
                $workDir = array_pop($dirs);
                $scanResult = scandir($workDir);
                foreach ($scanResult as $files) {
                    if($files == '.' || $files == '..') continue;
                    $realPath = $workDir . $files;
                    if(is_dir($realPath)) {
                        array_push($dirs, $realPath . '/');
                        $dirContainer[] = $realPath;
                    } elseif (is_file($realPath)) {
                        $fileContainer[] = $realPath;
                    }
                }
            } while ($dirs);
        } catch (\Throwable $throwable) {
            return false;
        }
        return [ 'files' => $fileContainer, 'dirs' => $dirContainer ];
    }
    /**
     * [getRandStr 获取随机字符串]
     * @author szjcomo
     * @DateTime 2019-09-06T16:29:41+0800
     * @param    int|integer              $length [description]
     * @return   [type]                           [description]
     */
    public static function getRandStr( $length = 32)
    {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";  
        $str   = "";
        for ( $i = 0; $i < $length; $i++ )  {  
            $str .= substr($chars, mt_rand(0, strlen($chars)-1), 1);  
        } 
        return $str;
    }
    /**
     * [xmlToArray xml到数组转化]
     * @author szjcomo
     * @DateTime 2019-09-06T16:30:59+0800
     * @param    string                   $xml [description]
     * @return   [type]                        [description]
     */
    public static function xmlToArray(string $xml)
    {
        try{
            libxml_disable_entity_loader(true);
            return json_decode(json_encode(@simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA | LIBXML_NOBLANKS)), true);
        } catch(\Throwable $err){
            return self::sendResult($err->getMessage());
        }
    }
}

