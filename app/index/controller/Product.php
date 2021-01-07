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
class Product extends CommonController
{

    protected $table = 'ShopGoods';

    public function index()
    {
        $this->title = '课程列表';

        $page = $this->request->get('page', 1);
        $map = ['deleted' => 0];
        $data_list = $this->app->db->name('ShopGoods')->field(['*'])
            ->where($map)->order('sort desc,id desc')
            ->page($page, $this->page_size)
            ->select()->toArray();

        foreach ($data_list as &$item) {
            $cat_id = $item['cate'];
            $cates = $this->app->db->name('ShopGoodsCate')->where(['id' => $cat_id])->find();
            $item['cat_name'] = $cates['name'];
        }

        $this->assign('page', $page);
        $this->assign('page_size', $this->page_size);
        $this->assign('product_list', $data_list);
        $this->fetch();
    }


    public function search()
    {
        $this->title = '搜索';
        $this->assign('list', []);
        $this->fetch('search');
    }


    public function details()
    {
        $this->title = '明细';

        $id = input('id');
        $detail = $this->app->db->name($this->table)->where(['id'=>$id])
            ->where(['id' => $id])->find();


        $detail['slider'] = empty($detail['slider']) ? [] : explode('|',$detail['slider']);

        $cat_id = $detail['cate'];
        $cates = $this->app->db->name('ShopGoodsCate')->where(['id' => $cat_id])->find();
        $detail['cat_name'] = $cates['name'];

//        dump($detail);die;
        $this->assign('detail',$detail);
        $this->fetch('details');
    }

}