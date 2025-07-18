<?php

/**
 * 管理员登录
 * @author sunkangchina <68103403@qq.com>
 * @date 2025
 */

namespace modules\admin\controller;


class LoginController extends \core\AppController
{
    /**
     * 登录页面
     */
    public function actionIndex()
    {
        //加载css
        add_css('/misc/css/admin_login.css');
    }
    /**
     * 登录
     */
    public function actionAccount()
    {
        $input = $this->post_data;
        $username = $input['username'];
        $password = $input['password'];
        $vali = validate(
            [
                'username' => lang('帐号'),
                'password' => lang('密码')
            ],
            $input,
            ['required' => [['username']], 'email' => [['email']]]
        );
        if ($vali) {
            json($vali);
        }
        $find = db_get('user', 'id', ['id' => 1]);
        if (!$find) {
            db_insert('user', [
                'username' => $username,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'tag' => 'admin',
                'created_at' => time()
            ]);
        }
        $find = db_get_one('user', '*', ['username' => $username]);
        if (!$find) {
            json_error(['msg' => lang('帐号不存在')]);
        }
        if (password_verify($password, $find['password'])) {
            $time = time() + 86400 * 365 * 5;
            cookie('uid', $find['id'], $time);
            json_success(['msg' => lang('登录成功')]);
        } else {
            json_error(['msg' => lang('密码错误')]);
        }
    }
}
