<?php
include_once('./_common.php');
define('_MAIN_', true);
include_once(G5_PATH.'/head.php');
add_stylesheet('<link rel="stylesheet" href="'.G5_CSS_URL.'/toggle.css">', 0); 
?>


<div class="profill_wrap">
<div class="toggle_menu">
        <p class="toggletit">Running Community</p>
        <ul class="toggle_txt">
            <li class="tg_year">2022</li>
            <li>어쩌구 저쩌구</li>
            <li class="tg_year">2022</li>
            <li>어쩌구 저쩌구</li>
            <li>어쩌구 저쩌구</li>
            <li class="tg_year">2022</li>
            <li>어쩌구 저쩌구</li>
            <li>어쩌구 저쩌구</li>
        </ul>
    </div>
    <div class="toggle_menu2">
        <p class="toggletit">Running Community</p>
        <ul class="toggle_txt2">
            <li class="tg_year">2022</li>
            <li>어쩌구 저쩌구</li>
            <li class="tg_year">2022</li>
            <li>어쩌구 저쩌구</li>
            <li>어쩌구 저쩌구</li>
            <li class="tg_year">2022</li>
            <li>어쩌구 저쩌구</li>
            <li>어쩌구 저쩌구</li>
        </ul>
    </div>

    <script>
        $(function(){
            $('.toggle_menu').click(function(){
                $('.toggle_txt').slideToggle();
            })
            $('.toggle_menu2').click(function(){
                $('.toggle_txt2').slideToggle();
            })

        });
    </script>

</div>


<?
include_once(G5_PATH.'/tail.php');
?>