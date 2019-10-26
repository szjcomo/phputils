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

use EasySwoole\HttpClient\HttpClient as EasySwooleHttp;

/**
 * 使用easyswoole的http客户端
 */
class HttpClient
{
	/**
	 * [curl_get 实现curlget请求]
	 * @author 	   szjcomo
	 * @createTime 2019-10-25
	 * @param      string       $url    [请求地址]
	 * @param      array        $header [请求头]
	 * @param      bool|boolean $debug  [是否开启调式模式]
	 * @return     [type]               [description]
	 */
	public static function curl_get(string $url,array $header = [])
	{
        $client = new EasySwooleHttp($url);
        $response = $client->get($header);
        return $response->getBody();
	}

    /**
     * [curl_post 实现curl_post请求]
     * author: szjcomo
     * time  : 2019/10/25
     * @param string $url
     * @param $data
     * @param array $header
     * @param bool $debug
     */
	public static function curl_post(string $url,$data,array $header = [])
    {
        $client = new EasySwooleHttp($url);
        if(isset($header['timeout'])) $client = $client->setTimeout($header['timeout']);
        if(isset($header['conn_timeout'])) $client = $client->setConnectTimeout($header['conn_timeout']);
        $response = $client->post($data,$header);
        $result = $response->getBody();
        if(empty($result)) throw new \Exception($response->getErrMsg(),$response->getErrCode());
        return $result;
    }

    /**
     * [curl_post_json 发送json请求]
     * author: szjcomo
     * time  : 2019/10/25
     * @param string $url
     * @param array $data
     * @param array $header
     */
    public static function curl_post_json(string $url,array $data,array $header = [])
    {
        $client = new EasySwooleHttp($url);
        $response = $client->postJson(json_encode($data),$header);
        return $response->getBody();
    }

    /**
     * [curl_post_string 发送全字符串请求]
     * author: szjcomo
     * time  : 2019/10/25
     * @param string $url
     * @param string $data
     * @param array $header
     */
    public static function curl_post_xml(string $url,string $data,array $header = [])
    {
        $client = new EasySwooleHttp($url);
        $response = $client->postXml($data,$header);
        return $response->getBody();
    }
}