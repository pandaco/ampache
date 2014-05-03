<?php
/* vim:set softtabstop=4 shiftwidth=4 expandtab: */
/**
 *
 * LICENSE: GNU General Public License, version 2 (GPLv2)
 * Copyright 2001 - 2013 Ampache.org
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License v2
 * as published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 *
 */

// Try to guess the web path
$web_path_guess = rtrim(dirname($_SERVER['PHP_SELF']), '\/');

require $prefix . '/templates/install_header.inc.php';
?>
        <div class="jumbotron">
            <h1><?php echo T_('Install progress'); ?></h1>
            <div class="progress">
                <div class="progress-bar progress-bar-warning"
                    role="progressbar"
                    aria-valuenow="60"
                    aria-valuemin="0"
                    aria-valuemax="100"
                    style="width: 66%">
                    66%
                </div>
            </div>
            <p><?php echo T_('Step 1 - Create the Ampache database'); ?></p>
                <p><strong><?php echo T_('Step 2 - Create ampache.cfg.php'); ?></strong></p>
                <dl>
                    <dd><?php printf(T_('This step takes the basic config values and generates the config file. If your config/ directory is writable, you can select "write" to have Ampache write the config file directly to the correct location. If you select "download" it will prompt you to download the config file, and you can then manually place the config file in %s'), $prefix . '/config'); ?></dd>
                </dl>
            <ul class="list-unstyled">
                <li><?php echo T_('Step 3 - Set up the initial account'); ?></li>
            </ul>
            </div>
            <?php Error::display('general'); ?>

            <h2><?php echo T_('Generate Config File'); ?></h2>
            <?php Error::display('config'); ?>
<form method="post" action="<?php echo $web_path . "/install.php?action=create_config"; ?>" enctype="multipart/form-data" >
<div class="form-group">
    <label for="web_path" class="col-sm-3 control-label"><?php echo T_('Web Path'); ?></label>
    <div class="col-sm-9">
        <input type="text" class="form-control" id="web_path" name="web_path" value="<?php echo scrub_out($web_path_guess); ?>">
    </div>
</div>
<div class="form-group">
    <label for="local_db" class="col-sm-3 control-label"><?php echo T_('Database Name'); ?></label>
    <div class="col-sm-9">
        <input type="text" class="form-control" id="local_db" name="local_db" value="<?php echo scrub_out($_REQUEST['local_db']); ?>">
    </div>
</div>
<div class="form-group">
    <label for="local_host" class="col-sm-3 control-label"><?php echo T_('MySQL Hostname'); ?></label>
    <div class="col-sm-9">
        <input type="text" class="form-control" id="local_host" name="local_host" value="<?php echo scrub_out($_REQUEST['local_host']); ?>">
    </div>
</div>
<div class="form-group">
    <label for="local_port" class="col-sm-3 control-label"><?php echo T_('MySQL port (optional)'); ?></label>
    <div class="col-sm-9">
        <input type="text" class="form-control" id="local_port" name="local_port" value="<?php echo scrub_out($_REQUEST['local_port']);?>"/>
    </div>
</div>
<div class="form-group">
    <label for="local_username" class="col-sm-3 control-label"><?php echo T_('MySQL Username'); ?></label>
    <div class="col-sm-9">
        <input type="text" class="form-control" id="local_username" name="local_username" value="<?php echo scrub_out($_REQUEST['local_username']);?>"/>
    </div>
</div>
<div class="form-group">
    <label for="local_pass" class="col-sm-3 control-label"><?php echo T_('MySQL Password'); ?></label>
    <div class="col-sm-9">
        <input type="password" class="form-control" id="local_pass" name="local_pass" placeholder="Password">
    </div>
</div>
        <input type="hidden" name="htmllang" value="<?php echo $htmllang; ?>" />
        <input type="hidden" name="charset" value="<?php echo $charset; ?>" />
<div class="col-sm-3">
</div>
<div class="col-sm-9">
    <button type="submit" class="btn btn-warning" name="download"><?php echo T_('Download'); ?></button>
    <button type="submit" class="btn btn-warning" name="write" <?php if (!check_config_writable()) { echo "disabled "; } ?>>
        <?php echo T_('Write'); ?>
    </button>
</div>
</form>

    <div class="col-sm-3"><?php echo T_('ampache.cfg.php exists?'); ?></div>
    <div class="col-sm-9"><?php echo debug_result(is_readable($configfile)); ?></div>
    <div class="col-sm-3"><?php echo T_('ampache.cfg.php configured?'); ?></div>
    <div class="col-sm-9"><?php $results = @parse_ini_file($configfile); echo debug_result(check_config_values($results)); ?></div>
    <div class="col-sm-3"></div>
    <?php $check_url = $web_path . "/install.php?action=show_create_config&amp;htmllang=$htmllang&amp;charset=$charset&amp;local_db=" . $_REQUEST['local_db'] . "&amp;local_host=" . $_REQUEST['local_host']; ?>
    <div class="col-sm-9">
        <a href="<?php echo $check_url; ?>">[<?php echo T_('Recheck Config'); ?>]</a>
    </div>
    <form
        method="post"
        action="<?php echo $web_path . "/install.php?action=show_create_account&amp;htmllang=$htmllang&amp;charset=$charset"; ?>"
        enctype="multipart/form-data"
    >
        <button type="submit" class="btn btn-warning"><?php echo T_('Continue to Step 3'); ?></button>
    </form>
<?php require $prefix . '/templates/install_footer.inc.php'; ?>
