<nav class="navbar navbar-default navbar-static-top"  style="background-color: #0d77bd !important; margin-bottom: 0" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header" >
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <!-- Logo Start -->
            <?php
                echo $this->Html->image('gap_logo.png', array(
                    'url' => '#'
                ));
            ?>
            <!-- Logo End -->
        </div>
    <ul class="nav navbar-top-links navbar-right" id="nav_user">
       <?php  $user = AuthComponent::user()?>
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#" style="color: #ffffff !important;">
            <?php echo h($user['username']);?>  <i class="fa fa-user fa-fw"></i><i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu">
                <li>
                    <?php echo $this->Html->link(
                            $this->Html->tag('i', '', array('class' => 'fa fa-lock fa-fw')). "Change Password",
                            array('controller' => 'users', 'action' => 'changePassword', 'admin' => false),
                            array('escape' => false)
                            );
                    ?>
                </li>
                <li class="divider"></li>
                <li>
                    <?php echo $this->Html->link(
                            $this->Html->tag('i', '', array('class' => 'fa fa-sign-out fa-fw')). " Logout", 
                             array('controller' => 'users', 'action' => 'logout', 'admin' => false),
                            array( 'escape' => false)
                            );
                    ?>
                </li>
            </ul>
       </li>
    </ul>
</nav>
