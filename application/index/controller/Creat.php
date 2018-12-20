<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/29 0029
 * Time: 上午 11:21
 */

namespace app\index\controller;
use app\index\controller\Common;
use think\Request;
use think\Session;
use think\Validate;
use think\View;
use think\Db;
class Creat extends Common
{

    function index(){

        if(!Session::has("username")){
            $this->error("你还没有登录！请先登录！",__ROOT__.'\index\login');
        }
        return view();
    }
    function creatvote(){
        $data=input('get.');
        $m=array();
        foreach ($data as $key => $val){
            $m[$key]=$val;
            if($key=='enroll')
                break;
        }

        $m["builder"]=Session::get("username");

        $mid=Db::name("message")->insertGetId($m);

        if(!$mid){
            $this->error("新建投票信息失败！请检查数据库配置！",'index');
        }
        $flag=0;
        foreach ($data as $key => $val){
            if($flag){
                if(!Db::name("options")->insert(["mid"=>$mid,"name"=>$val])){
                    $this->error("新建投票选项失败！请检查数据库配置！",'index');
                    break;
                }

            }
            if($key=='enroll') $flag=1;
        }
        $this->success("新建投票成功！赶快喊小伙伴参与吧！",__ROOT__.'\index');
    }
    function murlcheck(){
        $url=Request::instance()->get("url");
        $p=get_headers($url,1);
        if(preg_match('/200/',$p[0])){
            return 1;
        }else{
            return 0;
        }
    }
}