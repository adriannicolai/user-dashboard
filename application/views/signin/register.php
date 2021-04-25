<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
        <form action="/users/add_user" method="post">
            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
            <label for="email">Email</label>
            <?= $this->session->flashdata('sdsd');?>
            <input type="text" name="email">
            <label for="first_name">First Name</label>
            <input type="text" name="first_name">
            <label for="last_name">Last Name</label>
            <input type="text" name="last_name">
            <label for="password1">Password</label>
            <input type="password" name="password1">
            <label for="password2">Confirm password</label>
            <input type="password" name="password2">
            <input type="submit" value="Register" class="submit">
            <a href="/signin">Already have an account?</a>
        </form>
    </section>
</div>
</body>
</html>