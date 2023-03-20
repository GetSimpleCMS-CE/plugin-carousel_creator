<h3>Carousel Creator List item</h3>



<div class="col-md-12 py-2 px-0 mb-2">
	<a href="<?php echo $SITEURL . $GSADMIN . '/load.php?id=carouselCreator&addnew'; ?>" class="btn btn-add">Add New</a>
	<a href="<?php echo $SITEURL . $GSADMIN . '/load.php?id=carouselCreator&migrator'; ?>" class="btn btn-migrate">Migrate Domain</a>
</div>


<ul class="col-md-12 carList">

	<li class="list-item">


		<div class="title">
			Name
		</div>
		<div class="shortcode">
			Shortcode
		</div>
		<div class="list-btn">
			Edit

		</div>




	</li>


	<?php

	foreach (glob(GSPLUGINPATH . 'carouselCreator/carouselList/*.json') as $item) {

		$name = pathinfo($item)['filename'];

		echo '<li class="list-item">
<div class="title">
<b>' . $name . '</b>
</div>

<div class="shortcode">

<code> [% carousel=' . $name . ' %]
</code>
</div>

<div class="list-btn">
<a href="' . $SITEURL . $GSADMIN . '/load.php?id=carouselCreator&edit=' . $name . '" class="btn btn-edit">Edit</a>
<a href="' . $SITEURL . $GSADMIN . '/load.php?id=carouselCreator&delete=' . $name . '" onclick="return confirm(`Are you sure you want to delete this item?`);"  class="btn btn-del">Delete</a>
</div>
</li>';
	}; ?>


</ul>