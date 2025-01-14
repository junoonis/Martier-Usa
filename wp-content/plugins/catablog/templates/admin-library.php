<?php $current_cat = (isset($_GET['category']))? '&amp;category='.$_GET['category'] : '' ?>
<?php $current_page = (isset($_GET['paged']))? '&amp;paged='.$_GET['paged'] : ''?>


<div class="wrap">

		<div id="icon-catablog" class="icon32"><br /></div>
		<h2>
			<span><?php _e("CataBlog Library", 'catablog'); ?></span>
			<a href="admin.php?page=catablog-upload" class="button add-new-h2"><?php _e("Add New", 'catablog'); ?></a>
			
		</h2>
		<div id="message" class="updated hide">
			<strong>&nbsp;</strong>
		</div>

		<noscript>
			<div class="error">
				<strong><?php _e("You must have a JavaScript enabled browser for bulk actions.", 'catablog'); ?>
				<a href="http://www.google.com/search?q=what+is+javascript"><?php _e("Learn More", 'catablog'); ?></a></strong>
			</div>
		</noscript>
		
		<?php $this->render_catablog_admin_message() ?>
		
		<div class="tablenav">
			
			<form id="catablog-bulk-action-form" method="post" action="admin.php?page=catablog-bulkedit" class="alignleft actions">
				<input type="hidden" name="page" value="catablog-bulkedit" />
				<input type="hidden" name="reference" value="admin.php?page=catablog<?php echo $current_cat ?><?php echo $current_page ?>" />
				<?php wp_nonce_field( 'catablog_bulkedit', '_catablog_bulkedit_nonce', false, true ) ?>
				
				<select id="bulk-action" name="bulk-action">
					<option value="">- <?php _e("Bulk Actions", 'catablog'); ?></option>
					<option value="edit-category"><?php _e("Edit Categories", 'catablog'); ?></option>
					<option value="delete"><?php _e("Delete", 'catablog'); ?></option>
				</select>
				
				<input type="submit" value="<?php _e("Apply", 'catablog'); ?>" class="button-secondary" />
				<small>|</small>
			</form>
			
			<form method="get" action="admin.php?page=catablog" class="alignleft actions">
				<label for="cat"><?php _e('View', 'catablog') ?>:</label>
				<input type="hidden" name="page" value="catablog" />
				<select id="cat" name="category" class="postform">
					<option value="-1">- <?php _e("All Categories", 'catablog'); ?></option>
					<?php $categories = $this->get_terms() ?>
					<?php foreach ($categories as $category): ?>
						<?php $selected = ($category->term_id == $selected_term->term_id)? 'selected="selected"' : '' ?>
						<option value="<?php echo $category->term_id ?>" <?php echo $selected ?> ><?php echo $category->name ?></option>
					<?php endforeach ?>
				</select>
				<input type="submit" value="Filter" id="catablog-submit-filter" class="button-secondary" />
				
				<?php /*
				<small>|</small>
				
				<?php $disabled = (!isset($_GET['category']) || $_GET['category'] > 0)? '' : 'disabled="disabled"' ?>
				<a href="#sort" id="enable_sort" <?php echo $disabled ?> class="button"><?php _e("Change Order", 'catablog'); ?></a>
				*/ ?>
			</form>
			
			
				<form class="tablenav-pages" action="" method="get">
					<span class="displaying-num"><?php printf(__('%s items', 'catablog'), $total_catalog_items) ?></span> <!-- elementos -->
					
					<?php if ($total_catalog_items > $limit): ?>
					
					<a class='first-page <?php echo ($paged < 2)? 'disabled' : '' ?>' title='<?php _e('Go to the first page', 'catablog') ?>' href='<?php echo $first_catalog_page_link ?>'>&laquo;</a>
					<a class='prev-page <?php echo ($paged < 2)? 'disabled' : '' ?>' title='<?php _e('Go to the previous page', 'catablog') ?>' href='<?php echo $prev_catalog_page_link ?>'>&lsaquo;</a>
				
					<span class="paging-input">
						<input type="hidden" name="page" value="catablog" />
						<input class='current-page' title='<?php _e('Current page') ?>' type='text' name='paged' value='<?php echo $paged ?>' size='1' />
						<?php _e('of', 'catablog') ?>
						<span class='total-pages'><?php echo $total_catalog_pages ?></span>
					</span>
					
					<a class='next-page <?php echo ($paged >= $total_catalog_pages)? 'disabled' : '' ?>' title='<?php _e('Go to the next page', 'catablog') ?>' href='<?php echo $next_catalog_page_link ?>'>&rsaquo;</a>
					<a class='last-page <?php echo ($paged >= $total_catalog_pages)? 'disabled' : '' ?>' title='<?php _e('Go to the last page', 'catablog') ?>' href='<?php echo $last_catalog_page_link ?>'>&raquo;</a>
					<?php endif ?>
				</form>

			
			<div id="catablog-view-switch" class="view-switch">
				<?php $list_class = ($view == 'list')? 'class="current"' : 'class=""' ?>
				<?php $grid_class = ($view == 'grid')? 'class="current"' : 'class=""' ?>
				<?php $meta       = 'width="20" height="20" border="0"'; ?>
				
				<a href="admin.php?page=catablog<?php echo $current_cat ?><?php echo $current_page ?>&amp;view=list">
					<img src="<?php echo $this->urls['images'] ?>/blank.gif" id="view-switch-list" <?php echo "$list_class $meta" ?> title="<?php _e("List View", 'catablog'); ?>" alt="<?php _e("List View", 'catablog'); ?>"/>
				</a>
				<a href="admin.php?page=catablog<?php echo $current_cat ?><?php echo $current_page ?>&amp;view=grid">
					<img src="<?php echo $this->urls['images'] ?>/blank.gif" id="view-switch-excerpt" <?php echo "$grid_class $meta" ?> title="<?php _e("Grid View", 'catablog'); ?>" alt="<?php _e("Grid View", 'catablog'); ?>"/>
				</a>
			</div>
		</div>
		
		<?php
		
		if ($view == 'grid') {
			include_once($this->directories['template'] . '/admin-grid.php');
		}
		else {
			include_once($this->directories['template'] . '/admin-list.php');
		}
				
		?>
		
		
		<?php if ($total_catalog_items > $limit): ?>
			<div class="tablenav">
				<form class="tablenav-pages" action="" method="get">
					<span class="displaying-num"><?php printf(__('%s items', 'catablog'), $total_catalog_items) ?></span> <!-- elementos -->
			
					<a class='first-page <?php echo ($paged < 2)? 'disabled' : '' ?>' title='<?php _e('Go to the first page', 'catablog') ?>' href='<?php echo $first_catalog_page_link ?>'>&laquo;</a>
					<a class='prev-page <?php echo ($paged < 2)? 'disabled' : '' ?>' title='<?php _e('Go to the previous page', 'catablog') ?>' href='<?php echo $prev_catalog_page_link ?>'>&lsaquo;</a>
			
					<span class="paging-input">
						<input type="hidden" name="page" value="catablog" />
						<input class='current-page' title='<?php _e('Current page') ?>' type='text' name='paged' value='<?php echo $paged ?>' size='1' />
						<?php _e('of', 'catablog') ?>
						<span class='total-pages'><?php echo $total_catalog_pages ?></span>
					</span>
				
					<a class='next-page <?php echo ($paged >= $total_catalog_pages)? 'disabled' : '' ?>' title='<?php _e('Go to the next page', 'catablog') ?>' href='<?php echo $next_catalog_page_link ?>'>&rsaquo;</a>
					<a class='last-page <?php echo ($paged >= $total_catalog_pages)? 'disabled' : '' ?>' title='<?php _e('Go to the last page', 'catablog') ?>' href='<?php echo $last_catalog_page_link ?>'>&raquo;</a>
				</form>
			</div>
		<?php endif ?>

		
		<div id='catablog_load_curtain'>&nbsp;</div>

		<div id="edit-category-window" class="catablog-modal">
			<form id="catablog-edit-category" class="catablog-form" method="post" action="admin.php?page=catablog-bulkedit">
				<h3 class="catablog-modal-title">
					<span style="float:right;"><a href="#" class="hide-modal-window"><?php _e("[close]", 'catablog'); ?></a></span>
					<strong><?php _e("Edit Multiple Catalog Item's Categories", 'catablog'); ?></strong>
				</h3>
				
				<div class="catablog-modal-body">
					<div id="catablog-category-add-checklist">
						<strong class="list-title">[+] <?php _e("Add to categories", "catablog") ?></strong>
						<ul class="list:category categorychecklist form-no-clear">
						
							<?php $categories = $this->get_terms() ?>
							<?php if (count($categories) < 1): ?>
								<li><span><?php _e("You have no categories.", 'catablog'); ?></span></li>
							<?php endif ?>
						
							<?php foreach ($categories as $category): ?>
							<li>
								<label class="catablog-category-row">
									<input id="in-category-<?php echo $category->term_id ?>" type="checkbox" name="categories-add[]"  value="<?php echo $category->term_id ?>" />
									<span><?php echo $category->name ?></span>
								</label>
							</li>
							<?php endforeach ?>
						</ul>
					</div>
					
					<div id="catablog-category-remove-checklist">
						<strong class="list-title">[-] <?php _e("Remove from categories", "catablog") ?></strong>
						<ul class="list:category categorychecklist form-no-clear">
						
							<?php $categories = $this->get_terms() ?>
							<?php if (count($categories) < 1): ?>
								<li><span><?php _e("You have no categories.", 'catablog'); ?></span></li>
							<?php endif ?>
						
							<?php foreach ($categories as $category): ?>
							<li>
								<label class="catablog-category-row">
									<input id="in-category-<?php echo $category->term_id ?>" type="checkbox" name="categories-remove[]"  value="<?php echo $category->term_id ?>" />
									<span><?php echo $category->name ?></span>
								</label>
							</li>
							<?php endforeach ?>
						</ul>
					</div>
					
					
					<?php wp_nonce_field( 'catablog_bulkedit', '_catablog_bulkedit_nonce', false, true ) ?>
					<input type="hidden" name="page" value="catablog-bulkedit" />
					<input type="hidden" name="bulk-action" value="edit-category" />
					<input type="hidden" name="reference" value="admin.php?page=catablog<?php echo $current_cat ?><?php echo $current_page ?>" />
					
					<input type="submit" name="save" value="<?php _e("Change Multiple Categories", 'catablog'); ?>" class="button-primary" />
					<p><small>
						<?php _e("Select the categories you would like each selected item to be part of by checking their boxes.", 'catablog'); ?><br />
						<?php _e("After the bulk edit, the selected items will be in only the categories selected above.", "catablog"); ?><br />
					</small></p>			
				</div>
				
			</form>
		</div>
		
