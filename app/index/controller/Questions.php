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
 * 答题训练
 */
namespace app\index\controller;

use app\index\service\user\UserService;
use think\admin\Controller;

/**
 * Class Index
 * @package app\index\controller
 */
class Questions extends Controller
{
    public $pass_grade = 80;

    /**
     * 试卷
     */
    public function index()
    {
        $this->title = '在线答题';
        //获取分类
        $map = ['pid' => 0, 'status' => 1, 'deleted' => 0];
        $data_list = $this->app->db->name('ShopGoodsCate')->field(['id', 'name'])->where($map)->order('id asc')->select()->toArray();
        $UserService = UserService::instance();
        $login_res = $UserService->loginInfo();
        $crm_info = $login_res['data'];
        $uid = $crm_info['id'];
        foreach ($data_list as $key => &$item) {
            //查询所有试卷数量
            $total_questions = $this->app->db->name('DataQuestionsGroup')->where(['cate_id' => $item['id'], 'status' => 1, 'deleted' => 0])->count();
            $item['total_questions'] = $total_questions;
            //查询已答试卷数量
            $total_answers = $this->app->db->name('DataUserAnswers')->where(['cate_id' => $item['id'], 'uid' => $uid])->count();
            $item['total_answers'] = $total_answers;
        }
        $this->assign('data_list', $data_list);
        $this->assign('selected', 4);
        $this->fetch('questions/index');
    }

    /**
     * 答题记录
     * @return \think\response\View
     */
    public function answers()
    {
        $this->title = '答题记录';
        $cate_id = intval(input('cate_id', 0));
        if ($cate_id <= 0) {
            return easy_tip('参数错误！', ['code' => 1, 'url' => url('questions/index'), 'seconds' => 5]);
        }
        //查询所有试卷数量
        $data_list = $this->app->db->name('DataQuestionsGroup')->where(['cate_id' => $cate_id, 'status' => 1, 'deleted' => 0])->order('id asc')->select()->toArray();
        $UserService = UserService::instance();
        $login_res = $UserService->loginInfo();
        $crm_info = $login_res['data'];
        $uid = $crm_info['id'];
        foreach ($data_list as $key => &$item) {
            //获取答题内容
            $answers_info = $this->app->db->name('DataUserAnswers')->where(['cate_id' => $cate_id, 'group_id' => $item['id'], 'uid' => $uid])->find();
            $item['grade'] = intval($answers_info['grade']);
            $answers_status = 0;
            if (!empty($answers_info)) {
                $answers_status = 1;
            }
            $item['answers_status'] = $answers_status;
        }
        $this->assign('data_list', $data_list);
        $this->assign('selected', 4);
        $this->fetch('questions/answers');
    }

    /**
     * 答题
     */
    public function create()
    {
        $group_id = intval(input('group_id', 0));
        if ($group_id <= 0) {
            return easy_tip('参数错误！', ['code' => 1, 'url' => url('questions/index'), 'seconds' => 5]);
        }
        $group_info = $this->app->db->name('DataQuestionsGroup')->where(['id' => $group_id, 'status' => 1, 'deleted' => 0])->find();
        if (empty($group_info)) {
            return easy_tip('试卷不存在！', ['code' => 1, 'url' => url('questions/index'), 'seconds' => 5]);
        }
        $UserService = UserService::instance();
        $login_res = $UserService->loginInfo();
        $crm_info = $login_res['data'];
        $uid = $crm_info['id'];
        //校验是否满足答题条件！
        $pass_res = $this->getPrevGrade($group_id,$uid);
        if($pass_res['code'] !== 0)
        {
            return easy_tip("上一期习题够{$this->pass_grade}分，才可答题！", ['code' => 1, 'url' => url('questions/index'), 'seconds' => 5]);
        }
        //获取习题
        $data_list = $this->app->db->name('DataQuestions')->where(['group_id' => $group_id, 'status' => 1])->order('sort desc,id asc')->select()->toArray();
        $arr = ['A', 'B', 'C', 'D', 'E'];
        foreach ($data_list as $key => &$item) {
            $options = $item['options'];
            $options_list = [];
            if (!empty($options)) {
                $options = json_decode($options, true);
            }
            foreach ($options as $k => $v) {
                $options_list[$arr[$k]] = $v;
            }
            $item['options_list'] = $options_list;
        }
        $this->title = '在线答题-' . $group_info['title'];
        $this->assign('selected', 4);
        $this->assign('group_info', $group_info);
        $this->assign('data_list', $data_list);
        $this->fetch('questions/create');
    }

