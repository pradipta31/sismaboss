<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SISMABOSS</title>
  <link rel="icon" href="{{asset('images/logo_boss.png')}}">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <link rel="stylesheet" href="css/app.css">
</head>
<body class="hold-transition skin-blue sidebar-mini">
    <div id="app">
        <router-view></router-view>
    </div>
<script src="js/app.js"></script>
</body>
</html>
