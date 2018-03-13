<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/12 0012
 * Time: 下午 2:18
 */
namespace app\v1\controller;

use think\Controller;
use think\Request;
use think\Db;
class Base extends Controller
{
    public function _initialize()
    {
        parent::_initialize();
        //跨域？
        header('Access-Control-Allow-Origin:*');
        header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization');
        header('Access-Control-Allow-Methods:*');
        if (Request::instance()->isOptions()) exit();
    }

    protected function verify($jwt){
        $return = ['msg'=>''];
        list($header,$playload,$signature) = explode('.',$jwt);
        $headerSource = json_decode(base64_decode($header),true);
        $playloadSource = json_decode(base64_decode($playload),true);

        if ($playloadSource['exp'] < time()){
            http_response_code(401);
            $return['msg'] = 'token已过期';
        }
        $salt = Db::name('users')->where('id',$playloadSource['uid'])->value('salt');
        $newSignature = $headerSource['alg']($header . $playload . $salt);
        if ($newSignature != $signature) {
            http_response_code(401);
            $return['msg'] = '验证失败';
        }
        if ($return['msg']){
            echo json_encode($return,JSON_UNESCAPED_UNICODE);
            exit();
        }
    }
    protected function createVerify($salt,$playload = [],$header = []){
        $time = time();
        $defaultHeader = [
            "typ"=>"JWT",
            "alg"=>"md5"
        ];
        $defaultPlayload = [
            'iat'   =>  $time,
            'exp'   =>  $time + 7200,
        ];
        $header = array_merge($defaultHeader,$header);
        $playload = array_merge($defaultPlayload,$playload);

        $headerEncode = base64_encode(json_encode($header));
        $playloadEncode = base64_encode(json_encode($playload));
        $signature = $header['alg']($headerEncode . $playloadEncode . $salt);
        return $headerEncode . '.' . $playloadEncode . '.' . $signature;
    }
}