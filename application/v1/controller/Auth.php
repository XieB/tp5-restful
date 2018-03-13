<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/3/12 0012
 * Time: 下午 5:29
 */
namespace app\v1\controller;

use think\Db;
use think\Request;

class Auth extends Base
{
    public function _initialize()
    {
        parent::_initialize();
        $jwt = Request::instance()->server('HTTP_AUTHORIZATION');
        if ($jwt) {
            $this->verify($jwt);
        }else{
            http_response_code(401);
            exit();
        }

    }
//
//    public function index(){
//        echo 'index';
//    }
//    public function create(){
//
//    }
//    public function save(){
//
//    }
//    public function read($id){
//        echo $id;
//    }
//    public function edit(){
//
//    }
//    public function update(){
//
//    }
//    public function delete(){
//
//    }

}