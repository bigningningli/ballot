<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/2 0002
 * Time: 下午 12:29
 */

namespace app\index\controller;
use think\Controller;
use think\Request;
use think\View;
use think\Session;
class Common extends Controller
{
    function _initialize()
    {

        //public文件夹目录
        define("__ROOT__",Request::instance()->root());
        //用户名赋值
        View::instance()->assign("username",Session::get("username"));
        //上传文件根目录，如需修改，请同时修改View下的uploaddir选项（第52行）
       define("__UPLOADDIR__",Request::instance()->server("DOCUMENT_ROOT").__ROOT__."/upload");
    }
    function index(){
        return view();
    }
}