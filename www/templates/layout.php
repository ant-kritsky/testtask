<!DOCTYPE html>
<html lang="<?php echo $this->get('lang') ?>">
<head>
    <title></title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/css/bootstrap.css">
    <link rel="stylesheet" href="/css/jquery-ui.css"/>

    <script type="text/javascript" src="/js/jquery.min.js"></script>
    <script type="text/javascript" src="/js/jquery-ui.js"></script>
    <script type="text/javascript" src="/js/bootstrap.js"></script>
    <script type="text/javascript" src="/js/jquery.validate.min.js"></script>
    <script type="text/javascript" src="/js/main.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            jQuery.extend(jQuery.validator.messages, {
                required: "<?php echo _("This field is required.")?>",
                remote: "<?php echo _("Please fix this field.")?>",
                email: "<?php echo _("Please enter a valid email address.")?>",
                equalTo: "<?php echo _("Please enter the same value again.")?>",
                maxlength: jQuery.validator.format("<?php echo _("Please enter no more than {0} characters.")?>"),
                minlength: jQuery.validator.format("<?php echo _("Please enter at least {0} characters.")?>")
            });
        })
    </script>
</head>
<body>
<div id="content" class="container">

    <div class="row text-right">
        <?php foreach ($locales as $lang => $loc): ?>
            <?php if ($lang == Core::$lang): ?>
                <?php echo $lang ?>
            <?php else: ?>
                <a href="/<?php echo $lang ?>"><?php echo $lang ?></a>
            <?php endif ?>
        <?php endforeach ?>
    </div>

    <?php echo $content ?>

</div>
</body>
</html>