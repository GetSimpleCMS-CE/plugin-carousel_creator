<?php

class Creator
{

    public $matches;




    public function changeUrl()
    {

        foreach (glob(GSPLUGINPATH . 'carouselCreator/carouselList/*.json') as $file) {
            $fileContent = file_get_contents($file);
            $oldurl = str_replace('/', '\/', $_POST['oldurl']);
            $newurl = str_replace('/', '\/', $_POST['newurl']);
            $newContent = str_replace([$oldurl, $oldurl . '/'], [$newurl, $newurl . '/'], $fileContent);
            file_put_contents($file, $newContent);
        }
        echo '<div class="alert-carcreator">done!</div>';
    }


    public function deleteFile()
    {
        global $GSADMIN;
        global $SITEURL;
        unlink(GSPLUGINPATH . 'carouselCreator/carouselList/' . $_GET['delete'] . '.json');
       echo '<script>window.location.replace("'.$SITEURL.$GSADMIN.'/load.php?id=carouselCreator");</script>';
    }

    public function createFile()
    {

        global $GSADMIN;
        global $SITEURL;

        $carouselList = array();
        $carouselList['sliderItem'] = [];
        $carouselList['settings'] = [];
        $image = @$_POST['carouselimage'];
        $content = @$_POST['carouselcontent'];
        $carouseltitle = @$_POST['carouseltitle'];

        $autotimer = $_POST['autotimer'];
        $transition = $_POST['transition'];
        $fog = $_POST['fog'];
        $height = $_POST['height'];
        $width = $_POST['width'];
        $arrow = $_POST['arrow'];


        foreach ($content as $key => $value) {
            array_push($carouselList['sliderItem'], array('image' => $image[$key], 'content' => $content[$key], 'carouseltitle' => $carouseltitle[$key]));


            array_push($carouselList['settings'], array('autotimer' => $autotimer, 'transition' => $transition, 'fog' => $fog, 'height' => $height, 'width' => $width, 'arrow' => $arrow));



            $jser = json_encode($carouselList, true);
            file_put_contents(GSPLUGINPATH . 'carouselCreator/carouselList/' . @$_POST['title'] . '.json', $jser);
        };

        echo '<script>window.location.replace("'.$SITEURL.$GSADMIN.'/load.php?id=carouselCreator&edit='.$_POST['title'].'");</script>';

    }


    public function shortCode($matches)
    {


        $this->name = $matches[1];


        global $SITEURL;


        $filecontent = file_get_contents(GSPLUGINPATH . 'carouselCreator/carouselList/' .  $this->name . '.json');
        $resultMe = json_decode($filecontent);

        $carousel = '';

        $carousel .= '<div class="slider-container" id="' . $this->name . '" style="width:' . $resultMe->settings[0]->width . '">';
        $carousel .=  '<div id="slider' .  $this->name . '" class="swipe">';
        $carousel .=  '<div class="swipe-wrap">';


        if (isset($resultMe)) {

            foreach ($resultMe->sliderItem as $res) {

                $carousel .= '<div class="slider-item" style="background:url(' . $res->image . ');background-size:cover;background-position:center center;width:' . $resultMe->settings[0]->width . ';
  height:' . $resultMe->settings[0]->height . ';">';
                $carousel .= '<div class="slider-fog" style="background:rgba(0,0,0,' . $resultMe->settings[0]->fog . ');">';
                $carousel .= '<div class="slider-item-content">' . $res->content . '</div>';
                $carousel .= '</div>';
                $carousel .= '</div>';
            };
        };

        if ($resultMe->settings[0]->arrow !== '2') {

            $carousel .=  '</div></div><button class="slider-prev" ><img src="' . $SITEURL . 'plugins/carouselCreator/images/left' .
                $resultMe->settings[0]->arrow . '.svg"></button>';
            $carousel .=  '<button class="slider-next" >
<img src="' . $SITEURL . 'plugins/carouselCreator/images/right' . $resultMe->settings[0]->arrow . '.svg"></button>
';
        };


        $carousel .= '</div>';




        $carousel .= '
<script src="' . $SITEURL . 'plugins/carouselCreator/js/swipe.min.js"></script>

<script>

var element' . $this->name . ' = document.querySelector("#slider' .  $this->name . '");
window.mySwipe' . $this->name . ' = new Swipe(element' . $this->name . ', {
  startSlide: 0,
  auto: ' . $resultMe->settings[0]->autotimer . ',';

        if (isset($resultMe->settings[0]->transition)) {

            $carousel .= ' speed:' . $resultMe->settings[0]->transition . ',';
        };
        $carousel .= '
  draggable: true,
  autoRestart: true,
  continuous: true,
  disableScroll: true,
  stopPropagation: true,
  callback: function(index, element) {},
  transitionEnd: function(index, element) {}
});
';

        if ($resultMe->settings[0]->arrow !== '2') {


            $carousel .= "
prevBtn = document.querySelector('#" .  $this->name . " .slider-prev');
nextBtn = document.querySelector('#" .  $this->name . " .slider-next');
nextBtn.onclick = mySwipe" . $this->name . ".next;
prevBtn.onclick = mySwipe" . $this->name . ".prev;

";
        };

        $carousel .= '</script>';

        return $carousel;
    }




