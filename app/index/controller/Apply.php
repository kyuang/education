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
 * 在线报名
 */
namespace app\index\controller;

use think\admin\Controller;

/**
 * Class Index
 * @package app\index\controller
 */
class Apply extends Controller
{
    /**
     * 在线报名
     */
    public function index()
    {
        $this->title = '在线报名';
        $this->assign('selected', 3);
        $this->fetch('apply/index');
    }

    /**
     * 保存在线报名记录
     */
    public function store()
    {
        $mobile = input('mobile');
        $username = input('username');
        $message = input('message');

        if (empty($mobile)) {
            $this->error('请输入手机号！');
        }
        if (!isMobile($mobile)) {
            $this->error('手机号格式错误！');
        }
        if (empty($username)) {
            $this->error('请输入用户名！');
        }
        if (empty($message)) {
            $this->error('请输入留言内容！');
        }
        $data = [
            'mobile' => $mobile,
            'username' => $username,
            'message' => $message,
            'create_at' => date('Y-m-d H:i:s')
        ];
        $add_res = $this->app->db->name('DataUserApply')->insertGetId($data);
        if (!$add_res) {
            $this->error('添加失败，请稍后重试！');
        }
        return $this->success('添加成功！');
    }
}