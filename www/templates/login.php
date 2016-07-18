<h3><?php echo _('You can') ?> <?php echo _('enter') ?> <?php echo _('or') ?> <a href="/registration"><?php echo _('registration') ?></a> </h3>

<form method="post" id="login" action="/login">
    <?php if($error = $this->get('error')): ?>
        <div class="alert-error"><?php echo $error ?></div>
    <?php endif?>
    <div class="form-group">
        <label class="control-label" for="email"><?php echo _('Email') ?>:</label>

        <div class="input-group">
            <input class="form-control" placeholder="<?php echo _('Insert your email') ?>" id="email" name="email" type="text"/>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label" for="password"><?php echo _('Password') ?>:</label>

        <div class="input-group">
            <input class="form-control" placeholder="<?php echo _('Insert your password') ?>" id="password" name="password" type="password"/>
        </div>
    </div>

    <button type="submit" class="btn btn-primary"><?php echo _('Enter') ?></button>
</form>
    