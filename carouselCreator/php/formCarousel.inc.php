<div class="col-md-12 bg-light border p-3 options">
    <button class="sliderbtn  btn-tab"><?php echo i18n_r('carouselCreator/LANG_Item_Manager'); ?> 📷</button>
    <button class="settings btn-tab "><?php echo i18n_r('carouselCreator/LANG_Carousel_Settings'); ?> 🔨</button>
    <button class="help btn-tab "><?php echo i18n_r('carouselCreator/LANG_How_to'); ?> 🤔</button>
</div>

<div class="border helpcontent my-2 mt-3 bg-light p-4">

    <h3><?php echo i18n_r('carouselCreator/LANG_How_to'); ?></h3>

    <ul class="p-0" style="list-style-type:square;margin-left:15px;">
        <li>
            <p><b>1. </b><?php echo i18n_r('carouselCreator/LANG_Add_slide'); ?> </p>
        </li>

        <li>
            <p><b>2. </b><?php echo i18n_r('carouselCreator/LANG_Add_photos'); ?></p>
        </li>

        <li>
            <p><b>3. </b><?php echo i18n_r('carouselCreator/LANG_Configure_settings'); ?></p>
        </li>

        <li>
            <p><b>4. </b><?php echo i18n_r('carouselCreator/LANG_Add_the_following'); ?>: <code style="color:blue;">&#60;?php runCarousel('name');?&#62;</code></p>
        </li>

        <li>
            <p><b>5. </b><?php echo i18n_r('carouselCreator/LANG_Use_shortcode'); ?>: <code style="color:green;">[% carousel=name %]</code>
            <p>
        </li>
    </ul>

</div>

