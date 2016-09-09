
var data = {
    inside:170,
    outside:135,
    door: function (stg, open) {
        open = open || false;
        $('.'+stg+'_left').animate({ left: ( open ? - this[stg] : 0 ) }, 1000);
        $('.'+stg+'_right').animate({right: ( open ? - this[stg] : 0 ) }, 1000,function () {
            if(open)
                $('._doors').addClass('_doors_opened');
            else
                $('._doors').removeClass('_doors_opened');

            $('.called').css('display','none');
        });
    }
};

$(document).on('click','._doors_opened',function () {
    if($(this).parent().hasClass('outside')){
        $('.outside').css('display','none');
        $('.inside').css('display','block');
        $('.inside_left').css('left',-data.inside);
        $('.inside_right').css('right',-data.inside);
    }else{
        $('.inside').css('display','none').children('._doors').addClass('_doors_opened');
        $('.outside').css('display','block');
        $('.outside_left').css('left',-data.outside);
        $('.outside_right').css('right',-data.outside);
    }
});

$(document).on('click','.call_panel',function () {
    $(this).children('.called').css('display','block');
    data.door('outside',true);
});

