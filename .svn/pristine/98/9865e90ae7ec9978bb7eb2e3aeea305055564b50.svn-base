<!DOCTYPE html>
<html>
    <head>
        <title>微商城登录</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Bootstrap -->
        <link rel="stylesheet" href="/css/bootstrap.min.css">
        <script src="/css/jquery.min.js"></script>
        <script src="/css/bootstrap.min.js"></script>
        <style>
            body {
                padding-top: 40px;
                padding-bottom: 40px;
                background-color: #eee;
            }

            .form-signin {
                max-width: 330px;
                padding: 15px;
                margin: 0 auto;
            }
            .form-signin .form-signin-heading,
            .form-signin .checkbox {
                margin-bottom: 10px;
            }
            .form-signin .checkbox {
                font-weight: normal;
            }
            .form-signin .form-control {
                position: relative;
                font-size: 16px;
                height: auto;
                padding: 10px;
                -webkit-box-sizing: border-box;
                -moz-box-sizing: border-box;
                box-sizing: border-box;
            }
            .form-signin .form-control:focus {
                z-index: 2;
            }
            .form-signin input[type="text"] {
                margin-bottom: -1px;
                border-bottom-left-radius: 0;
                border-bottom-right-radius: 0;
            }
            .form-signin input[type="password"] {
                margin-bottom: 10px;
                border-top-left-radius: 0;
                border-top-right-radius: 0;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <form class="form-signin" role="form" action="/login" method="post">
                <!-- <h2 class="form-signin-heading">WeMall用户登录</h2> -->
                <img src="/css/logo.png" height="" width="300px" style="margin-bottom:20px;" />
                <ul>
                    <?php
                    foreach ($errors->all('<li>:message</li>') as $message)
                    {
                        echo $message;
                    }
                    ?>
                </ul>
                <input type="text" name="username" class="form-control" placeholder="用户名" required autofocus>
                <input type="password" name="passwd" class="form-control" placeholder="密码" required>

                <input type="text" name="captcha" class="form-control" placeholder="验证码" required>
                
                <?php 
                    echo HTML::image(Captcha::img(), '验证码图片'); 
                ?>

                <label class="checkbox">
                    <input name="remember" type="checkbox" value="1">记住我
                </label>
                <button class="btn btn-lg btn-primary btn-block" type="submit">登录</button>
                <a href="http://img1.dacaipu.cn/pc/dacaipu_print_ds.exe"><img src="/css/print.png" height="auto" width="auto" style="margin-bottom:20px;" />自动结单打印程序下载</a>
            </form>
        </div>
    </body>
</html>