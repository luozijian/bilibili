### 期末作业概述

+ 产品名称：Bilibili
+ 项目代码：https://github.com/luozijian/bilibili
+ 项目地址：http://bilibili.luozijian.top/

### 运行环境

- Nginx 1.8+
- PHP 5.6+
- Mysql 5.6+

### 开发环境部署/安装

本项目代码使用 PHP 框架 [Laravel 5.4](http://laravel-china.org/docs/5.4/) 开发，本地开发环境使用 [Laravel Homestead](http://laravel-china.org/docs/5.4/homestead)。

下文将在假定读者已经安装好了 Homestead 的情况下进行说明。如果您还未安装 Homestead，可以参照 [Homestead 安装与设置](http://laravel-china.org/docs/5.4/homestead#installation-and-setup) 进行安装配置。

#### 基础安装

1. 克隆仓库

   ```
   git clone https://github.com/luozijian/bilibili.git
   ```


2. 配置本地 Homestead 环境

   + 修改配置文件

     ```
     vi Homestead.yaml
     ```

   + 加入以下内容

     ```
      - map: bilibili.dev
           to: /home/vagrant/Code/bilibili/public
     ```

   + 修改 host 文件

     ````
     sudo vi /etc/host
     //加入以下内容
     192.168.10.10   bilibili.dev
     ````

   + `vargant up --provision` 重启 homestead 即可生效

3. 安装依赖包扩展

   ```
   composer install
   ```

4. 生成配置文件

   ```
   cp .env.example .env
   ```

5. 新增相应数据库（注意与.env设置名字一致），`db.sql` 文件在项目根目录 `public` 里面，也可以通过 `php artisan migrate --seed` 来迁移数据库

### 作业要求说明

1. 因为 **作业提交** 关系，因此不需要在 **Github** 克隆项目仓库，我已经把项目文件提交到指定地方，因此在 **部署开发环境** 的时候，只需要 **确保运行环境与上文一致** ，并且 **配置好**  `Homestead.yaml` 文件和 `/etc/host` 文件，然后访问到 `07/public/index.php` 即可

2. 基础题第一题，d小题

   由于本项目采用 **MVC** 模式，因此登录的表单内容并未提交到 `login.php` ，而是提交到 `app\Http\Controllers\Auth\LoginController.php` 中的 `AuthenticatesUsers` `trait` 中作处理，验证和登录的逻辑详情都在里面

3. 基础题第二题，b小题

   考虑到项目可读性以及个人习惯问题，数据库表 `myuser` 在本项目是 `users` 表，字段 `psw` 改为了 `password` ，个人感觉这样可读性会更好，看起来更加舒服

4. 基础题第五题，注册功能

   注册的时候需要填写邮箱并且验证邮箱，用的是第三方邮件服务商 `SendCloud` ，因为本项目还有忘记密码功能，是要通过邮箱来找回密码，所以必须验证邮箱才能注册，但是登录的时候，可以使用 **邮箱** 或者 **用户名** 都可以

5. 附加题第四题，websocket

   本项目使用 `workerman` 作为 websocket 的服务端，如果在本地部署开发的话，请使用 `php artisan socket:server start` 命令来启动 websocket 服务器