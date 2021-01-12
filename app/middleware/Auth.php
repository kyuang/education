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
     * @param \Closure $next
     * @return Response
     */
    public function handle($request, \Closure $next)
    {
        $UserService = UserService::instance();
        $login_res = $UserService->loginInfo();
        $redirect_url = $request->url(true);
        if ($login_res['code'] !== 0) {
            $login_url = url('index/passport/login', ['redirect_url' => base64_encode($redirect_url)], true, true)->build();
            return easy_tip('请先授权登录！', ['code' => 1, 'url' => $login_url, 'seconds' => 1]);
        }
        return $next($request);
    }
}
