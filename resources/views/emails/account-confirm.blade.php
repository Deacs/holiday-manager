<html>
    <head>
        <meta charset="UTF-8">
        <title>Please Confirm Your Account</title>
    </head>

    <body>
        <h1>Please Confirm Your Account</h1>

        <p>Hi {{ $user->first_name }}, an account has been created for you.</p>

        <p>Once you have <a href="{{ URL("member/confirm/{$user->confirmation_token}") }}">confirmed your email address</a>, you can access all of the features of the application.</p>

        <p>Thank you!</p>
    </body>
</html>