<form method="POST" action="#">
    <div class=" mt-4" id="sliderlist">
        <div class="sliderlist" id="sliderlister">

            <h3 style="margin:0 !important; margin-bottom:10px; margin-top:20px !important;"><?php echo i18n_r('carouselCreator/LANG_Carousel_Item_Manager'); ?></h3>

            <input type=" text" pattern="[A-Za-z0-9]+" required placeholder="<?php echo i18n_r('carouselCreator/LANG_Without_spaces'); ?>" name="title" <?php
                                                                                                                                                        if (isset($_GET['edit'])) {
                                                                                                                                                            echo 'value="' . $_GET['edit'] . '"';
                                                                                                                                                        }; ?>>

            <div class="bar" style="position:sticky;top:0;left:0;z-index:99;">
                <button class="btn-primary btn addslider"><?php echo i18n_r('carouselCreator/LANG_Add_Slide_btn'); ?> ➕</button>
                <input type="submit" name="submit" value="<?php echo i18n_r('carouselCreator/LANG_Save_Carousel_btn'); ?> 💾">
            </div>

            <?php
            if (isset($_GET['edit'])) {
                $filecontent = file_get_contents(GSDATAOTHERPATH . 'carouselCreator/' . $_GET['edit'] . '.json');

                $resultMe = json_decode($filecontent);

                foreach ($resultMe->sliderItem as $res) {
                    echo '
						<div class=" carousel-items">
							<button class="drag btn btn-warning btn-sm px-3" style="font-size:1.3rem;">↕</button> 
							<button class="closethis btn btn-danger btn-sm">✕</button>    

							<div style="display:grid; grid-template-columns:100px 1fr; align-items:center;">
								<img class="thumbs m-0  img-thumbnail" src="' . $res->image . '">
								<h5>' . ($res->carouseltitle !== "" ? $res->carouseltitle : i18n_r('carouselCreator/LANG_Slide_Item')) . '</h5>
							</div>
							';

                    echo '<input class="form-control mb-2 title-car" type="text" value="' . @$res->carouseltitle . '" name="carouseltitle[]" placeholder="' . i18n_r('carouselCreator/LANG_Slide_Title') . '">';
                    echo '<input class="form-control mb-2 image-car" type="text" value="' . $res->image . '" name="carouselimage[]" placeholder="' . i18n_r('carouselCreator/LANG_Image') . '">';
                    echo '<button class="takephoto btn-secondary btn my-2">' . i18n_r('carouselCreator/LANG_Choose_Photo') . ' 📸</button>';
                    echo '<button class="editcontent ml-2 btn-dark btn my-2">' . i18n_r('carouselCreator/LANG_Edit_Content') . ' 📝 </button>';

                    echo '<div class="editcontentshow">';
                    echo '<textarea class="carousel-text" id="editor1" name="carouselcontent[]">' . $res->content . '</textarea> </div>';
                    echo '<input type="text" placeholder="' . i18n_r('carouselCreator/LANG_Button_Name') . '" value="' . $res->linkname . '" name="linkname[]">';
                    echo '<select name="link[]"   style="width:100%; padding:10px; background:#fff; border:solid 1px #ddd;">';
                    echo '<option value="without-button" ' . ($res->link == 'without-button' ? 'selected' : '') . '>' . i18n_r('carouselCreator/LANG_Without_Button') . '</option>';

                    foreach (glob(GSDATAPAGESPATH . '*.xml') as $file) {
                        $fileName = pathinfo($file)['filename'];
                        echo '<option value="' . $fileName . '" ' . ($res->link == $fileName ? 'selected' : '') . '>' . $fileName . '</option>';
                    };

                    echo '</select> </div>';
                };
            };; ?>

        </div>
    </div>

    <?php if (isset($_GET['edit'])) {
        $settingsFile = file_get_contents(GSDATAOTHERPATH . 'carouselCreator/' . $_GET['edit'] . '.json');
        $jsonSettings = json_decode($filecontent);
    }; ?>

    <div class="bg-primary text-light col-md-12 my-3 py-3 my-3 border config">
        <h3 style="margin:0 !important;margin-bottom:10px;margin-top:20px !important;"><?php echo i18n_r('carouselCreator/LANG_Carousel_Settings'); ?></h3>

        <p><?php echo i18n_r('carouselCreator/LANG_Time_between_slides'); ?></p>
        <input name="autotimer" class="form-control" type="text" class="form-control autotimer" value="<?php echo @$jsonSettings->settings[0]->autotimer ?? '3000'; ?>">
        <br>

        <p><?php echo i18n_r('carouselCreator/LANG_Transition_speed'); ?> </p>
        <input name="transition" class="form-control" type="text" class="form-control transition" value="<?php echo @$jsonSettings->settings[0]->transition ?? '500'; ?>">
        <br>

        <p><?php echo i18n_r('carouselCreator/LANG_Darkens_the_image'); ?> </p>
        <input name="fog" type="text" class="form-control" value="<?php echo @$jsonSettings->settings[0]->fog ?? '0.2'; ?>">
        <br>

        <p><?php echo i18n_r('carouselCreator/LANG_Carousel_Width'); ?> </p>
        <input name="width" class="form-control" type="text" value="<?php echo @$jsonSettings->settings[0]->width ?? '100%'; ?>">
        <br>

        <p><?php echo i18n_r('carouselCreator/LANG_Carousel_Height'); ?> </p>
        <input name="height" class="form-control" type="text" value="<?php echo @$jsonSettings->settings[0]->height ?? '450px'; ?>">
        <br>

        <p><?php echo i18n_r('carouselCreator/LANG_Arrow_Styles'); ?> </p>
        <select name="arrow" class="form-control">
            <option value="0" <?php echo (@$jsonSettings->settings[0]->arrow === "0" ? "selected" : ""); ?>><?php echo i18n_r('carouselCreator/LANG_Style_1'); ?> </option>
            <option value="1" <?php echo (@$jsonSettings->settings[0]->arrow === "1" ? "selected" : ""); ?>><?php echo i18n_r('carouselCreator/LANG_Style_2'); ?> </option>
            <option value="2" <?php echo (@$jsonSettings->settings[0]->arrow === "2" ? "selected" : ""); ?>><?php echo i18n_r('carouselCreator/LANG_No_Arrows'); ?> </option>
        </select>
        <br>

        <p><?php echo i18n_r('carouselCreator/LANG_Style_Slider'); ?></p>
        <select name="style" class="form-control">

            <?php foreach (glob(GSPLUGINPATH . 'carouselCreator/style/*.css') as $style) {

                $name = pathinfo($style)['filename'];
                echo '<option value="' . $name . '" ' . (@$jsonSettings->settings[0]->style == $name ? "selected" : "") . ' >' . $name . '</option>';
            };
            ?>

        </select>
        <br>

        <input type="submit" name="submit" class="btn btn-success" value="<?php echo i18n_r('carouselCreator/LANG_Save_Carousel_btn'); ?> 💾">

    </div>
