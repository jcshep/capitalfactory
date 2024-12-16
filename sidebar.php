

<div id="sidebar">

<?php if(is_home() || is_archive()  || is_single() || is_category()) { ?>

<div class="blog-module">
	<h2>Categories</h2>
	<div class="inside">
		<?php wp_list_categories( 'title_li=' ) ?>
	</div>
</div>

<div class="blog-module">
	<h2>Archives</h2>
	<div class="inside">
		<?php wp_get_archives( 'limit=12' ) ?>
	</div>
</div>

<?php } ?>

</div>