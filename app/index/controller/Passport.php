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
/**
 * 账户相关
 */
namespace app\index\controller;

use app\index\service\user\RegisterService;
use app\index\service\user\UserService;


/**
 * Class Index
 * @package app\index\controller
 */
class Passport extends CommonController
{
    /**
     * 登录页面
     */
    public function login()
    {
        $this->assign('list', []);
        $this->fetch();
    }

    /**
     * 注册页面
     */
    public function register()
    {
        $this->assign('list', []);
        $this->fetch();
    }

    /**
     * 执行登录
     * @return array
     */
    public function doLogin()
    {
        $username = input('username');
        $password = input('password');

        $UserService = UserService::instance();
        return $UserService->loginByPassword($username, $password);
    }

    /**
     * 执行注册并登录
     */
    public function doReg()
    {
        $username = input('username');
        $nickname = input('nickname');
        $password = input('password');
        $password2 = input('password2');

        $RegisterService = RegisterService::instance();
        $reg_res = $RegisterService
            ->setUsername($username)
            ->setNickname($nickname)
            ->setPassword($password, $password2)
            ->store();
        if ($reg_res['code'] !== 0) {
            return $reg_res;
        }
        $UserService = UserService::instance();
        return $UserService->doLogin($reg_res['data']['id']);
    }
}