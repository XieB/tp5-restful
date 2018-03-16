<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/15 0015
 * Time: 下午 2:37
 */
namespace app\v1\controller;

use think\Db;
use think\Request;
class Demand extends Auth
{
    public function index(){
        $res = Db::name('demand')->order('id asc')->select();
        return json($res);
    }
    public function create(){

    }
    public function save(){
        $param = Request::instance()->param();
        $res = Db::name('demand')->insertGetId($param);
        if ($res){
            return json(['msg'=>'添加成功','id'=>$res,'code'=>1]);
        }else{
            return json(['msg'=>'添加失败','code'=>0]);
        }
    }
    public function read($id){
        $res = Db::name('demand')->field('desc,id,title,status,endtime')->where('id',$id)->find();
        return json($res);
    }
    public function edit(){

    }
    public function update($id){
        //已完成状态无法修改
        $status = Db::name('demand')->where('id',$id)->column('status');
        if ($status == 1){
            return json(['msg'=>'已完成状态无法修改','code'=>1]);
        }
        $param = Request::instance()->param();
        if ($status != 1 && $param['status'] == 1){ //从未完成到完成添加结束时间
            $param['endtime'] = date('Y-m-d H:i:s');
        }

        $res = Db::name('demand')->update($param);
        if ($res !== false){
            return json(['msg'=>'修改成功','code'=>1]);
        }else{
            return json(['msg'=>'修改失败','code'=>0]);
        }
    }
    public function delete(){
        $id = Request::instance()->param('id');
        $res = Db::name('demand')->where('id',$id)->delete();
        if ($res){
            return json(['msg'=>'删除成功','code'=>1]);
        }else{
            return json(['msg'=>'删除失败','code'=>0]);
        }
    }
}