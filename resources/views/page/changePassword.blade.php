<?php
    $link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>login</title>
    <link rel="stylesheet" href="{{ asset("css/login.css") }}">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>

<body>
    @csrf
    <div class="bg-img">
        <div class="content">
            <header>Login Form</header>
            <form action="<?php echo $link."/forgo-form"; ?>" method="post">
                <div class="field">
                    <span class="fa fa-user fa-2x"></span>
                    <input type="text" placeholder="Email Or Phone" required name="email">
                </div>
                <div class="field">
                    <span class="fa fa-lock fa-1x"></span>
                    <input type="password" class="password" required placeholder="Password" name="pass">
                    <span class="show">SHOW</span>
                </div>
                <div class="pass">
                    <a href="#">Forgot Password</a>
                </div>
                <div class="field space">
                    <input type="submit" value="Reset Password">
                </div>
                <div class="link">
                    <a href="/login">Signin Now</a>
                    <a href="/register">Signup Now</a>
                </div>
            </form>
        </div>
    </div>
    <!-- <script src="{{ asset('js/change.js') }}"></script> -->
</body>

</html>