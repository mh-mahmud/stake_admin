    <nav class="navbar navbar-expand-sm navbar-default">
        <div id="main-menu" class="main-menu collapse navbar-collapse">
        	<?php $x_data = $this->session->userdata('admin_user_data'); ?>
			<ul class="nav navbar-nav">
				<li class="">
					<a href="<?php echo base_url('admin'); ?>"><i class="menu-icon fa fa-laptop"></i>Dashboard </a>
				</li>

				<?php if( verify_group_route(['manage_sports','multibet', 'match_details', 'matchbit_coin', 'live-tv-link']) === true ) { //dd($x_data->role_data, true);?>
				<li class="menu-title">Sports</li>
				<li class="menu-item-has-children">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-play"></i>Live in play</a>
					<ul class="sub-menu children dropdown-menu">

						<?php if( admin_access_menu($x_data->role_data, 'manage_sports') ) : ?>
							<li><a href="<?= base_url('manage_sports'); ?>">Sports Name</a></li>
						<?php endif; ?>

						<?php if( admin_access_menu($x_data->role_data, 'match_details') ) : ?>
							<li><a href="<?= base_url('match_details'); ?>">Running Match Details</a></li>
						<?php endif; ?> 
						<?php if( admin_access_menu($x_data->role_data, 'matchbit_coin') ) : ?>
							<li><a href="<?= base_url('matchbit_coin'); ?>">Running Matchbet</a></li>
						<?php endif; ?>
						
						<?php if( admin_access_menu($x_data->role_data, 'multibet') ) : ?>
							<li><a style="color:" href="<?= base_url('multibet'); ?>">Running Multibet</a></li>
						<?php endif; ?>

					</ul>
				</li>
				<?php } ?>

				<?php if( verify_group_route(['customer_deposit', 'customer_withdraw', 'club_withdraw', 'customer_balance_transfer', 'customer_complain', 'customer_deposit_history', 'customer_withdraw_history', 'club_withdraw_history', 'complain_history']) === true ) { ?>
				<li class="menu-title">Customer Option</li>
				<li class="menu-item-has-children">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"   aria-expanded="ture"> <i class="menu-icon fa fa-user"></i>Customer</a>
					<ul class="sub-menu children dropdown-menu">

						<?php if( admin_access_menu($x_data->role_data, 'customer_deposit') ) : ?>
							<li><a href="<?php echo base_url('customer_deposit'); ?>">Deposit</a></li>
						<?php endif; ?>

						<?php if( admin_access_menu($x_data->role_data, 'customer_withdraw') ) : ?>
							<li><a href="<?php echo base_url('customer_withdraw'); ?>">Withdraw</a></li>
						<?php endif; ?>

						<?php if( admin_access_menu($x_data->role_data, 'club_withdraw') ) : ?>
							<li><a href="<?php echo base_url('club_withdraw'); ?>">Club Withdraw</a></li>
						<?php endif; ?>

						<?php if( admin_access_menu($x_data->role_data, 'customer_balance_transfer') ) : ?>
							<li><a href="<?php echo base_url('customer_balance_transfer'); ?>">Balance Transfer</a></li>
						<?php endif; ?>

						<?php if( admin_access_menu($x_data->role_data, 'customer_complain') ) : ?>
							<li><a href="<?php echo base_url('customer_complain'); ?>">Complain</a></li>
						<?php endif; ?>

					</ul>
				</li>

				<li class="menu-item-has-children">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"   aria-expanded="false"> <i class="menu-icon fa fa-users"></i>Customer History</a>
					<ul class="sub-menu children dropdown-menu">

						<?php if( admin_access_menu($x_data->role_data, 'customer_deposit_history') ) : ?>
							<li><a href="<?= base_url('customer_deposit_history')?>">Deposit History</a></li>
						<?php endif; ?>

						<?php if( admin_access_menu($x_data->role_data, 'customer_withdraw_history') ) : ?>
							<li><a href="<?= base_url('customer_withdraw_history')?>">Withdraw History</a></li>
						<?php endif; ?>

						<?php if( admin_access_menu($x_data->role_data, 'club_withdraw_history') ) : ?>
							<li><a href="<?= base_url('club_withdraw_history')?>">Club Withdraw History</a></li>
						<?php endif; ?>

						<?php if( admin_access_menu($x_data->role_data, 'complain_history') ) : ?>
							<li><a href="<?= base_url('complain_history')?>">Complain History</a></li>
						<?php endif; ?>
					</ul>
				</li>
				<?php } ?>


				<?php if( verify_group_route(['settings', 'deposit_account', 'withdraw_account', 'notice-panel']) === true ) { ?>
				<li class="menu-title">Administrator</li>
				<li class="menu-item-has-children">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-male"></i>Admin Activities</a>
					<ul class="sub-menu children dropdown-menu">

						<?php if( admin_access_menu($x_data->role_data, 'settings') ) : ?>
							<li><a href="<?php echo base_url('settings'); ?>">Settings</a></li>
						<?php endif; ?>

						<?php if( admin_access_menu($x_data->role_data, 'deposit_account') ) : ?>
							<li><a href="<?php echo base_url('deposit_account'); ?>">Deposit Account</a></li>
						<?php endif; ?>

						<?php if( admin_access_menu($x_data->role_data, 'withdraw_account') ) : ?>
							<li><a href="<?php echo base_url('withdraw_account'); ?>">Withdraw Account</a></li>
						<?php endif; ?>

						<?php if( admin_access_menu($x_data->role_data, 'notice-panel') ) : ?>
							<li><a href="<?php echo base_url('notice-panel'); ?>">Notice Panel</a></li>
						<?php endif; ?>

					</ul>
				</li>
				<?php } ?>

				<?php if( verify_group_route(['club_user', 'admin_user', 'customer_user', 'manage_role', '2fa_auth']) === true ) { ?>
				<li class="menu-title">Admin User</li>
				<li class="menu-item-has-children">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-user-circle"></i>User</a>
					<ul class="sub-menu children dropdown-menu">

						<?php if( admin_access_menu($x_data->role_data, 'club_user') ) : ?>
							<li><a href="<?php echo base_url('club_user'); ?>">Club User </a></li>
						<?php endif; ?>

						<?php if( admin_access_menu($x_data->role_data, 'admin_user') ) : ?>
							<li><a href="<?php echo base_url('admin_user'); ?>">Admin User </a></li>
						<?php endif; ?>

						<?php if( admin_access_menu($x_data->role_data, 'customer_user') ) : ?>
							<li><a href="<?php echo base_url('customer_user'); ?>">Customer </a></li>
						<?php endif; ?>

						<?php if( admin_access_menu($x_data->role_data, 'manage_role') ) : ?>
							<li><a href="<?php echo base_url('manage_role'); ?>">Roles </a></li>
						<?php endif; ?> 
					</ul>
				</li>
				<?php } ?>


				<?php if( verify_group_route(['sports_icon', 'team_icon', 'slider_banner', 'match_option_save']) === true ) { ?>
				<li class="menu-title">Admin Settings</li>
				<li class="menu-item-has-children">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-gear"></i>Extra Settings</a>
					<ul class="sub-menu children dropdown-menu">

						<?php if( admin_access_menu($x_data->role_data, 'sports_icon') ) : ?>
							<li><a href="<?php echo base_url('sports_icon'); ?>">Sports icon </a></li>
						<?php endif; ?> 

						<?php if( admin_access_menu($x_data->role_data, 'slider_banner') ) : ?>
							<li><a href="<?php echo base_url('slider_banner'); ?>">Slider Banner </a></li>
						<?php endif; ?>

						<?php if( admin_access_menu($x_data->role_data, 'match_option_save') ) : ?>
							<li><a href="<?php echo base_url('match_option_save'); ?>">Match Option Save </a></li>
						<?php endif; ?> 

					</ul>
				</li>
				<?php } ?>
				
				<?php if( verify_group_route(['game_page']) === true ) { ?>
				<li class="menu-title">Game Page Settings</li>
				<li class="menu-item-has-children">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-gamepad"></i>Game Settings</a>
					<ul class="sub-menu children dropdown-menu">
						<li><a href="<?php echo base_url('game_page'); ?>">Game Page </a></li>
					</ul>
				</li>
				<?php } ?>

				<?php if( verify_group_route(['match_bit_coin_history', 'user_statement', 'club_statement', 'match_history', 'total_statement']) === true ) { ?>
				<li class="menu-title">Reports</li>
				<li class="menu-item-has-children">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-list"></i>Customer Reports</a>
					<ul class="sub-menu children dropdown-menu">

						<?php if( admin_access_menu($x_data->role_data, 'match_bit_coin_history') ) : ?>
							<li><a href="<?= base_url('match_bit_coin_history')?>">Match Bet Report</a></li>
						<?php endif; ?>

						<?php if( admin_access_menu($x_data->role_data, 'user_statement') ) : ?>
						 	<li><a href="<?php echo base_url('user_statement'); ?>">User Statement</a></li>
						 <?php endif; ?>

						 <?php if( admin_access_menu($x_data->role_data, 'club_statement') ) : ?>
						 	<li><a href="<?php echo base_url('club_statement'); ?>">Club Statement</a></li>
						 <?php endif; ?>

						 <?php if( admin_access_menu($x_data->role_data, 'total_statement') ) : ?>
						 	<li><a href="<?= base_url('total_statement'); ?>">Total Statement</a></li>
						 <?php endif; ?>

						 <?php if( admin_access_menu($x_data->role_data, 'match_history') ) : ?>
						 	<li><a href="<?= base_url('match_history'); ?>">Match Report</a></li>
						 <?php endif; ?>
					</ul>
				</li>
				<?php } ?>

			</ul>
		</div>
    </nav>
