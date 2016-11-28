<?php
$this->layout = false;

if (!Configure::read('debug')):
    throw new NotFoundException();
endif;

$cakeDescription = 'CakePHP: the rapid development PHP framework';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>
    </title>
    <?= $this->Html->meta('icon') ?>
    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('cake.css') ?>
</head>
<body class="home">
    <header>
        <div class="header-image">
            <?= $this->Html->image('cake-logo.png') ?>
            <h1>Get the Ovens Ready</h1>
        </div>
    </header>
    <div id="content">
        <div class="row">
            <?php Debugger::checkSecurityKeys(); ?>
            <div id="url-rewriting-warning" class="columns large-12 url-rewriting checks">
                <p class="problem"><?php echo __d('cake_dev', 'URL rewriting is not properly configured on your server.'); ?></p>
                <p>
                    1) <a target="_blank" href="http://book.cakephp.org/2.0/en/installation/url-rewriting.html">Help me configure it</a>
                </p>
                <p>
                    2) <a target="_blank" href="http://book.cakephp.org/2.0/en/development/configuration.html#cakephp-core-configuration">I don't / can't use URL rewriting</a>
                </p>
            </div>

            <div class="columns large-12 platform checks">
                <h4>Environment</h4>
                <?php if (version_compare(PHP_VERSION, '5.2.8', '>=')): ?>
                    <p class="success"><?php echo __d('cake_dev', 'Your version of PHP is 5.2.8 or higher.'); ?></p>
                <?php else: ?>
                    <p class="problem"><?php echo __d('cake_dev', 'Your version of PHP is too low. You need PHP 5.2.8 or higher to use CakePHP.'); ?></p>
                <?php endif; ?>

                <?php if (extension_loaded('mcrypt')): ?>
                    <p class="success"><?php echo __d('cake_dev', 'Your version of PHP has the mcrypt extension loaded.'); ?></p>
                <?php else: ?>
                    <p class="problem"><?php echo __d('cake_dev', 'Your version of PHP does NOT have the openssl or mcrypt extension loaded.'); ?></p>
                <?php endif; ?>

            </div>

            <div class="columns large-12 filesystem checks">
                <h4>Filesystem</h4>
                <?php if (is_writable(TMP)): ?>
                    <p class="success">Your tmp directory is writable.</p>
                <?php else: ?>
                    <p class="problem">Your tmp directory is NOT writable.</p>
                <?php endif; ?>

                <?php if (is_writable(LOGS)): ?>
                    <p class="success">Your logs directory is writable.</p>
                <?php else: ?>
                    <p class="problem">Your logs directory is NOT writable.</p>
                <?php endif; ?>

                <?php $settings = Cache::config('_cake_core_'); ?>
                <?php if (!empty($settings)): ?>
                    <p class="success">The <em><?= $settings['engine'] ?>Engine</em> is being used for core caching. To change the config edit config/app.php</p>
                <?php else: ?>
                    <p class="problem">Your cache is NOT working. Please check the settings in config/app.php</p>
                <?php endif; ?>
            </div>

            <div class="columns large-12 database checks">
                <h4>Database</h4>
                <?php if ($filePresent = file_exists(APP . 'Config' . DS . 'database.php')): ?>
                    <p class="success"><?php echo __d('cake_dev', 'Your database configuration file is present.'); ?></p>
                <?php else: ?>
                    <p class="problem">
                        <?php echo __d('cake_dev', 'Your database configuration file is NOT present.'); ?>
                        <?php echo __d('cake_dev', 'Rename %s to %s', 'APP/Config/database.php.default', 'APP/Config/database.php'); ?>
                    <p>
                <?php endif; ?>

                <?php if ($filePresent): ?>
                    <?php
                        App::uses('ConnectionManager', 'Model');
                        try {
                            $connected = ConnectionManager::getDataSource('default');
                        } catch (Exception $connectionError) {
                            $connected = false;
                            $errorMsg = $connectionError->getMessage();
                            if (method_exists($connectionError, 'getAttributes')):
                                $attributes = $connectionError->getAttributes();
                                if (isset($errorMsg['message'])):
                                    $errorMsg .= '<br />' . $attributes['message'];
                                endif;
                            endif;
                        }
                    ?>
                    <?php if ($connected): ?>
                        <p class="success"><?php echo __d('cake_dev', 'CakePHP is able to connect to the database.'); ?></p>
                    <?php else: ?>
                        <p class="problem"><?php echo __d('cake_dev', 'CakePHP is NOT able to connect to the database.'); ?><br /><br /><?= $errorMsg ?></p>
                    <?php endif; ?>
                <?php endif; ?>
            </div>

            <div class="columns large-12 debugkit checks">
                <h4>DebugKit</h4>
                <?php if (CakePlugin::loaded('DebugKit')): ?>
                    <p class="success"><?php echo __d('cake_dev', 'DebugKit plugin is present'); ?></p>
                <?php else: ?>
                    <p class="problem">
                        <?php echo __d('cake_dev', 'DebugKit is not installed. It will help you inspect and debug different aspects of your application.'); ?>
                        <?php echo __d('cake_dev', 'You can install it from %s', $this->Html->link('GitHub', 'https://github.com/cakephp/debug_kit/tree/2.2')); ?>
                    </p>
                <?php endif; ?>
            </div>
        </div>

        <div class="row">
            <div class="columns large-12">
                <h3>Getting Started</h3>
                <ul>
                    <li><a target="_blank" href="http://book.cakephp.org/2.0/en/">CakePHP 2.0 Docs</a></li>
                    <li><a target="_blank" href="http://book.cakephp.org/2.0/en/tutorials-and-examples/blog/blog.html">The 15 min Blog Tutorial</a></li>
                </ul>
                <p>
            </div>
        </div>
        <hr/>

        <div class="row">
            <div class="columns large-12">
                <h3 class="">More about Cake</h3>
                <p>
                    CakePHP is a rapid development framework for PHP which uses commonly known design patterns like Front Controller and MVC.
                </p>
                <p>
                    Our primary goal is to provide a structured framework that enables PHP users at all levels to rapidly develop robust web applications, without any loss to flexibility.
                </p>

                <h3>Help and Bug Reports</h3>
                <ul>
                    <li>
                        <a href="irc://irc.freenode.net/cakephp">irc.freenode.net #cakephp</a>
                        <ul><li>Live chat about CakePHP</li></ul>
                    </li>
                    <li>
                        <a href="https://github.com/cakephp/cakephp/issues">CakePHP Issues</a>
                        <ul><li>CakePHP issues and pull requests</li></ul>
                    </li>
                    <li>
                        <a href="http://discourse.cakephp.org/">CakePHP Forum</a>
                        <ul><li>CakePHP official discussion forum</li></ul>
                    </li>
                    <li>
                        <a href="https://groups.google.com/group/cake-php">CakePHP Google Group</a>
                        <ul><li>Community mailing list</li></ul>
                    </li>
                </ul>

                <h3>Docs and Downloads</h3>
                <ul>
                    <li>
                        <a href="http://api.cakephp.org/2.0/">CakePHP API</a>
                        <ul><li>Quick Reference</li></ul>
                    </li>
                    <li>
                        <a href="http://book.cakephp.org/2.0/en/">CakePHP Documentation</a>
                        <ul><li>Your Rapid Development Cookbook</li></ul>
                    </li>
                    <li>
                        <a href="http://bakery.cakephp.org">The Bakery</a>
                        <ul><li>Everything CakePHP</li></ul>
                    </li>
                    <li>
                        <a href="http://plugins.cakephp.org">CakePHP plugins repo</a>
                        <ul><li>A comprehensive list of all CakePHP plugins created by the community</li></ul>
                    </li>
                    <li>
                        <a href="https://github.com/cakephp/">CakePHP Code</a>
                        <ul><li>For the Development of CakePHP Git repository, Downloads</li></ul>
                    </li>
                    <li>
                        <a href="https://github.com/FriendsOfCake/awesome-cakephp/tree/cake2">CakePHP Awesome List</a>
                        <ul><li>A curated list of amazingly awesome CakePHP plugins, resources and shiny things.</li></ul>
                    </li>
                    <li>
                        <a href="http://www.cakephp.org">CakePHP</a>
                        <ul><li>The Rapid Development Framework</li></ul>
                    </li>
                </ul>

                <h3>Training and Certification</h3>
                <ul>
                    <li>
                        <a href="http://cakefoundation.org/">Cake Software Foundation</a>
                        <ul><li>Promoting development related to CakePHP</li></ul>
                    </li>
                    <li>
                        <a href="http://training.cakephp.org/">CakePHP Training</a>
                        <ul><li>Learn to use the CakePHP framework</li></ul>
                    </li>
                    <li>
                        <a href="http://certification.cakephp.org/">CakePHP Certification</a>
                        <ul><li>Become a certified CakePHP developer</li></ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>
