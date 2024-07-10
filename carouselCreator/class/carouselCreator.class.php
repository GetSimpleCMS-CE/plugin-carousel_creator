<?php

class Creator
{
    public $matches;

    public function changeUrl()
    {
        foreach (glob(GSDATAOTHERPATH . 'carouselCreator/*.json') as $file) {
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
        unlink(GSDATAOTHERPATH . 'carouselCreator/' . $_GET['delete'] . '.json');
        echo '<script>window.location.replace("' . $SITEURL . $GSADMIN . '/load.php?id=carouselCreator");</script>';
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
        $link = @$_POST['link'];
        $linkName = @$_POST['linkname'];

        $autotimer = $_POST['autotimer'];
        $transition = $_POST['transition'];
        $fog = $_POST['fog'];
        $height = $_POST['height'];
        $width = $_POST['width'];
        $arrow = $_POST['arrow'];
        $style = $_POST['style'];

        foreach ($content as $key => $value) {
            array_push($carouselList['sliderItem'], array('image' => $image[$key], 'content' => $content[$key], 'carouseltitle' => $carouseltitle[$key], 'link' => $link[$key], 'linkname' => $linkName[$key]));

            array_push($carouselList['settings'], array('autotimer' => $autotimer, 'transition' => $transition, 'fog' => $fog, 'height' => $height, 'width' => $width, 'arrow' => $arrow, 'style' => $style));

            $jser = json_encode($carouselList, true);

            $folder = GSDATAOTHERPATH . 'carouselCreator/';

            if (!file_exists($folder)) {

                mkdir($folder, 0755);
                file_put_contents($folder . '.htaccess', 'Deny from all');
            };
            file_put_contents($folder . @$_POST['title'] . '.json', $jser);
        };

        echo '<script>window.location.replace("' . $SITEURL . $GSADMIN . '/load.php?id=carouselCreator&edit=' . $_POST['title'] . '");</script>';
    }

    public function shortCode($matches)
    {
        $this->name = $matches[1];

        $folder = GSDATAOTHERPATH . 'carouselCreator/';

        global $SITEURL;

        $filecontent = file_get_contents($folder .  $this->name . '.json');
        $resultMe = json_decode($filecontent);

        $carousel = '';


        $carousel .=  '<link rel="stylesheet" href="' . $SITEURL . 'plugins/carouselCreator/style/' . $resultMe->settings[0]->style . '.css">';






        $carousel .= '<div class="slider-container" id="' . $this->name . '" style="width:' . $resultMe->settings[0]->width . '">';
        $carousel .=  '<div id="slider' .  $this->name . '" class="swipe">';
        $carousel .=  '<div class="swipe-wrap">';

        if (isset($resultMe)) {



            foreach ($resultMe->sliderItem as $res) {

                $carousel .= '<div class="slider-item" style="background:url(' . $res->image . ');background-size:cover;background-position:center center;width:' . $resultMe->settings[0]->width . ';
				height:' . $resultMe->settings[0]->height . ';">';
                $carousel .= '<div class="slider-fog" style="background:rgba(0,0,0,' . $resultMe->settings[0]->fog . ');">';
                $carousel .= '<div class="slider-item-content">';

                $carousel .= '<h4>' . $res->carouseltitle . '</h4>';
                $carousel .= $res->content;
                $carousel .=  ($res->link !== 'without-button' ? '<a href="' . $SITEURL . $res->link . '" class="slider-item-btn">' . $res->linkname . '</a>' : '') . '</div>';
                $carousel .= '</div>';
                $carousel .= '</div>';
            };
        };

        if ($resultMe->settings[0]->arrow !== '2') {
            $carousel .=  '</div></div><button class="slider-prev" ><img src="' . $SITEURL . 'plugins/carouselCreator/images/left' .
                $resultMe->settings[0]->arrow . '.svg" width="48" height="48" title="shift left" alt="shift left"></button>';
            $carousel .=  '<button class="slider-next" >
			<img src="' . $SITEURL . 'plugins/carouselCreator/images/right' . $resultMe->settings[0]->arrow . '.svg" width="48" height="48" title="shift left" alt="shift left"></button>
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
  
  callback: function(index, element) {
    document.querySelectorAll(".slider-item-content").forEach(cww=>{cww.style.display="none"});

    setTimeout(()=>{
       element.querySelector(".slider-item-content").style.display="block";
    },"500")
    
  },
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
        $folder = GSDATAOTHERPATH . 'carouselCreator/';
        $filecontent = file_get_contents($folder .  $name . '.json');
        $resultMe = json_decode($filecontent);

        $carousel = '';

        $carousel .=  '<link rel="stylesheet" href="' . $SITEURL . 'plugins/carouselCreator/style/' . $resultMe->settings[0]->style . '.css">';






        $carousel .= '<div class="slider-container" id="' . $name . '" style="width:' . $resultMe->settings[0]->width . '">';
        $carousel .=  '<div id="slider' .  $name . '" class="swipe">';
        $carousel .=  '<div class="swipe-wrap">';

        if (isset($resultMe)) {



            foreach ($resultMe->sliderItem as $res) {

                $carousel .= '<div class="slider-item" style="background:url(' . $res->image . ');background-size:cover;background-position:center center;width:' . $resultMe->settings[0]->width . ';
				height:' . $resultMe->settings[0]->height . ';">';
                $carousel .= '<div class="slider-fog" style="background:rgba(0,0,0,' . $resultMe->settings[0]->fog . ');">';
                $carousel .= '<div class="slider-item-content">';

                $carousel .= '<h4>' . $res->carouseltitle . '</h4>';
                $carousel .= $res->content;
                $carousel .=  ($res->link !== 'without-button' ? '<a href="' . $SITEURL . $res->link . '" class="slider-item-btn">' . $res->linkname . '</a>' : '') . '</div>';
                $carousel .= '</div>';
                $carousel .= '</div>';
            };
        };

        if ($resultMe->settings[0]->arrow !== '2') {
            $carousel .=  '</div></div><button class="slider-prev" ><img src="' . $SITEURL . 'plugins/carouselCreator/images/left' .
                $resultMe->settings[0]->arrow . '.svg" width="48" height="48" title="shift left" alt="shift left"></button>';
            $carousel .=  '<button class="slider-next" >
			<img src="' . $SITEURL . 'plugins/carouselCreator/images/right' . $resultMe->settings[0]->arrow . '.svg" width="48" height="48" title="shift left" alt="shift left"></button>
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
				callback: function(index, element) {
					document.querySelectorAll(".slider-item-content").forEach(cww=>{cww.style.display="none"});
					setTimeout(()=>{
						element.querySelector(".slider-item-content").style.display="block";
					},"500")
				},
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
