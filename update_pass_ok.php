<?php
session_start();
/**
 * Created by PhpStorm.
 * User: Qingge
 * Date: 2017/4/11
 * Time: 16:26
 */
class chkuser{
    var $admin_user;
    var $admin_pass;
    var $admin_new_pass;
    var $admin_new_pass2;
    var $yzm;
    //实现属性的初始化
    function chkuser($x,$y,$m,$n,$z){
        $this->admin_user = $x;
        $this->admin_pass = $y;
        $this->admin_new_pass = $m;
        $this->admin_new_pass2 = $n;
        $this->yzm = $z;
    }
    //实现密码的更改
    function chkinput(){
        //验证验证码是否正确
        if(strval($this->yzm)!=$_SESSION['autonum1']){
            echo "<script>alert('验证码输入错误!');history.back();</script>";
            exit;
        }else{
            session_unregister("autonum1");
        }

        //验证密码
        include ("conn/conn.php");
        $query = mysql_query("select * from tb_admin where admin_user='".$this->admin_user."' and admin_pass='".$this->admin_pass."'");
        if(mysql_num_rows($query)<1){
            echo "<script>alert('您输入的密码不正确，请重新输入');history.back();</script>";
        }else{
            $query = mysql_query("update tb_admin set admin_pass='".$this->admin_new_pass."'");
            if($query == true){
                echo "<script>alert('密码更改成功');history.back();</script>";
            }
        }
    }
}

//类的实例化
$chk=new chkuser($_POST['admin_user'],md5($_POST['admin_pass']),md5($_POST['admin_new_pass']),$_POST['admin_new_pass2'],$_POST['yzm']);
$chk->chkinput();




