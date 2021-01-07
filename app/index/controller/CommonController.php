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

use app\data\service\GoodsService;
use think\admin\Controller;
use think\App;

/**
 * Class Index
 * @package app\index\controller
 */
class CommonController extends Controller
{
    protected $crm_info = [];

    public function __construct(App $app)
    {
        parent::__construct($app);
        $this->crm_info = $this->getCrmInfo();
        $this->assign('is_show', 1);
        $this->assign('selected', 0);
    }

    /**
     * 获取登录信息
     * @return array
     */
    public function getCrmInfo()
    {
        $user_info = $this->app->session->get('crm');
        $user_info = ['id'=>1,'username'=>'aaa'];
        return (array)$user_info;
    }
}