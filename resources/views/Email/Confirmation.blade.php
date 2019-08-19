<!DOCTYPE html>
<html>
<head>
    <title>Welcome test</title>
</head>
<body>
<h2>Hello {{$user['name']}},</h2>
<h3>Your registered email-id is {{$user['email']}} , Please click on the below link to verify your email account</h3><br/>

<a href="{{url('user/verify', $user->verifyUser->token)}}">Verify Email</a><br/>
 
Thank You,
</body>
</html>
