 <div class="col-md-12 bg-light border p-3 options">

     <button class="sliderbtn  btn-tab">Slider Item Manager 📷 </button>
     <button class="settings btn-tab ">Settings 🔨</button>
     <button class="help btn-tab ">How to use? 🤔</button>

 </div>


 <div class="border helpcontent my-2 mt-3 bg-light p-4">

     <h3>How to use it?</h3>
     <ul class="p-0" style="list-style-type:square;margin-left:15px;">
        
         <li>
             <p>
                 <b>1.</b>
                 Add slider to your carousel on button "add slider"
             </p>
         </li>
         <li>
             <p>
                 <b>2.</b>
                 Set photo and content to every slider
             </p>
         </li>
         <li>
             <p>
                 <b>3.</b>
                 Configure settings on carousel
             </p>
         </li>
         <li>
             <p>
                 <b>4.</b>
                 Add
                 <code>&#60;?php runCarousel('name');?&#62;</code>
                 to your template
             </p>
         </li>

         <li>
             <p>
                 <b>5. New!</b> You can use shortcode - paste this code on CKEditor <code>[% carousel=name %]</code>
             <p>
         </li>
     </ul>

 </div>

 <form method="POST" action="#">


 


         <div class=" mt-4" id="sliderlist">

            
             <div class="sliderlist" id="sliderlister">

             <h3  style="margin:0 !important;margin-bottom:10px;margin-top:20px !important;">Slider Item Manager</h3>


             <input type=" text" pattern="[A-Za-z0-9]+" required  placeholder="title carousel without spacebar and special characters" name="title" <?php

                                                                                                                                                            if (isset($_GET['edit'])) {

                                                                                                                                                                echo 'value="' . $_GET['edit'] . '"';
                                                                                                                                                            }; ?>>



<div class="bar" style="position:sticky;top:0;left:0;z-index:99;">
                 <button class="btn-primary btn addslider">Add Slide ➕</button>
                                               <input type="submit" name="submit"  value="Save Carousel 💾">

             </div>


                 <?php


                    if (isset($_GET['edit'])) {

                        $filecontent = file_get_contents(GSPLUGINPATH . 'carouselCreator/carouselList/' . $_GET['edit'] . '.json');


                        $resultMe = json_decode($filecontent);

                        foreach ($resultMe->sliderItem as $res) {


                            echo '<div class=" carousel-items"><button class="drag btn btn-warning btn-sm px-3" style="font-size:1.3rem;">↕</button> 
 <button class="closethis btn btn-danger btn-sm">Delete ✕</button>    

 <div style="display:grid;grid-template-columns:100px 1fr;align-items:center;">

 <img class="thumbs m-0  img-thumbnail" src="' . $res->image . '">

<h4>' . ($res->carouseltitle !== "" ? $res->carouseltitle : "Slider item") . '</h4>

 </div>
 ';
                            echo '<input class="form-control mb-2 title-car" type="text" value="' . @$res->carouseltitle . '" name="carouseltitle[]" placeholder="slider title">';
                            echo '<input class="form-control mb-2 image-car" type="text" value="' . $res->image . '" name="carouselimage[]" placeholder="image">';
                            echo '<button class="takephoto btn-secondary btn my-2">Choose Photo 📸</button>';
                            echo '<button class="editcontent ml-2 btn-dark btn my-2">Edit Content📝 </button>';

                            echo '<div class="editcontentshow">';
                            echo '<textarea class="carousel-text" id="editor1" name="carouselcontent[]">' . $res->content . '</textarea>

</div>
</div>


';
                        };
                    };; ?>



             </div>

         </div>



         <?php if (isset($_GET['edit'])) {
                $settingsFile = file_get_contents(GSPLUGINPATH . 'carouselCreator/carouselList/' . $_GET['edit'] . '.json');
                $jsonSettings = json_decode($filecontent);
            }; ?>


         <div class="bg-primary text-light col-md-12 my-3 py-3 my-3 border config">

         <h3  style="margin:0 !important;margin-bottom:10px;margin-top:20px !important;">Settings</h3>

 
             <p>Time between next slider, if 0 -autoplay disable (milliseconds)</p>
             <input name="autotimer" class="form-control" type="text" class="form-control autotimer" value="<?php echo @$jsonSettings->settings[0]->autotimer ?? '3000'; ?>">
             <br>


             <p>Transition speed (milliseconds)</p>
             <input name="transition" class="form-control" type="text" class="form-control transition" value="<?php echo @$jsonSettings->settings[0]->transition ?? '500'; ?>">
             <br>

             <p>Darkens the image below the text ( 0 - 1 example: 0.2)</p>
             <input name="fog" type="text" class="form-control" value="<?php echo @$jsonSettings->settings[0]->fog ?? '0.2'; ?>">
             <br>

             <p>Slider width(example 450px ord 20% or 20vw)</p>

             <input name="width" class="form-control" type="text" value="<?php echo @$jsonSettings->settings[0]->width ?? '100%'; ?>">
             <br>
             <p>Slider height (example 450px or 20% or 20vh)</p>
             <input name="height" class="form-control" type="text" value="<?php echo @$jsonSettings->settings[0]->height ?? '450px'; ?>">
             <br>
             <p>Arrow style</p>
             <select name="arrow" class="form-control">
                 <option value="0" <?php echo (@$jsonSettings->settings[0]->arrow === "0" ? "selected" : ""); ?>>style 1</option>
                 <option value="1" <?php echo (@$jsonSettings->settings[0]->arrow === "1" ? "selected" : ""); ?>>style 2</option>
                 <option value="2" <?php echo (@$jsonSettings->settings[0]->arrow === "2" ? "selected" : ""); ?>>without arrow</option>
             </select>
             <br>
             <input type="submit" name="submit" class="btn btn-success" value="Save Settings 💾">
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
                     baseHref : '<?php echo $SITEURL;?>',
                     tabSpaces:10,
					filebrowserBrowseUrl : 'filebrowser.php?type=all',
					filebrowserImageBrowseUrl : 'filebrowser.php?type=images'

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
<button class="closethis btn btn-danger btn-sm">Delete ✕</button>    
<h4>Carousel item</h4>
<input class="form-control mb-2 title-car" type="text"  name="carouseltitle[]" placeholder="title slide">
<input class="form-control mb-2 image-car newimagecar" type="text"  name="carouselimage[]" placeholder="image url">
<button class="takephotos take-${counters} btn-primary my-2 btn">Choose Photo 📸</button>
<button class="editcontent editcon-${counters} btn-success my-2 btn">Edit Content📝 </button>


<div class="editcontentshow edit-${counters}">
<textarea class="carousel-text" id="editor-${counters}" name="carouselcontent[]"></textarea>
</div>
</div>
    `
                 );

             CKEDITOR.replace('editor-' + counters, {
                 height: 230,
                 toolbar: 'advanced',
                 baseHref : '<?php echo $SITEURL;?>',
                     tabSpaces:10,
					filebrowserBrowseUrl : 'filebrowser.php?type=all',
					filebrowserImageBrowseUrl : 'filebrowser.php?type=images'
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