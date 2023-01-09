<?php

namespace App\Libraries;

class CarouselHelper
{
    // éléments du carousel
    function listCarousel($list, $index = 0)
    {
        $str = "";
        $i = 0;
        // if ($showIndicator) {
        //     $str = indicatorCarousel($index, count($list));
        // }
        $str .= "<div class='carousel-inner'>";
        foreach ($list as $item) {
            $active = ($i == $index) ? "active" : "";
            $str .= "<div class='carousel-item " . $active . " '' >";
            $str .= "<img src='" . $item['url_image'] . "' class='d-block w-100' alt='...'>";
            $str .= "<div class='carousel-caption d-none d-md-block'>";
            $str .= "<h5>" . $item['title'] . "</h5>";
            $str .= "<p>" . $item['description'] . "</p>";
            $str .= "</div>";
            $str .= "</div>";
            $i++;
        }
        $str .= "</div>";
        return $str;
    }

    function listCardCarousel($list, $index = 0,)
    {
        $str = "";
        $i = 0;

        $str .= "<div class='carousel-inner'>";
        foreach ($list as $item) {
            $active = ($i == $index) ? "active" : "";
            $str .= "<div class='carousel-item " . $active . " '' >";
            $str .= "<div class='card'>";
            $str .= "<div class='img-wrapper' ><img src='" . $item['url_image'] . "' w-100' alt='...'>";
            $str .= "<div class='card-body'>";
            $str .= "<h5 class='card-title'>" . $item['title'] . "</h5>";
            $str .= "<p class='card-text'>" . $item['description'] . "</p>";
            $str .= "<a href='#' class='btn btn-primary'>Go somewhere</a>";
            $str .= "</div>"; //img-wrapper       
            $str .= "</div>"; //card
            $str .= "</div>"; // carousel item
            $i++;
        }
        $str .= "</div>";
        return $str;
    }

    function listCardImgCarousel($list,  $target = "#")
    {
        $str = "";
        $i = 0;
        $str .= "<div class='carousel-inner' role='listbox'>\n";

        foreach ($list as $item) {
            if (isset($item['title'])) {
                $title = $item['title'];
                $id=$item['id_training'];
            }
            if (isset($item['subject'])) {
                $title = $item['subject'];
                $id=$item['id_article'];
            }
            if ($item['image_url']==null){
                $item['image_url']=base_url()."/assets/placeholder.svg";
            }
            //
            $active = ($i == 0) ? " active" : "";
            $str .= "<div class='carousel-item" . $active . "' >\n";
            $str .= "<div class='col-md-4'>\n";
            $str .= "<div class='card'>\n";
            $str .= "<div class='card-body'>\n";
            //
            $str .= "<div class='card-img' ><img src='" . $item['image_url'] . "' class='img-fluid' alt='...'></div>\n";
            $str .= "<div class='card-caption'>" . $title . "</div>\n";
            $str .= "<a href='".$target . $id . "' class='btn btn-primary mt-1'>En savoir plus</a>\n";
            $str .= "</div>\n"; //img-overlay                   
            $str .= "</div>\n"; // img
            $str .= "</div>\n"; // img    
            $str .= "</div>\n"; // img     
            $i++;
        }
        $str .= "</div>\n";

        return $str;
    }
}
