<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit user</title>
    <link rel="stylesheet" href="<?= base_url('/user_guide/assets/css/main.css') ?>">
</head>
<body>
<?php $this->load->view('/admin/header'); ?>
<div class="container">
    <div>
        <h1>Edit user # <?= $selected_user['user_id']; ?></h1>
        <a class="table-navigation" href="/users/show_homepage">Return to Dashboard</a>  
    </div>   
    <?= $this->session->flashdata('errors');
            unset($_SESSION['errors']); 
    ?>
    <form action="/users/update_user" method="post" class="edit_form">
        <h1>Edit Information</h1>
        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
        <label for="email">Email address</label>
        <input type="text" name="email" value="<?= $selected_user['email']; ?>">
        <label for="first_name">First Name</label>
        <input type="text" name="first_name" value="<?= $selected_user['first_name']; ?>">
        <label for="last_name">Last Name</label>
        <input type="text" name="last_name" value="<?= $selected_user['last_name']; ?>">
        <label for="user_level">User Level</label>
        <select name="user_level">
        <?php
            foreach($user_level as $index)
            {
                if($selected_user['user_level_id'] == $index['id'])
                {
                ?>
                    <option value="<?= $index['id']; ?>" selected><?= $index['name'] ?> </option>
                <?php
                }
                else
                {
                ?>
                    <option value="<?= $index['id'] ?>"><?= $index['name'] ?></option>
                <?php
                }
            }
        ?>
        </select>
        <input class="submit" type="submit" value="Save">
    </form>
    <form action="/users/update_user_password" method="post" class="edit_form">
        <h1>Change password</h1>
        <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash(); ?>">
        <label for="password1">Password:</label>
        <input type="password" name="password1">
        <label for="password2">Confirm password</label>
        <input type="password" name="password2">
        <input class="submit" type="submit" value="Update Password">
    </form>
</div>
</body>
</html>