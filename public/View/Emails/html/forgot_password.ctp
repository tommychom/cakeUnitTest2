<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Emails.html
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
?>
<h1>PMI - GAP</h1>
<p><b><?php echo $full_name ?>,</b></p>
<p>Forgot your PMI-GAP password ?</p>
<p>PMI-GAP received a request to reset the password for your <b><?php echo $username;?></b> account. To reset your password, click on the link below:</p>
<p><?php echo $this->Html->link('Reset your PMI-GAP password',
        array(
            'controller' => 'users',
            'action' => 'verifyToResetPassword',
            $forgot_token,
            'full_base' => true,
            'admin' => false
        )
); ?></p>

