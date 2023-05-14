<?php 
    $link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Reset Password</title>
    <link rel="stylesheet" href="{{ asset("css/forgotPassFom.css") }}">
</head>
<body>
    @csrf
    <div class="bg">
        <div class="content">
            <h1></h1>
            <p>{{ $data['token'] }}</p>
        </div>
        <div class="redirect">
            <a href="<?php $link."/password/reset";?>">Click here</a>
        </div>
        <a href="{{ url('/password/reset',$token) }}"></a>
        <!-- <a href="<?php $link."/password/reset".$token;?>"></a> -->
    </div>
</body>
</html>