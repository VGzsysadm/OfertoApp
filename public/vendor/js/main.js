/*!
 * Author: VFoxtTroT)
 * Copyright 2019 Sysadm.es
 * MIT License (https://github.com/VGzsysadm)
 */
$(document).ready(function() {
    $(document).scroll(function() {
        var y = $(this).scrollTop();
        var x = $("#main-navigator").position();
        if (y > x.top) {
            $('nav').fadeIn().css({ "position": "fixed", "top": "0", "z-index": "1" });
        } else {
            $('nav').css({ "position": "static" });
        }
    });
});
// Fixed navigation
$(document).ready(function() {
    $('.sidenav').sidenav();
});
// Floating button
$(document).ready(function() {
    $('.fixed-action-btn').floatingActionButton();
});
// Modal
$(document).ready(function() {
    $('.modal').modal();
});
// Preloader
document.addEventListener("DOMContentLoaded", function() {
    $('.preloader-background').delay(700).fadeOut('slow');
    $('.preloader-wrapper')
        .delay(500)
        .fadeOut();
});
// Modal tabs
$(document).ready(function() {
    $('.tabs').tabs();
});
// Dropdown
$(document).ready(function() {
    $('.dropdown-trigger').dropdown();
});
// Selector
document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('select');
    var instances = M.FormSelect.init(elems, Option);
});