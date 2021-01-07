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
 * 在线留言
 */
namespace app\index\controller;

use app\index\service\user\UserService;
use think\admin\Controller;

/**
 * Class Index
 * @package app\index\controller
 */
class UserMsg extends Controller
{
    public $page_size = 10;

    /**
     * 留言
     */
    public function index()
    {
        $page = input('page',1);
        $this->title = '留言列表';

        $UserService = UserService::instance();
        $login_res = $UserService->loginInfo();
        $crm_info = $login_res['data'];
        $uid = $crm_info['id'];
        $map = ['uid' => $uid];
        $data_list = $this->app->db->name('DataUserMsg')->field(['*'])->where($map)->order('id desc')->page($page,$this->page_size)->select()->toArray();
        $this->assign('page',$page);
        $this->assign('page_size',$this->page_size);
        $this->assign('data_list',$data_list);
        $this->assign('selected', 4);
        $this->fetch('user_msg/index');
    }

    /**
     * 创建留言
     */
    public function create()
    {
        $this->title = '在线留言';
        $this->assign('selected', 4);
        $this->fetch('user_msg/create');
    }

    /**
     * 保存在线报名记录
     */
    public function store()
    {
        $content = input('content');

        if (empty($content)) {
            $this->error('请输入留言内容！');
        }
        $UserService = UserService::instance();
        $login_res = $UserService->loginInfo();
        $crm_info = $login_res['data'];
        $uid = $crm_info['id'];
        $data = [
            'uid' => $uid,
            'content' => $content,
            'create_at' => date('Y-m-d H:i:s')
        ];
        $add_res = $this->app->db->name('DataUserMsg')->insertGetId($data);
        if (!$add_res) {
            $this->error('添加失败，请稍后重试！');
        }
        $this->success('添加成功！');
    }

    /**
     * 留言详情
     * @return \think\response\View
     */
    public function detail(){
        $id = intval(input('id',0));
        if ($id <= 0){
            return easy_tip('参数错误！',['code'=>1,'url'=>url('user_msg/index'),'seconds'=>5]);
        }
        $this->title = '留言详情';
        $UserService = UserService::instance();
        $login_res = $UserService->loginInfo();
        $crm_info = $login_res['data'];
        $uid = $crm_info['id'];
        //获取内容
        $map = [
            'id'=>$id,
            'uid'=>$uid
        ];
        $detail_info = $this->app->db->name('DataUserMsg')->where($map)->find();
        if (empty($detail_info))
        {
            return easy_tip('留言内容不存在！',['code'=>1,'url'=>url('user_msg/index'),'seconds'=>5]);
        }
        $this->assign('selected', 4);
        $this->assign('detail_info',$detail_info);
        $this->fetch('user_msg/detail');
    }
}