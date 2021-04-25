<?php
function convert_date($date)
{
    $converted_date = strtotime($date);
    return date('M jS Y', $converted_date);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="stylesheet" href="<?= base_url('/user_guide/assets/css/main.css') ?>">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function(){
            $('.table-delete').click(function(){
                if(confirm("Are you sure you want to proceed?") == true){
                    return true;
                }
                else{
                    return false;
                }
            })
        });
    </script>
</head>
<body>
<?php $this->load->view('/admin/header'); ?>
<div class="container">
    <h1>Manage Users</h1>
    <a class="table-navigation" href="/users/add_user_admin">Add New User</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Created_at</th>
                <th>User Level</th>
                <th class="table-action">Actions</th>
            </tr>
            <?php
                foreach ($all_users as $index) 
                {
            ?>
                <tr>
                    <td><?= $index['user_id']; ?></td>
                    <td><a href="/messages/<?= $index['user_id']; ?>"><?= ucwords(strtolower($index['first_name'].' '.$index['last_name'])); ?></a></td>
                    <td><?= $index['email']; ?></td>
                    <td><?= convert_date($index['created_at']); ?></td>
                    <td><?= $index['name'] ?></td>
                    <?php
                        if($this->session->userdata('id') == $index['user_id'])
                        {
                    ?>
                    <td><a class="table-edit" href="/users/edit/<?= $index['user_id'] ?>">Edit</a></td>
                    <?php
                        }
                        else
                        {
                    ?>
                    <td><a class="table-edit" href="/users/edit/<?= $index['user_id'] ?>">Edit</a> <a class="table-delete" href="/users/delete/<?= $index['user_id'] ?>">Remove</a></td>
                </tr>
                    <?php
                        }
                }
            ?>
        </thead>
    </table>
</div>
</body>
</html>