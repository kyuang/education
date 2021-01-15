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


/**
 * Class Index
 * @package app\index\controller
 */
class Article extends CommonController
{

    protected $table = 'DataNewsItem';

    public function index()
    {
        $this->title = '文章列表';
        $keyword = trim(input('keyword'));

        $page = $this->request->get('page', 1);
        $map = ['deleted' => 0, 'status' => 1];
        $query = $this->app->db->name('DataNewsItem')->field(['*']);
        if (!empty($keyword)) {
            $query = $query->where('name', 'like', "%{$keyword}%");
        }
        $data_list = $query
            ->where($map)->order('sort desc,id desc')
            ->page($page, $this->page_size)
            ->select()->toArray();

        $this->assign('page', $page);
        $this->assign('page_size', $this->page_size);
        $this->assign('data_list', $data_list);
        $this->fetch();
    }
}