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

use think\admin\Controller;

/**
 * Class Index
 * @package app\index\controller
 */
class Index extends Controller
{
    public function index()
    {
        $this->assign('list',[]);
        $this->fetch();
    }



    public function kecheng()
    {
        $this->title = '课程';
        $this->assign('list',[]);
        $this->fetch('list');
    }

    public function online()
    {
        $this->title = '本校概况';
        $this->assign('list',[]);
        $this->fetch('online');
    }


    public function school()
    {
        $this->title = '本校概况';
        $this->assign('list',[]);
        $this->fetch('school');
    }

    public function search()
    {
        $this->title = '搜索';
        $this->assign('list',[]);
        $this->fetch('search');
    }


    public function dati()
    {
        $this->title = '答题';
        $this->assign('list',[]);
        $this->fetch('dati');
    }


    public function details()
    {
        $this->title = '明细';
        $this->assign('list',[]);
        $this->fetch('details');
    }


    public function card()
    {
        $this->title = '名片';
        $this->assign('list',[]);
        $this->fetch('card');
    }
}