    public function run($name)
    {

        global $SITEURL;


        $filecontent = file_get_contents(GSPLUGINPATH . 'carouselCreator/carouselList/' .  $name . '.json');
        $resultMe = json_decode($filecontent);

        $carousel = '';

        $carousel .= '<div class="slider-container" id="' . $name . '" style="width:' . $resultMe->settings[0]->width . '">';
        $carousel .=  '<div id="slider' .  $name . '" class="swipe">';
        $carousel .=  '<div class="swipe-wrap">';


        if (isset($resultMe)) {

            foreach ($resultMe->sliderItem as $res) {

                $carousel .= '<div class="slider-item" style="background:url(' . $res->image . ');background-size:cover;background-position:center center;width:' . $resultMe->settings[0]->width . ';
  height:' . $resultMe->settings[0]->height . ';">';
                $carousel .= '<div class="slider-fog" style="background:rgba(0,0,0,' . $resultMe->settings[0]->fog . ');">';
                $carousel .= '<div class="slider-item-content">' . $res->content . '</div>';
                $carousel .= '</div>';
                $carousel .= '</div>';
            };
        };

        if ($resultMe->settings[0]->arrow !== '2') {

            $carousel .=  '</div></div><button class="slider-prev" ><img src="' . $SITEURL . 'plugins/carouselCreator/images/left' .
                $resultMe->settings[0]->arrow . '.svg"></button>';
            $carousel .=  '<button class="slider-next" >
<img src="' . $SITEURL . 'plugins/carouselCreator/images/right' . $resultMe->settings[0]->arrow . '.svg"></button>
';
        };


        $carousel .= '</div>';




        $carousel .= '
<script src="' . $SITEURL . 'plugins/carouselCreator/js/swipe.min.js"></script>

<script>

var element' . $name . ' = document.querySelector("#slider' .  $name . '");
window.mySwipe' . $name . ' = new Swipe(element' . $name . ', {
  startSlide: 0,
  auto: ' . $resultMe->settings[0]->autotimer . ',';

        if (isset($resultMe->settings[0]->transition)) {

            $carousel .= ' speed:' . $resultMe->settings[0]->transition . ',';
        };
        $carousel .= '
  draggable: true,
  autoRestart: true,
  continuous: true,
  disableScroll: true,
  stopPropagation: true,
  callback: function(index, element) {},
  transitionEnd: function(index, element) {}
});
';

        if ($resultMe->settings[0]->arrow !== '2') {


            $carousel .= "
prevBtn = document.querySelector('#" .  $name . " .slider-prev');
nextBtn = document.querySelector('#" .  $name . " .slider-next');
nextBtn.onclick = mySwipe" . $name . ".next;
prevBtn.onclick = mySwipe" . $name . ".prev;

";
        };

        $carousel .= '</script>';

        echo $carousel;
    }
};
