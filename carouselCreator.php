<?php

# get correct id for plugin
$thisfile = basename(__FILE__, ".php");

# add in this plugin's language file
i18n_merge('carouselCreator') || i18n_merge('carouselCreator', 'en_US');

# register plugin
register_plugin(
	$thisfile, //Plugin id
	'carouselCreator',   //Plugin name
	'4.0',     //Plugin version
	'Multicolor',  //Plugin author
	'https://paypal.me/multicol0r', //author website
	i18n_r('carouselCreator/LANG_Description'), //Plugin description
	'pages', //page type - on which admin tab to display
	'carouselCreator'  //main function (administration)
);

# add a link in the admin tab 'theme'
add_action('pages-sidebar', 'createSideMenu', array($thisfile, i18n_r('carouselCreator/LANG_Settings')));

require(GSPLUGINPATH . 'carouselCreator/class/carouselCreator.class.php');

$cc = new Creator();

function carouselCreator()
{

	global $SITEURL;
	global $GSADMIN;

	echo '<style>@import url("' . $SITEURL . 'plugins/carouselCreator/css/backend.css");</style>';

	echo '
		<div class="carCreator">';

	if (isset($_GET['addnew'])) {
		include(GSPLUGINPATH . 'carouselCreator/php/formCarousel.inc.php');
	} elseif (isset($_GET['edit'])) {
		include(GSPLUGINPATH . 'carouselCreator/php/formCarousel.inc.php');
	} elseif (isset($_GET['migrator'])) {
		include(GSPLUGINPATH . 'carouselCreator/php/migrate.inc.php');
	} else {
		include(GSPLUGINPATH . 'carouselCreator/php/list.inc.php');
	}

	echo '
			<div class="sponsor"> 
				<p class="lead">' . i18n_r('carouselCreator/LANG_PayPal') . '</p>
				<a href="https://www.paypal.com/donate/?hosted_button_id=TW6PXVCTM5A72">
					<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif"  />
				</a>

			</div>
		</div>
		';

	if (isset($_POST['changeURL'])) {
		global $cc;
		$cc->changeUrl();
	};

	if (isset($_GET['delete'])) {
		global $cc;
		$cc->deleteFile();
	}

	if (isset($_POST['submit'])) {
		global $cc;
		$cc->createFile();
	};
}

 

add_action('theme-header', 'pageBegin');
function pageBegin()
{
	global $content;
	$newcontent = preg_replace_callback(
		'/\\[% carousel=(.*) %\\]/i',
		'runCarouselShortcode',
		$content
	);
	$content = $newcontent;
};

//carouselShortcode 
function runCarouselShortcode($item)
{
	global $cc;
	return $cc->shortCode($item);
}

//carousel 
function runCarousel($item)
{
	global $cc;
	return $cc->run($item);
};
