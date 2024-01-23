<p>Dear <?= $mail_data['user']->name ?></p>
<p>
    We are received a request to reset password for RdjBlog account associated with <i><?= $mail_data['user']->email ?></i>.
    You can reset you password by clicking the button bellow:
    <br><br>
    <a href="<?= $mail_data['actionLink'] ?>" style="color: #fff; border-color: #22bc66; border-style: solid; border-width: 5px 10px; background-color: #22bc66; display: inline-block; text-decoration: none; border-radius: 3px; box-shadow: 0 2px 3px rgba(0,0,0,0.16); -webkit-text-size-adjust: none; box-sizing: border-box;" target="_blank">Reset Password</a>
    <br><br>
    <b>NB:</b> This link will still valid within 15 minutes.
    <br><br>
    If you did not request for password reset, please ignore this email.
</p>