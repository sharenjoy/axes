<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
<body>
    <h1>Reset your password</h1>
    <p>Hello, {{ $username }}</p>

    <p>This is the link that you can <a href="{{url($accessUrl.'/resetpassword/'.$code)}}">reset your password</a></p>

    <p>Admin</p>
</body>
</html>