<header>
	<nav>
		<ul>
			<li>
				<a href="<?php echo base_url(); ?>" class="logo-link">
					Storefront Calendar
					<span class="logo-caret icon"></span>
				</a>
				<ul>
					<li><?= anchor('account/form_new_user', 'Add New User') ?></li>
					<li><?= anchor('account/form_edit_user', 'Edit User') ?></li>
					<li><?= anchor('account/form_new_client', 'Add New Client') ?></li>
					<li><?= anchor('account/form_edit_client', 'Edit Client') ?></li>
					<li><?= anchor('main/form_add_booking', 'New Event') ?></li>
					<li><?= anchor('main/form_event_booking', 'Edit Event') ?></li>
				</ul>
			</li>
		</ul>
	</nav>

	<?= anchor('account/logout', 'Logout', 'class="logo-link" id=logout') ?>
</header>