</div>

<script type="text/javascript">
	jQuery(document).ready(function($) {
		
		var timer = null;
		
		
		/************************************************************************************
		** form bindings that should happen first
		*************************************************************************************/
		// show the bulk actions form and bind form submission;
		$('#catablog-bulk-action-form').show().bind('submit', function(event) {
			var self = this;
			
			if ($('#bulk-action').val().length < 1) {
				alert('<?php _e("Please select a bulk action to apply.", "catablog"); ?>');
				return false;
			}
			
			// get selected (checked) catalog items
			var checked_catalog_items = $('#catablog_items input.bulk_selection:checked');
			if (checked_catalog_items.size() < 1) {
				alert('<?php _e("Please select at least one catalog item first.", "catablog"); ?>');
				return false;
			}
			
			// change the category of multiple catalog items
			if ($('#bulk-action').val() == 'edit-category') {
				
				jQuery('#edit-category-window').show();
				jQuery('#catablog_load_curtain').fadeTo(200, 0.8);
				
				checked_catalog_items.each(function() {
					$('#catablog-edit-category').append("<input type='hidden' name='bulk_selection[]' value='"+this.value+"' />");
				});
				
				return false;
			}
			
			// delete multiple catalog items
			if ($('#bulk-action').val() == 'delete') {
				if (!confirm('<?php _e("Are you sure you want to delete multiple items?", "catablog"); ?>')) {
					return false;
				}
				
				checked_catalog_items.each(function() {
					$(self).append("<input type='hidden' name='bulk_selection[]' value='"+this.value+"' />");
				});
			}
			
			
		});
		
		// hide the filter button and bind live category switching
		$('#catablog-submit-filter').hide();
		$('#cat.postform').bind('change', function(event) {
			$(this).closest('form').submit();
		});
		
		
		// BIND HIDE MODAL WINDOW
		$('.hide-modal-window').bind('click', function(event) {
			jQuery('.catablog-modal:visible').hide();
			jQuery('#catablog_load_curtain').fadeOut(200);
			return false;
		});
		
		
		// BIND TRASH CATALOG ITEM WARNING
		$('.remove_link').bind('click', function(event) {
			return (confirm('<?php _e("Are you sure you want to permanently delete this catalog items?", "catablog"); ?>'));
		});
		
		
		// BIND THE SCREEN SETTINGS AJAX SAVE
		$('.hide-catablog-column-tog').bind('change', function(event) {
			var column_class = "." + this.id.replace("hide-", "");
			
			if (!this.checked) {
				$(column_class).hide();
			}
			else {
				$(column_class).show();
			}
			
			saveScreenSettings();
		});
		$('#entry_per_page').bind('change', function(event) {
			saveScreenSettings();
		});
		
		// SAVE SCREEN SETTINGS PANEL WITH AJAX
		function saveScreenSettings() {
			var hide = []
			var params = {
				'action':   'catablog_update_screen_settings',
				'security': '<?php echo wp_create_nonce("catablog-update-screen-settings") ?>',
			}
			
			// var form_values = {};
			$('#adv-settings input').each(function() {
				var name  = $(this).attr('name');
				var value = $(this).attr('value');
				
				if ($(this).attr('type') == 'checkbox') {
					if ($(this).attr('checked')) {
						hide.push(value);
					} 
				}
				else {
					params[name] = value;
				}
			});
			
			params.hide = hide;
			
			// make AJAX call
			$.post(ajaxurl, params, function(data) {
				try {
					var json = eval(data);
					if (json.success == false) {
						alert(json.error);
					}
					else {
						// do nothing on success
					}
				}
				catch(error) {
					alert(error);
				}
				
			});
			
			return false;
		}

		
		
		
		<?php /*
		
		// lazy load the images
		calculate_lazy_loads();
		$(window).bind('scroll resize', function(event) {
			calculate_lazy_loads();
		});
		
		
		// initialize the sortables
		var catablog_items_path = "#catablog_items";
		$(catablog_items_path).sortable({
			disabled: true,
			forcePlaceholderSize: true,
			opacity: 0.7, 
			<?php echo ($view == 'list')? "axis: 'y'" : "" ?>
		});
		
		
		$('#enable_sort').bind('click', function(event) {
			if ($(this).attr('disabled')) {
				alert('<?php _e("This feature only works when viewing a single category.", "catablog"); ?>');
				return false;
			}
			
			var items = $(catablog_items_path);
			if ($(this).hasClass('button-primary')) {
				
				// disable sortable and save order using ajax
				items.sortable('option', 'disabled', true);
				ajax_save_order();
				
				// remove disable link classes and show bulk selection
				items.find('a').removeClass('cb_disabled_link');
				items.find('input.bulk_selection').show();
				unbind_discourage_leaving_page();
				
				// enable selection of text and remove sort enabled class
				items.enableSelection();
				items.removeClass('sort_enabled');
				
				// swap button to original state
				$(this).html('Change Order').removeClass('button-primary');
			}
			else {
				
				// disable links, hide bulk selection and discourage leaving page
				items.find('a').addClass('cb_disabled_link');
				items.find('input.bulk_selection').hide();
				
				discourage_leaving_page('<?php _e("You have not saved your order. If you leave now you will loose your changes. Are you sure you want to continue leaving this page?", "catablog"); ?>');
				
				// disable selection of text and add sort enabled class
				items.disableSelection();
				items.addClass('sort_enabled');
				
				// enable sortable items
				items.sortable('option', 'disabled', false);
				
				// display helpful message to user
				var help_message = '<?php _e("Drag the items below to rearrange their order.", "catablog"); ?>';
				$('#message strong').html(help_message);
				$('#message').show();
				
				// swap button to active state
				$(this).html('Save Order').addClass('button-primary');
			}
			
			return false;
		});
		
		function ajax_save_order() {
			var ids = [];
			$('#catablog_items input.bulk_selection').each(function(i) {
				var id = $(this).attr('value');
				ids.push(id);
			});
			
			var params = {
				'action':   'catablog_reorder',
				'security': '<?php echo wp_create_nonce("catablog-reorder") ?>',
				'ids[]':    ids
			}
			
			$('#message strong').html('<?php _e("Saving new catalog order...", "catablog"); ?>');			
			$.post(ajaxurl, params, function(data) {
				$('#message strong').html('<?php _e("Your catalog items have been rearranged successfully.", "catablog"); ?>');
			});
		}
		*/
		 ?>

	});
</script>