jQuery(document).ready(function($) {
    // ボタンをクリックしたときのイベント
    $('#color-mode-toggle-button').on('click', function() {
        $('#color-mode-popup').toggleClass('active');
    });

    // カラーバリエーションを選択したときのイベント
    $('.color-variation').on('click', function() {
        var color = $(this).data('color');
        $('body').css('background-color', color);
        $('#color-mode-popup').removeClass('active');
    });
}); 