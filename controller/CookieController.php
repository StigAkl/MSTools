<?php
/**
 * Created by PhpStorm.
 * User: Stig
 * Date: 20.03.2017
 * Time: 18.22
 */

function getRankCookie($rank) {
    $cookie = $_COOKIE["RankCookie"];

    if($cookie == $rank)
        return "selected";
    else
        return "";
}
?>