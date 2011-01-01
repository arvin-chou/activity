<?php echo $this->load->view('header'); ?>
<?php echo form_open('login/process_login') . "\n"; ?>
    <?php echo form_fieldset('Login') . "\n"; ?>

        <?php echo $this->session->flashdata('message'); ?>

        <p><label for="username">Username: </label><?php echo form_input($username); ?></p>
        <p><label for="password">Password: </label><?php echo form_password($password); ?></p>
        <p><?php echo form_submit('login', 'Login'); ?></p>
    <?php echo form_fieldset_close(); ?>
<?php echo form_close(); ?>
<?php echo $this->load->view('footer'); ?>
