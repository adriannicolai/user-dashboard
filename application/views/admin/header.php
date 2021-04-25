<header>
    <img src="<?= base_url('/user_guide/_images/v88_logo.png');?>" alt="Village88_logo.png" height="40">
    <a href="/users/show_homepage" class="navigation">Dashboard</a>
    <a href="/users/edit_my_profile/<?= $this->session->userdata('id'); ?>" class="navigation">Profile</a>
    <a href="/logoff" class="signout">Log off</a>
</header>