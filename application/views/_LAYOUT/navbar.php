<aside class="main-sidebar">
    <section class="sidebar">
        <ul class="sidebar-menu">
            <li class="header">
                MANAGEMENT
            </li>
            <li><a href="<?= site_url('home/index') ?>"><i class="fa fa-database"></i> <span>DASHBOARD</span></a></li>
            <?php if ($this->session->userdata('issuperadmin')) { ?>
                <li>
                    <a href="<?= site_url('user/index') ?>">
                        <i class="fa fa-users"></i> <span>USER</span>
                    </a>
                </li>
                <li>
                    <a href="<?= site_url('channel/index') ?>">
                        <i class="fa fa-table"></i> <span>CHANNEL</span>
                    </a>
                </li>
                <li>
                    <a href="<?= site_url('content/index') ?>">
                        <i class="fa fa-camera"></i> <span>CONTENT</span>
                    </a>
                </li>
                <li>
                    <a href="<?= site_url('category/index') ?>">
                        <i class="fa fa-book"></i> <span>CATEGORY</span>
                    </a>
                </li>
                <li>
                    <a href="<?= site_url('type/index') ?>">
                        <i class="fa fa-book"></i> <span>TYPE</span>
                    </a>
                </li>
            <?php } ?>
        </ul>
    </section>
</aside>
