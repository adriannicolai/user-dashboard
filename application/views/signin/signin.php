<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in</title>
    <link rel="stylesheet" href="<?= base_url('/user_guide/assets/css/main.css') ?>">
</head>
<body>
<header>
    <img src="<?= base_url('/user_guide/_images/v88_logo.png');?>" alt="Village88_logo.png" height="40">
    <a href="/users/index" class="navigation">Home</a>
    <a href="/signin" class="signout">Sign in</a>
</header>
<div class="container">
    <section>
    <?= $this->session->flashdata('errors');
            unset($_SESSION['errors']); 
        ?>
        <form action="/users/validate_signin" method="post">
            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
            <label for="email">Email</label>
            <input type="text" name="email">
            <label for="password">Password</label>
            <input type="password" name="password1">
            <input type="submit" value="Sign in" class="submit">
            <a href="register">Don't have an account?</a>
        </form>
    </section>
</div>
</body>
</html>