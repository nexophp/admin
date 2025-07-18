<?php

use core\Menu;

// 设置分组（可选，默认为'admin'）
Menu::setGroup('admin');

// 添加顶级菜单
Menu::add('system', '系统管理', '', 'bi-gear', 50);

// 添加子菜单（使用'system'作为parent_name，而不是$topId）
Menu::add('module', '模块', '/admin/module', '', 100, 'system');
Menu::add('setting', '设置', '/admin/setting', '', 50, 'system');
Menu::add('user', '用户管理', '/admin/user', '', 30, 'system');
Menu::add('role', '角色管理', '/admin/role', '', 20, 'system');
 