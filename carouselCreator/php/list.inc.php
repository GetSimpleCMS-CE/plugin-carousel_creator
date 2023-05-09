<h3><?php echo i18n_r('carouselCreator/LANG_Carousel_Creator_List'); ?></h3>

<div class="col-md-12 py-2 px-0 mb-2">
	<a href="<?php echo $SITEURL . $GSADMIN . '/load.php?id=carouselCreator&addnew'; ?>" class="btn btn-add"><?php echo i18n_r('carouselCreator/LANG_Add_New'); ?></a>
	<a href="<?php echo $SITEURL . $GSADMIN . '/load.php?id=carouselCreator&migrator'; ?>" class="btn btn-migrate"><?php echo i18n_r('carouselCreator/LANG_Migrate'); ?></a>
</div>

<ul class="col-md-12 carList">

	<li class="list-item">
		<div class="title">
			<?php echo i18n_r('carouselCreator/LANG_Name'); ?>
		</div>
		<div class="shortcode">
			<?php echo i18n_r('carouselCreator/LANG_Shortcode'); ?>
		</div>
		<div class="list-btn">
			<?php echo i18n_r('carouselCreator/LANG_Edit'); ?>
		</div>
	</li>

	<?php
	foreach (glob(GSDATAOTHERPATH . 'carouselCreator/*.json') as $item) {
		$name = pathinfo($item)['filename'];

		echo '
		<li class="list-item">
			<div class="title">
				<b>' . $name . '</b>
			</div>

			<div class="shortcode">
				<code>[% carousel=' . $name . ' %]</code>
			</div>

			<div class="list-btn">
				<a href="' . $SITEURL . $GSADMIN . '/load.php?id=carouselCreator&edit=' . $name . '" class="btn btn-edit">' . i18n_r('carouselCreator/LANG_Edit') . '</a>
				<a href="' . $SITEURL . $GSADMIN . '/load.php?id=carouselCreator&delete=' . $name . '" onclick="return confirm(`Are you sure you want to delete this item?`);"  class="btn btn-del" title="' . i18n_r('carouselCreator/LANG_Delete') . '"> ✕ </a>
			</div>
		</li>';
	}; ?>

</ul>