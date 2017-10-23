<?php echo form_open("account/login", array('class' => 'form-signin', 'novalidate' => '')) ?>
    <h2 class="form-signin-heading">Sign in</h2>
    <?php if ($error_message) : ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <h4><i class="fa fa-warning"></i> Warning!</h4>
            <?= $error_message ?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif ?>
    <label for="inputEmail" class="sr-only">Email address</label>
    <input type="email" id="inputEmail" class="form-control" name="identity" value="<?php echo set_value('identity'); ?>" placeholder="Email" autofocus>
    <label for="inputPassword" class="sr-only">Password</label>
    <input type="password" id="inputPassword" class="form-control" name="password" value="<?php echo set_value('password'); ?>" placeholder="Password">
    <div class="checkbox">
        <label>
            <input type="checkbox" id="remember" value="false"> Remember me
        </label>
    </div>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
</form>