<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/18 0018
 * Time: 下午 5:12
 */

namespace app\index\controller;
use think\View;
use think\Db;
use think\Request;
use app\index\controller\Common;
use app\index\validate\Login as vld;
use think\Session;
class login extends Common
{

//登录信息验证
    function verification() {

       $logind=input('post.');

       $valid=new vld();

       $Db=new Db();
        if($valid->check($logind)){

            $u=$logind['username'];

            $p=$logind['p'];

            if(md5($p)==Db::name("login")->where(["username"=>$u])->value("password")){

                Session::set("username",$u);

                $this->success("登陆成功！",__ROOT__."\index");

            }else{

                $this->error("用户名或密码错误！");

            }


        }else{

            $this->error($valid->getError());

        }

    }
    //注册
    function adduser(){

        $logind=input('post.');

        $u=$logind['user'];

        $p=md5($logind['passwd']);

        $q=$logind['qq'];

            if(Db::name("login")->where(["username"=>$u])->select()){

                $this->error("用户名已存在！");

            }

            if(Db::name("login")->insert(["username"=>$u,"password"=>$p,"QQ"=>$q])){

                $this->success("注册成功！");

            }else{

                $this->error("注册失败，请检查数据库配置！");

            }

    }
    //注销
    function logout(){
            if(Session::has("username")) {
            Session::delete("username");
            $this->success("注销成功！", __ROOT__."\index");
            }else{
            $this->error("未登陆，无法注销！",__ROOT__."\index");
            }
    }
}