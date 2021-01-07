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

/**
 * Class Index
 * @package app\index\controller
 */
class Index extends CommonController
{



    public function index()
    {
        $cates = GoodsService::instance()->getCateList();
        $this->assign('cates', $cates);


        $this->slider = sysdata('slider');

        $this->about = sysdata('about');
        $this->app_name = sysconf('app_name');
        //广告
        $query = $this->_query('DataNewsItem');
        $query->like('mark',['mark'=>'首页']);
        $query->where(['deleted' => 0])->order('sort desc,id desc')->limit(3);
        $this->article = $query->query->select()->toArray();

        $this->notice = sysconf('notice');
        //商品
        $query = $this->_query('ShopGoods');
        $query->like('mark',['mark'=>'热门']);
        $query->where(['deleted' => 0])->order('sort desc,id desc')->limit(4);
        $this->product = $query->query->select()->toArray();
        $this->fetch();
    }


    public function kecheng()
    {
        $this->title = '课程';

        $page = $this->request->get('page',1);
        $map = ['deleted' => 0];
        $data_list = $this->app->db->name('ShopGoods')->field(['*'])
            ->where($map)->order('sort desc,id desc')
            ->page($page,$this->page_size)
            ->select()->toArray();

        foreach ($data_list as &$item){

            $cat_id = $item['cate'];
            $cates = $this->app->db->name('ShopGoodsCate')->where(['id' => $cat_id])->find();
            $item['cat_name'] = $cates['name'];
        }

        $this->assign('page',$page);
        $this->assign('page_size',$this->page_size);
        $this->assign('product_list',$data_list);
        $this->fetch('list');
    }

    public function intro()
    {
        $this->title = '本校概况';
        $this->intro = sysdata('intro');
        $this->fetch('intro');
    }

    public function article()
    {
        $this->title = '详情';

        $id = input('id');
        $detail = $this->app->db->name('DataNewsItem')->where(['id'=>$id])
            ->where(['id' => $id])->find();
        $this->assign('detail', $detail);
        $this->fetch('article');
    }



    public function dati()
    {
        $this->title = '答题';
        $this->assign('list', []);
        $this->fetch('dati');
    }





    public function card()
    {
        $this->title = '名片';
        $this->assign('list', []);
        $this->fetch('card');
    }
}