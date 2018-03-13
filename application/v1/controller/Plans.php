<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/13 0013
 * Time: 上午 10:44
 */

namespace app\v1\controller;

use think\Db;
use think\Request;

class Plans extends Auth
{
    public function index(){
        $res = Db::name('plans')->order('id asc')->select();
        return json($res);
    }
    public function create(){

    }
    public function save(){
        $param = Request::instance()->param();
        $res = Db::name('plans')->insertGetId($param);
        if ($res){
            return json(['msg'=>'添加成功','id'=>$res,'code'=>1]);
        }else{
            return json(['msg'=>'添加失败','code'=>0]);
        }
    }
    public function read($id){
        $res = Db::name('plans')->where('id',$id)->find();
        return json($res);
    }
    public function edit(){

    }
    public function update(){
        $param = Request::instance()->param();
        $res = Db::name('plans')->update($param);
        if ($res !== false){
            return json(['msg'=>'修改成功','code'=>1]);
        }else{
            return json(['msg'=>'修改失败','code'=>0]);
        }
    }
    public function delete(){
        $id = Request::instance()->param('id');
        $res = Db::name('plans')->where('id',$id)->delete();
        if ($res){
            return json(['msg'=>'删除成功','code'=>1]);
        }else{
            return json(['msg'=>'删除失败','code'=>0]);
        }
    }
}