<?php

namespace Sharenjoy\Cmsharenjoy\Service\Formaker\Forms;

use Theme;

class YoutubeForm extends FormAbstract implements FormInterface
{
    public function make(Array $data)
    {
        if (isset($data['value']) && $data['value'] != null) {
            $data['value'] = 'https://youtu.be/'.$data['value'];
        }
        
        $dataReal = $data;
        $data['name'] = $data['name'].'_fake';

        $attributes = $this->attributes($data);
        $attributesReal = $this->attributes($dataReal);
        
        $form = '<input type="text"'.$attributes.' id="youtube_field"><input type="hidden"'.$attributesReal.' id="youtube_field_real"><div id="youtube_img" style="display:none; margin-top: 3px"><img src="" width="120" height="90" class="img-thumbnail"></div>';

        Theme::asset()->writeScript('script', '
            $(function() {
                $("#youtube_field").change(function() {
                    var imgPath = $(this).val();
                    var imgId = imgPath.replace("https://www.youtube.com/watch?v=", "").replace("https://youtu.be/", "");
                    $("#youtube_field_real").val(imgId);
                    var youtubeImg = $("#youtube_img");
                    youtubeImg.find("img").attr("src", "http://img.youtube.com/vi/"+imgId+"/3.jpg");
                    youtubeImg.css("display", "block").attr("class", "animated fadeIn");
                });
                $(document).ready(function() {
                    var imgPath = $("#youtube_field").val();
                    if (imgPath != "") {
                        var imgId = imgPath.replace("https://www.youtube.com/watch?v=", "").replace("https://youtu.be/", "");
                        $("#youtube_field_real").val(imgId);
                        var youtubeImg = $("#youtube_img");
                        youtubeImg.find("img").attr("src", "http://img.youtube.com/vi/"+imgId+"/3.jpg");
                        youtubeImg.css("display", "block").attr("class", "animated fadeIn");
                    }
                });
            });
        ');

        return $form;
    }

}