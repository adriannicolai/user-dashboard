<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
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
        <h1>Welcome to Village88!</h1>
        <p>This is to showcase the Village88's training of a student for about 2 months. This program is built with codeigniter framework!</p>
    </section>
    <div class="card">
        <h1>Manager Users</h1>
        <p>in this platform you can add, remove, uipdate abd edit users for the application but only if the user logged in is an admin</p>
    </div>
    <div class="card">
        <h1>Leave Messages</h1>
        <p>users will be able to leave a message to another user using this applciation</p>
    </div>
    <div class="card">
        <h1>Edit User Information</h1>
        <p>Admins will be able to edit another user's information(emnail address, first_name, last_name, etc.)</p>
    </div>
</div>
</body>
</html>