jQuery(function ($) {
    'use strict';

    $('#stats-form select').on('change', function(e) {
        location.href = WWW + $(this).val();
    });

    $('.back').on('click', function(e) {
        e.preventDefault();

        window.history.back();
    });
});