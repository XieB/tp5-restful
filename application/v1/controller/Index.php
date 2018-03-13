<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/12 0012
 * Time: 下午 1:56
 */
namespace app\v1\controller;
use think\Db;
use think\Config;

class Index extends Base
{
    public function index()
    {
        $res = Db::name('plans')->order('id asc')->select();
        return json($res);
    }
    public function test(){
        return json('',401);
    }
    private function aa(){
        return json('',402);
    }
}
