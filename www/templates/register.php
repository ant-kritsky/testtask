<h3><?php echo _('Registration') ?></h3>
<form method="post" id="register" action="" enctype="multipart/form-data">
    <?php $errors = $this->get('errors') ?>
    <div class="form-group">
        <label class="control-label" for="name"><?php echo _('Name') ?>:</label>

        <div class="input-group">
            <input class="form-control" placeholder="<?php echo _('Insert your name') ?>"
                   value="<?php echo $this->getPost('name') ?>" id="name" name="name" type="text"/>
            <?php if ($errors['name']): ?>
                <div class="alert-error"><?php echo $errors['name'] ?></div>
            <?php endif ?>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label" for="email"><?php echo _('Email') ?>:</label>

        <div class="input-group">
            <input class="form-control" placeholder="<?php echo _('Insert your email') ?>"
                   value="<?php echo $this->getPost('email') ?>" id="email" name="email" type="text"/>
            <?php if ($errors['email']): ?>
                <div class="alert-error"><?php echo $errors['email'] ?></div>
            <?php endif ?>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label" for="email"><?php echo _('Avatar') ?>:</label>

        <div class="input-group">
            <input class="form-control" placeholder="<?php echo _('Insert your avatar') ?>"
                   value="<?php echo $this->getPost('email') ?>" id="file" name="file" type="file"/>
            <?php if ($errors['file']): ?>
                <div class="alert-error"><?php echo $errors['file'] ?></div>
            <?php endif ?>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label" for="password"><?php echo _('Password') ?>:</label>

        <div class="input-group">
            <input class="form-control" placeholder="<?php echo _('Insert your password') ?>"
                   value="<?php echo $this->getPost('password') ?>" id="password" name="password" type="password"/>
            <?php if ($errors['password']): ?>
                <div class="alert-error"><?php echo $errors['password'] ?></div>
            <?php endif ?>
        </div>
    </div>

    <div class="form-group">
        <label class="control-label" for="password"><?php echo _('Password again') ?>:</label>

        <div class="input-group">
            <input class="form-control" placeholder="<?php echo _('Insert password again') ?>"
                   value="<?php echo $this->getPost('password_again') ?>" id="password_again" name="password_again"
                   type="password"/>
            <?php if ($errors['password_again']): ?>
                <div class="alert-error"><?php echo $errors['password_again'] ?></div>
            <?php endif ?>
        </div>
    </div>

    <button type="submit" class="btn btn-primary"><?php echo _('registration') ?></button>
</form>
    