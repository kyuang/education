<?php
declare (strict_types = 1);

namespace app\middleware;

use app\index\service\user\UserService;

class Auth
{
    /**
     * 处理请求
     *
     * @param \think\Request $request
     * @param \Closure       $next
     * @return Response
     */
    public function handle($request, \Closure $next)
    {
        $UserService = UserService::instance();
        $login_res = $UserService->loginInfo();
        if ($login_res['code'] !== 0){
            return easy_tip('请先授权登录！',['code'=>1,'url'=>url('user_msg/index'),'seconds'=>3]);
        }
        return $next($request);
    }
}
