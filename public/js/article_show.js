$(document).ready(function() {
    $('.js-like-article').on('click', function(e) {
        e.preventDefault();
        let $link = $(e.currentTarget);

        $.ajax({
            method: 'POST',
            url: $link.attr('href')
        }).done(function(data) {
            $('.js-like-article-count').html(data.hearts);
            $link.toggleClass('fa-heart-o').toggleClass('fa-heart');
        })


    });
});
