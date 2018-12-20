<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/29 0029
 * Time: 上午 11:22
 */

namespace app\index\controller;
use app\index\controller\Common;
use think\Session;
use think\View;
use think\Validate;
use think\Db;
use app\index\model\Management as manage;
class Management extends Common
{

        function index()
        {

            $this->examine();

            $list=Db::name("message")->where(["builder"=>Session::get("username")])->select();

            $this->assign("list",$list);

            return view();
        }

        function examine(){
            if(!Session::has("username")){

                $this->error("你还没有登录！请先登录！",__ROOT__.'\index\login');

            }
        }



        function edit(){

            $this->examine();

            Session::set("mid",input('get.')["id"]);

            $list=Db::name("options")->where(["mid"=>Session::get("mid")])->select();

            $arr=Db::name("message")->where(["Id"=>Session::get('mid')])->select();

            $str=$arr[0]["apply"];

            $applynum=$arr[0]["applynum"];

            $applyarr=explode(",",$str);

            array_pop($applyarr);

            $sum=0;

            foreach ($list as $val){
               $sum+=$val["participantnum"];
            }

            $style=array("info","success","warning","danger");

            $arr=Db::name("message")->where(["Id"=>Session::get('mid')])->select();

            $st=$arr[0]["stime"];
            $et=$arr[0]["etime"];
            $murl=$arr[0]["murl"];
            $enroll=$arr[0]["enroll"];
            Session::set("thumbnail",$arr[0]["images"]);
            $this->assign([
                "optionslist"=>$list,
                "sum"=>$sum,
                "t"=>0,
                "i"=>0,
                "style"=>$style,
                "applyarr"=>$applyarr,
                "applynum"=>$applynum,
                "stime"=>$st,
                "etime"=>$et,
                "murl"=>$murl,
                "enroll"=>$enroll,
                "img"=>Session::get("thumbnail")
            ]);

            return view();
        }

        function join(){

            $this->examine();

            $arr=input('post.')["apply"];

           $str=Db::name("message")->where(["Id"=>Session::get('mid')])->value("apply");

            foreach ($arr as $val){
                $str=str_replace($val.',',"",$str);
            }


            $num=(int)Db::name("message")->where(["Id"=>Session::get('mid')])->value("applynum");


            $num-=count($arr);
            Db::name("message")->where(["Id"=>Session::get('mid')])->update(["apply"=>$str,"applynum"=>$num]);

            $str=Db::name("message")->where(["Id"=>Session::get('mid')])->value('join');

            foreach ($arr as $val){
                $str.=$val.",";
            }


            $num=(int)Db::name("message")->where(["Id"=>Session::get('mid')])->value("joinnum");

            $num+=count($arr);

            if(Db::name("message")->where(["Id"=>Session::get('mid')])->update(["join"=>$str,"joinnum"=>$num])){
                $this->success("添加成功！");
            }else{
              $this->success("添加失败！请检查数据库后重试！");
            }

        }

        function editimage(){
          $file=request()->file('image');
          $info=$file->rule('uniqid')->move(__UPLOADDIR__);
          if($info){
           $s=$info->getFilename();
           Db::name("message")->where(["Id"=>Session::get('mid')])->update(["images"=>$s]);
            $this->success("图片修改成功！");
          }else{
             $this->error("图像上传失败！");
          }
        }

        function uptime(){

            $this->examine();

            $stime=input('post.')["fstime"];
            $etime=input('post.')["fetime"];

            if(!Validate::is($stime,"date")||!Validate::is($etime,"date")) {
                $this->error("时间格式错误，请重新输入！",__ROOT__.'/index/management/edit?id='.Session::get("mid"));

            }

            $arr=array(
                "stime"=>$stime,
                "etime"=>$etime
            );

           if(Db::name("message")->where(["Id"=>Session::get('mid')])->update($arr)){
               $this->success("修改成功！",__ROOT__.'/index/management/edit?id='.Session::get("mid"));
           }else{
                $this->error("修改失败！请检查数据库配置后重试！",__ROOT__.'/index/management/edit?id='.Session::get("mid"));
           }
        }
        function upadditional(){

            $this->examine();

            $murl=input('post.')["murl"];

            $enroll=input('post.')["enroll"];

            $arr=array(
                "murl"=>$murl,
                "enroll"=>$enroll
            );

           if(Db::name("message")->where(["Id"=>Session::get('mid')])->update($arr)){
               $this->success("修改成功！",__ROOT__.'/index/management/edit?id='.Session::get("mid"));
           }else{
               $this->success("修改失败！请检查数据库配置后重试！",__ROOT__.'/index/management/edit?id='.Session::get("mid"));
           }
        }

        function delete(){
           $this->examine();
            if(Db::name("options")->where(["mid"=>Session::get('mid')])->delete()&&Db::name("message")->where(["Id"=>Session::get("mid")])->delete()){
               if(Session::get('thumbnail')!='default.jpg')
                unlink(__UPLOADDIR__."/".Session::get('thumbnail'));
                $this->success("删除成功！",__ROOT__.'/index/management');
            }else{
                $this->error("删除失败！请检查数据库配置！");
            }
        }
        function showuser(){
            $id=input('get.')["id"];
            $v=Db::name("options")->where(["Id"=>$id])->value("participant");
            $this->assign("v",$v);
            return view();
        }

}