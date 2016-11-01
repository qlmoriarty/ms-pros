<?php
set_time_limit(0);

/**
 * GIT DEPLOYMENT SCRIPT
 *
 * Used for automatically deploying websites via GitHub
 *
 */

// array of commands
$commands = array(
    'echo $PWD',
    'whoami',
    'whoami',
    '/usr/local/bin/git reset --hard HEAD',
    '/usr/local/bin/git stash',
    '/usr/local/bin/git pull',
    '/usr/local/bin/git status',
    '/usr/local/bin/git submodule sync',
    '/usr/local/bin/git submodule update',
    '/usr/local/bin/git submodule status',
    '/usr/local/bin/sudo /usr/local/bin/composer install',
    '/usr/local/bin/sudo /usr/local/bin/composer update',
    '/usr/local/bin/php artisan migrate --force',
    '/usr/local/bin/php artisan view:clear',
    //'/usr/local/bin/php artisan cache:clear',
    //'php artisan queue:restart',
    //'/usr/local/bin/sudo /usr/local/etc/rc.d/supervisord restart',
);
//dev.socialhammer.com
// exec commands
$output = '';
foreach($commands AS $command){
    $tmp = shell_exec($command);

    $output .= "<span style=\"color: #6BE234;\">\$</span><span style=\"color: #729FCF;\">{$command}\n</span><br />";
    $output .= htmlentities(trim($tmp)) . "\n<br /><br />";
}
?>

<!DOCTYPE HTML>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <title>GIT DEPLOYMENT SCRIPT</title>
</head>
<body style="background-color: #000000; color: #FFFFFF; font-weight: bold; padding: 0 10px;">
<div style="width:700px">
    <div style="float:left;width:350px;">
        <p style="color:white;">Git Deployment Script</p>
        <?php echo $output; ?>
    </div>
</div>
</body>
</html>