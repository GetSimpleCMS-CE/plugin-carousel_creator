<h3><?php echo i18n_r('carouselCreator/LANG_Migrate_CC') ;?></h3>

<form action="#" method="post" >
	<label for=""><?php echo i18n_r('carouselCreator/LANG_Old_URL') ;?></label>
	<input type="text" name="oldurl"  placeholder="https://youroldadress.com/">
	
	<label for=""><?php echo i18n_r('carouselCreator/LANG_New_URL') ;?></label>
	<input type="text" name="newurl" placeholder="https://yournewadress.com/">
	
	<input type="submit" name="changeURL"  value="<?php echo i18n_r('carouselCreator/LANG_Update_URL') ;?>">
</form>