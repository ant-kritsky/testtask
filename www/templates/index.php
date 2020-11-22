<h3>
    <?php echo _('Hello') ?> <?php echo $this->get('user')->name ?>!
</h3>
<div class="row">
    <?php if ($this->get('user')->file_ext): ?>
        <div class="span2">
            <img src="/uploads/<?php echo $this->get('user')->id ?>.<?php echo $this->get('user')->file_ext ?>"/>
        </div>
    <?php endif ?>
    <div class="span4">
        <table>
            <tr>
                <td><?php echo _('Name') ?>:</td>
                <td><?php echo $this->get('user')->name ?></td>
            </tr>
            <tr>
                <td><?php echo _('Email') ?>:</td>
                <td><?php echo $this->get('user')->email ?></td>
            </tr>
            <tr>
                <td><?php echo _('Registered') ?>:</td>
                <td><?php echo date('Y-m-d H:i:s', strtotime($this->get('user')->created_at)) ?></td>
            </tr>
        </table>
        <a href="/logout"><?php echo _('logout') ?></a>
    </div>
</div>