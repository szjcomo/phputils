<?php
/**
 * |-----------------------------------------------------------------------------------
 * @Copyright (c) 2014-2018, http://www.sizhijie.com. All Rights Reserved.
 * @Website: www.sizhijie.com
 * @Version: 思智捷信息科技有限公司
 * @Author : szjcomo 
 * |-----------------------------------------------------------------------------------
 */

require './vendor/autoload.php';


use szjcomo\phputils\IdentityNum;
use szjcomo\phputils\Tools;




//图像处理
//$fileName = '123.jpg';
//图像画转,更多用法请参考ThinkPHP5的图像处理类库
//Tools::image($fileName)->flip(\think\image::FLIP_Y)->save('./456.jpg');


//swoole版本get/post请求
/*go(function(){
	$result = Tools::curl_get('http://www.sizhijie.com',[],false,true);
	print_r($result);

	$result = Tools::curl_post('http://www.sizhijie.com',[],false,true);
	print_r($result);
});*/


//普通的get请求
/*$result = Tools::curl_get('http://www.sizhijie.com');
print_r($result);*/

//普通post请求
/*$result = Tools::curl_post('https://www.baidu.com',['word'=>'szjcomo']);
print_r($result);
*/

//递归节点
/*$array = [
	['id' => 1, 'pid' => 0, 'name' => '江苏省'], 
	['id' => 2, 'pid' => 1, 'name' => '盐城市'], 
	['id' => 5, 'pid' => 4, 'name' => '虎丘区'], 
	['id' => 3, 'pid' => 2, 'name' => '东台'], 
	['id' => 6, 'pid' => 3, 'name' => '后港'], 
	['id' => 4, 'pid' => 1, 'name' => '苏州'], 
	['id' => 7, 'pid' => 0, 'name' => '上海']
];
$data = Tools::Recursion($array);

//递归获取所有上级节点
print_r(Tools::parentsRecurtion($array,6));

//递归反转成有顺序的一维数组
print_r(Tools::RecursionToArray($data));*/


//创建目录
//print_r(Tools::createDirectory('./file'));
//清空目录
//print_r(Tools::cleanDirectory('./file'));
//删除目录
//print_r(Tools::deleteDirectory('./file'));
//拷贝目录
//print_r(Tools::copyDirectory('./file','./files'));
//移动目录
//print_r(Tools::moveDirectory('./file','./files/file'));

//创建文件
//print_r(Tools::createFile('./files/file/index.php',"<?php \r\nreturn 'hello world';"));

//文件拷贝
//print_r(Tools::copyFile('./files/file/index.php','./files/file/index1.php'));

//目录递归遍历
/*$res = Tools::scanDirectory('./files');
print_r($res);*/

//获取随机字符串
//print_r(Tools::getRandStr(20));


//全局统一返回值
/*$result = Tools::appResult('SUCCESS',['name'=>'xxx'],false,0); //成功返回
$error  = Tools::appResult('ERROR');  //失败返回
print_r($result);print_r($error);*/



//身份证号码功能
/**
$idcard = 'xxx';

//严格检测是否身份证号码
var_dump(IdentityNum::isIdentityNum($idcard)); //false

//17位身份证号码自动补全
$idcard = IdentityNum::repairIdentity($idcard);
echo $idcard.PHP_EOL;

//获取年龄
$age = IdentityNum::getAge($idcard);
echo $age.PHP_EOL;

//获取性别
$sex = IdentityNum::getSex($idcard);
echo $sex.PHP_EOL;

//获取生日
$born = IdentityNum::getBorn($idcard);
echo $born.PHP_EOL;

//获取生肖
$zodiac = IdentityNum::getZodiac($idcard);
echo $zodiac.PHP_EOL;

//获取星座
$stasgin = IdentityNum::getStarsign($idcard);
echo $stasgin.PHP_EOL;
**/
