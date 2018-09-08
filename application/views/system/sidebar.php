
<style>
</style><aside class="main-sidebar ">
    <section class="sidebar">
        <ul class="sidebar-menu">
            <li>
                <a href="<?php echo base_url() ?>admin/dashboard" >
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>
			<?php $admin = $this->session->userdata('login_admin');
					$type = $admin['login_admin_type'];
					$types = $admin['login_admin_type_new']; ?>
			
			<?php foreach($_categories as $c => $category):
                    if( $c > 100) : 
                    foreach($_pages[$c] as $p => $page):
                    if($type ||(array_key_exists($c, $types) && ($types[$c] & $p))): ?>
            <li>
                <a href="<?php echo base_url() ?><?= $page['link'] ?>" >
                    <i class="fa <?= $category['class'] ?>"></i> <span><?= $page['name'] ?></span>
                </a>
            </li>
            <?php   endif;
                    endforeach; ?>
            <?php   else : 
                        if($type ||(array_key_exists($c, $types) && $types[$c] > 0)): ?>
			<li class="treeview" >
                <a href="#">
                    <i class="fa <?= $category['class'] ?>"></i>  <span><?= $category['name'] ?></span>
                    <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu">
				<?php   foreach($_pages[$c] as $p => $page):
						if($type ||(array_key_exists($c, $types) && ($types[$c] & $p))): 
                        if($category['name'] == "Laporan") : ?>
                <li><a href="<?php echo base_url() ?><?= $page['link'] ?>" onclick="window.open('<?= base_url().$page['link']?>', 'newwindow', 'width=' + screen.width + ',height=' + screen.height + ',scrollbars=yes'); return false;"><i class="fa fa-angle-double-right"></i><?= $page['name'] ?></a></li>
                <?php   else : ?>
				<li><a href="<?php echo base_url() ?><?= $page['link'] ?>"><i class="fa fa-angle-double-right"></i><?= $page['name'] ?></a></li>
				<?php   endif;
                        endif;
                        endforeach; ?>
                </ul>
            </li>
			<?php       endif;
                    endif;
				endforeach; ?>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
<script>
    $(document).ready(function () {
        var url = window.location;

        $('ul.treeview-menu a[href="' + this.location.pathname + '"]').parent().addClass('active');

        $('ul.sidebar-menu ul.treeview-menu a').filter(function() {
            return this.href == url;
        })
            .parent().parent().parent().addClass('active');

    });
</script>
