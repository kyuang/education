<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2020 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
// | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace app\index\controller;

use app\index\service\user\UserService;
use think\admin\Controller;
use think\App;

/**
 * Class Index
 * @package app\index\controller
 */
class Login extends Controller
{

    public function __construct(App $app)
    {
        parent::__construct($app);
        $this->assign('is_show',0);
    }


    public function login()
    {
        $this->fetch();
    }


    public function zhuce()
    {
        $this->fetch();
    }


    public function do_login()
    {
        $user_name = $this->request->post('user_name');
        $password = $this->request->post('password');
        if(empty($user_name) || empty($password)){
            return alert_info(1, '请输入用户名或密码');
        }
        $UserService = UserService::instance();
        return $UserService->loginByPassword($user_name,$password);
    }

    public function do_zhuce()
    {
        $user_name = $this->request->post('user_name');
        $password = $this->request->post('password');
        $re_password = $this->request->post('re_password');
        if(empty($user_name) || empty($password)){
            return alert_info(1, '请输入用户名和密码');
        }
        if(empty($new_password) || $new_password != $re_password){
            return alert_info(1, '重复密码不一致');
        }
        $UserService = UserService::instance();
        return $UserService->loginByPassword($user_name,$password);
    }


    public function logout()
    {
        $UserService = UserService::instance();
        return $UserService->logout();
    }


    public function up_password()
    {
        $password = $this->request->post('password');
        $new_password = $this->request->post('new_password');
        $re_password = $this->request->post('re_password');
        if(empty($password)){
            return alert_info(1, '请输入原密码');
        }
        if(empty($new_password) || $new_password != $re_password){
            return alert_info(1, '重复密码不一致');
        }
        $UserService = UserService::instance();
        return $UserService->updatePassword($password,$new_password);
    }



}