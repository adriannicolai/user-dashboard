<?php
    function convert_date($date)
    {
        $convert_date = strtotime($date);
        return date('F jS Y', $convert_date);
    }
    function date_difference($date)
    {
        if($date < 3600)
        {
            return abs(date('i', $date)).' minutes ago';
        }
        else if($date < 86400)
        {
            return date('G', $date).' hours ago';
        }
        else
        {
            return date('F jS Y');
        }

    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages</title>
    <link rel="stylesheet" href="<?= base_url('/user_guide/assets/css/main.css') ?>">
</head>
<body>
<?php $this->load->view('/admin/header'); ?>
<div class="container">
    <section class="profile">
        <h1><?= ucwords(strtolower($selected_user['first_name'].' '.$selected_user['last_name'])); ?></h1>
        <p class="profile_label">Registered at:</p>
        <p><?= convert_date($selected_user['created_at']); ?></p>
        <p class="profile_label">User ID:</p>
        <p>#<?= $selected_user['user_id']; ?></p>
        <p class="profile_label">Email address:</p>
        <p><?= strtolower($selected_user['email']);?></p>
        <p class="profile_label">Description:</p>
        <p><?= $selected_user['description']; ?></p>
    </section>
    <?=
        $this->session->flashdata('errors');
        unset($_SESSION['errors']);    
    ?>
    <form class="message" action="/add_message" method="post">
        <h1>Leave a message for <?= ucwords(strtolower($selected_user['first_name'])); ?></h1>
        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
        <input type="hidden" name="message_sender_id" value="<?= $this->session->userdata('id'); ?>">
        <textarea name="message" placeholder="write a message"></textarea>
        <input type="submit" value="Post">
    </form>
    <?php
    foreach($all_messages as $index)
    {
        ?>
            <h3><?= $index['first_name'].' '.$index['last_name']; ?> wrotes <span><?= date_difference($index['date_difference']); ?></span></h3>
            <p><?=  $index['message']; ?></p>
        <?php
        foreach($comments as $key)
        {
            if($key['message_id'] == $index['message_id'])
            {
                ?>
                    <h3 class="comment"><?= $key['full_name']; ?> wrotes <span><?= date_difference($key['date_difference']); ?></span></h3>
                    <p class="comment"><?=  $key['comment']; ?></p>
                <?php
            }
        ?>
    <?php
        }
        ?>
        <form action="/add_comment" method="post" class="comment">
            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
            <input type="hidden" name="user_id" value="<?= $this->session->userdata('id') ?>">
            <input type="hidden" name="message_id" value="<?= $index['message_id'] ?>">
            <textarea name="comment" placeholder="write a comment"></textarea>
            <input type="submit" value="Post">
        </form>
        <?php
            }  
        ?>
</div>
</body>
</html>