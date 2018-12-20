<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/26 0026
 * Time: 下午 3:57
 */

namespace app\index\controller;
use think\Db;
use app\index\controller\Common;
use think\Exception;
use think\Session;

class Square extends Common
{
    function index()
    {
        $list=Db::name("message")->order('joinnum desc')->select();
        $this->assign("list",$list);
        return view();
    }

    function show(){
        Session::set("mid",input('get.')["id"]);
        $mlist=Db::name("message")->where(["Id"=>Session::get("mid")])->select();
        $mlist=$mlist[0];
        $olist=Db::name("options")->where(["mid"=>Session::get("mid")])->select();
        $style=array("info","success","warning","danger");
        $r=0;
        if($this->strres($mlist["join"],Session::get("username"))){
            $r=1;
        }else{
            $r=0;
        }
        $a=0;
        if($this->strres($mlist["apply"],Session::get("username"))){
            $a=1;
        }else{
            $a=0;
        }
        foreach ($olist as $val){
           if($this->strres($val["participant"],Session::get("username"))){
               $f=1;
               break;
           }else{
               $f=0;
           }
        }
        $sum=0;
        foreach ($olist as $val){
            $sum+=$val["participantnum"];
        }

        $this->assign([
            "mlist"=>$mlist,
            "optionslist"=>$olist,
            "style"=>$style,
            "sum"=>$sum,
            "t"=>1,
            "r"=>$r,//判断是否在join中
            "f"=>$f,//判断是否参加了投票
            "a"=>$a//判断用户是否需要并且参与了报名
        ]);

        return view();

    }
    function strres($a,$b){
        $x=$a;

        do {
            $i=strpos($a,$b);
            if($i===false){
                return false;
            }
            if ($i > 0 && $x[$i - 1] == ',') {
                return true;
            } else {
                if ($i == 0)
                return true;
            }
            $a=substr($a, $i + strlen($b));
                $i+=strlen($b);
        }while($i<strlen($x));
    }

    function join()
    {
        try {
            $a = Db::name("message")->where(["Id" => Session::get("mid")])->value("apply") . Session::get("username") . ",";
            Db::name("message")->where(["Id" => Session::get("mid")])->setField("apply", $a);
            Db::name("message")->where(["Id" => Session::get("mid")])->setInc('applynum');
            $this->success("报名成功！");
        }catch (Exception $e){
            $this->error($e->getMessage());
        }
   }

    function poll(){
        $id=input('get.')["id"];
        $t=Db::name("options")->where(["Id"=>$id])->value("participant");
        if($this->strres($t,Session::get("username"))){
            $this->error("不能反复投票！");
        }
        $a=$t.Session::get("username").",";
        Db::startTrans();
       try{
        Db::name("options")->where(["Id"=>$id])->setInc("participantnum");
        Db::name("options")->where(["Id"=>$id])->setField("participant",$a);
        Db::commit();
        $this->success("投票成功！");
       }catch (Exception $e){
           $this->error($e->getMessage());
           Db::rollback();
       }
    }

}