    /**
     * 获取上期分数
     * @param $group_id
     * @param $uid
     * @return int
     */
    private function getPrevGrade($group_id,$uid){
        //获取上一题分数，不够80分，不允许答题！
        $prev_info = $this->app->db->name('DataQuestionsGroup')->where('id', '<', $group_id)->where(['status' => 1, 'deleted' => 0])->find();
        if(empty($prev_info))
        {
            return alert_info(0,'通过！');
        }
        $prev_answers = $this->app->db->name('DataUserAnswers')->where(['group_id' => $prev_info['id'], 'uid' => $uid])->find();
        $prev_grade = intval($prev_answers['grade']);
        if ($prev_grade < $this->pass_grade){
            return alert_info(1,'分数不够！');
        }
        return alert_info(0,'分数够了！');
    }

    /**
     * 保存在线报名记录
     */
    public function store()
    {
        $group_id = intval(input('group_id', 0));
        $answers = input('answers');

        if ($group_id <= 0) {
            $this->error('参数错误！');
        }
        if (empty($answers)) {
            $this->error('请选择答案！');
        }
        $group_info = $this->app->db->name('DataQuestionsGroup')->where(['id' => $group_id, 'status' => 1, 'deleted' => 0])->find();
        if (empty($group_info)) {
            return easy_tip('试卷不存在！', ['code' => 1, 'url' => url('questions/index'), 'seconds' => 5]);
        }
        $cate_id = $group_info['cate_id'];
        $UserService = UserService::instance();
        $login_res = $UserService->loginInfo();
        $crm_info = $login_res['data'];
        $uid = $crm_info['id'];
        //校验是否满足答题条件！
        $pass_res = $this->getPrevGrade($group_id,$uid);
        if($pass_res['code'] !== 0)
        {
            $this->error("上一期习题够{$this->pass_grade}分，才可答题！");
        }
        //获取习题
        $data_list = $this->app->db->name('DataQuestions')->where(['group_id' => $group_id, 'status' => 1])->order('sort desc,id asc')->select()->toArray();
        $right_num = 0;
        foreach ($data_list as $key => $val) {
            if (isset($answers[$val['id']]) && $answers[$val['id']] == $val['answers']) {
                $right_num++;
            }
        }
        $fail_num = count($data_list) - $right_num;
        $grade = round($right_num / count($data_list), 2) * 100;
        //获取答题记录
        $answers_info = $this->app->db->name('DataUserAnswers')->where(['cate_id' => $cate_id, 'group_id' => $group_id, 'uid' => $uid])->find();
        if (empty($answers_info)) {
            //新增
            $data = [
                'uid' => $uid,
                'cate_id' => $cate_id,
                'group_id' => $group_id,
                'fail_num' => $fail_num,
                'right_num' => $right_num,
                'grade' => $grade,
                'content' => json_encode($answers),
                'create_at' => date('Y-m-d H:i:s')
            ];
            $add_res = $this->app->db->name('DataUserAnswers')->insertGetId($data);
            if (!$add_res) {
                $this->error('添加失败，请稍后重试！');
            }
            $this->success("添加成功，分数{$grade}！");
        } else {
            //更新
            $data = [
                'fail_num' => $fail_num,
                'right_num' => $right_num,
                'grade' => $grade,
                'content' => json_encode($answers),
                'update_at' => date('Y-m-d H:i:s')
            ];
            $up_res = $this->app->db->name('DataUserAnswers')->where(['id' => $answers_info['id']])->update($data);
            if (!$up_res) {
                $this->error('更新失败，请稍后重试！');
            }
            $this->success("更新成功，分数{$grade}！");
        }
    }
}