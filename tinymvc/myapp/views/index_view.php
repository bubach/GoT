<!DOCTYPE html>
<html>
<head>
    <title><?php echo $title; ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="/css/global.css" />
    <link type="text/css" rel="stylesheet" href="/css/color-button.css" />
    <!-- js Boots_from -->
    <script type="text/javascript" src="/js/jquery.min.js"></script>
    <script type="text/javascript" src="/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/js/custom.js"></script>
    <script type="text/javascript" src="/js/jwplayer/jwplayer.js"></script>
    <script type="text/javascript">jwplayer.key="2+YA8vPnu6IwqirpEgWTktTBjcuMtb/rLqkK0A==";</script>
    <!-- end Boots_from -->
</head>

<body data-spy="scroll" data-target=".subnav" data-offset="50" data-twttr-rendered="true">

<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <a class="brand" href="/">
                <img src="/img/logo.gif" alt="JooX.net - v2.0" />
            </a>
            <div class="nav-collapse">
                <ul class="nav pull-right">
                    <li><a href="/">Home</a></li>
                    <li><a href="/">Series</a></li>
                    <li><a href="/">Movies</a></li>
                    <li><a href="/">Search</a></li>
                    <li><a href="/">Forum</a></li>

                    <li class="divider-vertical"></li>

                    <li class="avatar_small"><a href="account.html"></a></li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" href="#" data-toggle="dropdown">
                            john doe
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="/">
                                    <i class="icon-user"></i>
                                    Account Setting  </a>
                            </li>
                            <li>
                                <a href="/">
                                    <i class="icon-lock"></i> Change Password</a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="/"><i class="icon-off"></i> Logout</a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- end navbar -->
<div class="main">
    <div class="container">
<?php echo $content; ?>                
    </div><!-- end container -->
</div><!-- end main -->

<div class="footer">
    <div class="container">
        <div class="row">
            <div class="span6 logo-vt">
                <a class="brand" href="#">
                    <img src="/img/logo.gif" alt="JooX.net - v2.0" />
                </a>
                <span class="coppy_right">
                    <p>Lorem ipsum dolor sit </p>
                    <p>@2014 All Rights Reserved.</p>
                </span>
            </div>
            <div class="span2">
                <ul class="nav nav-list">
                    <li class="nav-header">Contact</li>
                    <li><a href="#">Support</a></li>
                    <li><a href="#">About</a></li>
                    <li>84.903.197.895</li>
                </ul>
            </div>
            <div class="span2">
                <ul class="nav nav-list">
                    <li class="nav-header">Blog</li>
                    <li><a href="#">Regulation</a></li>
                    <li><a href="#">Blog</a></li>
                </ul>
            </div>
            <div class="span2">
                <ul class="nav nav-list">
                    <li class="nav-header">Follow Us</li>
                    <li><a href="#"><i class="twitter"></i>Twitter</a></li>
                    <li><a href="#"><i class="facebook"></i>Facebook</a></li>
                    <li><a href="#"><i class="dd"></i>Forum</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- end footer -->
</body>
</html>