<?php
function myPrint_r($value) {
    if(MODE == 'dev') :
        echo '<pre>';
            print_r($value);
        echo '</pre>';
    endif;
}