<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/12 0012
 * Time: 下午 4:01
 */

namespace app\v1\controller;

use think\Db;
use think\Request;

class Users extends Base
{
    public function index(){}

    public function save(){
        $request = Request::instance();
        $user = $request->param('user');
        $password = $request->param('password');
        $where['user'] = $user;
        $where['password'] = $password;
        $res = Db::name('users')->where($where)->find();
        if ($res){
            $jwt = $this->createVerify($res['salt'],['uid'=>$res['id']]);
            return json($jwt);
        }else{
            return json(['msg'=>'登陆失败'],401);
        }
    }
}