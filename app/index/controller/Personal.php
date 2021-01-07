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
 * 个人中心
 */
namespace app\index\controller;

/**
 * Class Index
 * @package app\index\controller
 */
class Personal extends CommonController
{
    protected $middleware = ['app\middleware\Auth'];

    /**
     * 个人中心
     */
    public function index()
    {
        $this->title = '个人中心';

        $crm_info = $this->crm_info;
        $uid = $crm_info['id'];
        $map = ['id' => $uid];
        $user_info = $this->app->db->name('DataUser')->where($map)->find();
        $user_info['headimg'] = $this->headimg($user_info['headimg']);
        $this->assign('user_info',$user_info);
        $this->assign('selected', 4);
        $this->fetch('personal/index');
    }

    /**
     * 获取头像
     * @param string $img_path
     * @return string
     */
    private function headimg($img_path = ''){
        $default = url('customer/img/person.png',[],false,true);
        if (!empty($img_path)){
            $default = url($img_path,[],false,true);
        }
        return $default;
    }
}