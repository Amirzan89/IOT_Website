<?php
    $link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reset password</title>
    <link rel="stylesheet" href="{{ asset("css/forgotPassword.css") }}">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="bg-img">
        <div class="content">
            <header>Lupa Password</header>
            <form action="<?php echo $link."/password/reset"; ?>" method="post">
                @csrf
                <div class="field">
                    <span class="fa fa-user fa-2x"></span>
                    <input type="text" placeholder="Email" required name="email">
                </div>
                <div class="field space">
                    <input type="submit" value="Send Reset Password Link">
                </div>
                <div class="link">
                    <a href="/login">Signin Now</a>
                    <a href="/register">Signup Now</a>
                </div>
            </form>
        </div>
    </div>
    <!-- <script src="{{ asset('js/forgot.js') }}"></script> -->
</body>

</html>