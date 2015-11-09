<!DOCTYPE html>
<html>
    <head>
        <title>DCP用户中心</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <!-- Bootstrap -->
        <link rel="stylesheet" href="/css/bootstrap.min.css"/>
        ﻿	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="/css/jquery.min.js"/></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="/css/bootstrap.min.js"/></script>
        @section('header')
        @show
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
                <script src="http://cdn.bootcss.com/html5shiv/3.7.0/html5shiv.min.js"></script>
                <script src="http://cdn.bootcss.com/respond.js/1.3.0/respond.min.js"></script>
            <![endif]-->
        <style>
            body {
                /* min-height: 2000px; */
                padding-top: 50px;
            }
        </style>
    </head>
    <body>
        <div class="navbar navbar-default navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="javascript:void(0);">DCP微电商</a>
                </div>
                @section('sidebar')
                @show
                <div class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li class="dropdown {{ $act_order or  '' }}" id="dingdan">
                            <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
                                订单
                                <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="{{ $act_newlist or  '' }}">
                                    <a href="/new_orders">新订单</a>
                                </li>
                                <li class="{{ $act_historylist or  '' }}">
                                    <a href="/history_orders">历史订单</a>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown {{ $act_product or  '' }}" id="shangpin">
                            <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
                                商品
                                <b class="caret"></b>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="{{$act_product_category or ''}}">
                                    <a href="/category">类别维护</a>
                                </li>
                                <li class="{{$act_product_list or ''}}">
                                    <a href="/product">商品维护</a>
                                </li>
                            </ul>
                        </li>
                        
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="javascript:void(0)"><?php
                                echo Auth::user()->customer_name;
                            ?></a>
                        </li>
                        <li>
                            <a href="/logout">退出</a>
                        </li>
                    </ul>
                </div>
                <!--/.nav-collapse -->
            </div>
        </div>
        <div class="container">
            @yield('content')
            
        </div> <!-- /container -->


<div id='ajax_loader' style="position: fixed; left: 50%; top: 50%; display: none;">
    <img src="/css/ajax-loader.gif"/>
</div>
    </body>
</html>