<!DOCTYPE html>
<html>
  <head>
    <!-- 第一个参数是变量参数    继承的时候也可以根据这个变量来对不同的区域进行填充
    第二个参数是默认值  别的视图继承可以在默认参数位置直接继承 -->
    <title>@yield('title','weibo app')- Laravel 新手入门教程</title>
  </head>
  <body>
    <!-- 这个函数表明别的视图可以继承这个位置对这个位置进行重写  -->
    @yield('content')
  </body>
</html>
