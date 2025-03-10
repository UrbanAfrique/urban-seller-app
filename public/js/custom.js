$(document).ready(function () {
    $('.payout_type').change(function(){
        var payout_type = $(this).val();
        $('.payout-form').slideUp();
        $('.payout-form input').removeAttr('required');
        $('.payout-form input').prop('disabled', true);
        $('.payout-form.'+payout_type).slideDown();
        $('.payout-form.'+payout_type+' input').prop('required',true);
        $('.payout-form.'+payout_type+' input').prop('disabled',false);
    })
    $('.zoom-gallery').magnificPopup({
        delegate: 'a',
        type: 'image',
        closeOnContentClick: false,
        closeBtnInside: false,
        mainClass: 'mfp-with-zoom mfp-img-mobile',
        image: {
            verticalFit: true,
            titleSrc: function (item) {
                return item.el.attr('title') + ' &middot; <a class="image-source-link" href="' + item.el.attr('data-source') + '" target="_blank">image source</a>';
            }
        },
        gallery: {
            enabled: true
        },
        zoom: {
            enabled: true,
            duration: 300, // don't foget to change the duration also in CSS
            opener: function (element) {
                return element.find('img');
            }
        }

    });

    $('#wholesale').change(function(){
        $('.wholesale_fields').toggle();
        $('.hs_field').prop('disabled', !$(this).is(':checked'))
    })
    
});

function showError(msg) {
    $.toast({
        heading: 'Error', text: msg, position: 'top-right', icon: 'error'
    })
}

function showSuccess(msg) {
    $.toast({
        heading: 'Success', text: msg, position: 'top-right', icon: 'success'
    })
}