</form>

<script type="text/javascript" src="template/js/ckeditor/ckeditor.js?t=3.3.18"></script>

<script>
    if (document.querySelector('textarea')) {

        document
            .querySelectorAll('textarea')
            .forEach(c => {

                CKEDITOR.replace(c, {
                    height: 230,
                    toolbar: 'advanced',
                    baseHref: '<?php echo $SITEURL; ?>',
                    tabSpaces: 10,
                    filebrowserBrowseUrl: 'filebrowser.php?type=all',
                    filebrowserImageBrowseUrl: 'filebrowser.php?type=images'

                });

            });

    };

    let counters = 1;

    if (document.querySelector('.closethis')) {

        document
            .querySelectorAll('.closethis')
            .forEach((x, i) => {
                x.addEventListener('click', (c) => {
                    c.preventDefault();
                    x
                        .parentElement
                        .remove()
                });

            })
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>

<script>
    var el = document.getElementById('sliderlister');
    var sortable = Sortable.create(el, {
        animation: 200,
        group: 'slidelist',
        handle: '.drag'
    });

    //listfile

    document.querySelectorAll('.takephoto').forEach((item, index) => {

        item.addEventListener('click', (e) => {
            e.preventDefault();
            e.preventDefault();
            window.open('<?php global $SITEURL;
                            echo $SITEURL; ?>plugins/carouselCreator/filebrowser/imagebrowser.php?type=images&CKEditor=post-content&class=image-car&func=' + index, '', 'width=800,height=600');
        })

    })

    //drag

    document
        .querySelectorAll('.drag')
        .forEach(x => {
            x.addEventListener('click', e => {
                e.preventDefault();
            })
        })

    //editcontentshow hidden
    document
        .querySelectorAll('.editcontentshow')
        .forEach(x => {
            x.style.display = "none";
        })

    document
        .querySelectorAll('.carousel-items')
        .forEach((c, i) => {

            c
                .querySelector('.editcontent')
                .addEventListener('click', e => {
                    e.preventDefault();

                    if (c.querySelector('.editcontentshow').style.display == "none") {
                        c
                            .querySelector('.editcontentshow')
                            .style
                            .display = "block";
                    } else {
                        c
                            .querySelector('.editcontentshow')
                            .style
                            .display = "none";
                    }

                });

        })

    document
        .querySelector('.addslider')
        .addEventListener('click', (e) => {
            e.preventDefault();

            document
                .querySelector('.sliderlist')
                .insertAdjacentHTML(
                    'beforeend',
                    `
<div class="carousel bg-light border p-3 my-2 carousel-items carousel-items-${counters}">
	<button class="drag btn btn-primary btn-sm px-3" style="font-size:1.3rem;">↕</button> 
	<button class="closethis btn btn-danger btn-sm">✕</button>    
	<h4><?php echo i18n_r('carouselCreator/LANG_Slide_Item'); ?></h4>
	<input class="form-control mb-2 title-car" type="text"  name="carouseltitle[]" placeholder="<?php echo i18n_r('carouselCreator/LANG_Slide_Title'); ?>">
	<input class="form-control mb-2 image-car newimagecar" type="text"  name="carouselimage[]" placeholder="<?php echo i18n_r('carouselCreator/LANG_Image'); ?>">
	<button class="takephotos take-${counters} btn-primary my-2 btn"><?php echo i18n_r('carouselCreator/LANG_Choose_Photo'); ?> 📸</button>
	<button class="editcontent editcon-${counters} btn-success my-2 btn"><?php echo i18n_r('carouselCreator/LANG_Edit_Content'); ?> 📝 </button>

	<div class="editcontentshow edit-${counters}">
		<textarea class="carousel-text" id="editor-${counters}" name="carouselcontent[]"></textarea>
	</div>

	<input type="text" placeholder="<?php echo i18n_r('carouselCreator/LANG_Button_Name'); ?>" name="linkname[]">
	<select name="link[]"  style="width:100%; padding:10px; background:#fff; border:solid 1px #ddd;">
		<option value="without-button"><?php echo i18n_r('carouselCreator/LANG_Without_Button'); ?></option>

<?php


foreach (glob(GSDATAPAGESPATH . '*.xml') as $file) {
    $fileName = pathinfo($file)['filename'];
    echo '<option value="' . $fileName . '">' . $fileName . '</option>';
}; ?>

	</select>
	</div>

</div>
    `
                );

            CKEDITOR.replace('editor-' + counters, {
                height: 230,
                toolbar: 'advanced',
                baseHref: '<?php echo $SITEURL; ?>',
                tabSpaces: 10,
                filebrowserBrowseUrl: 'filebrowser.php?type=all',
                filebrowserImageBrowseUrl: 'filebrowser.php?type=images'
            });

            let eds = document.querySelector('editor-' + counters);

            document.querySelectorAll('.closethis')
                .forEach((x, i) => {

                    x.addEventListener('click', (c) => {
                        c.preventDefault();
                        x.parentElement
                            .remove()
                    });

                });

            document.querySelector(`.carousel-items-${counters} .edit-${counters}`).style.display = "none";

            document
                .querySelectorAll(`.carousel-items-${counters}`)
                .forEach((c, i) => {

                    c
                        .querySelector('.editcontent')
                        .addEventListener('click', e => {
                            e.preventDefault();

                            if (c.querySelector('.editcontentshow').style.display == "none") {
                                c
                                    .querySelector('.editcontentshow')
                                    .style
                                    .display = "block";
                            } else {
                                c
                                    .querySelector('.editcontentshow')
                                    .style
                                    .display = "none";
                            }

                        });

                })

            counters++;

            document.querySelectorAll('.takephotos').forEach((item, index) => {

                item.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.preventDefault();
                    window.open('<?php global $SITEURL;
                                    echo $SITEURL; ?>plugins/carouselCreator/filebrowser/imagebrowser.php?type=images&CKEditor=post-content&class=newimagecar&func=' + index, '', 'width=800,height=600');
                })
            })

        })

    document.querySelector('.sliderlist').style.display = "block";
    document.querySelector('.helpcontent').style.display = "none";
    document.querySelector('.config').style.display = "none";

    document.querySelector('button.settings').addEventListener('click', (e) => {

        e.preventDefault();
        document.querySelector('.config').style.display = "block";
        document.querySelector('.sliderlist').style.display = "none";
        document.querySelector('.helpcontent').style.display = "none";

    })

    document.querySelector('button.help').addEventListener('click', (e) => {

        e.preventDefault();
        document.querySelector('.config').style.display = "none";
        document.querySelector('.sliderlist').style.display = "none";
        document.querySelector('.helpcontent').style.display = "block";

    })

    document.querySelector('button.sliderbtn').addEventListener('click', (e) => {

        e.preventDefault();
        document.querySelector('.config').style.display = "none";
        document.querySelector('.sliderlist').style.display = "block";
        document.querySelector('.helpcontent').style.display = "none";

    })
</script>