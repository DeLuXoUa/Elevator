var data = {
    floor: null,
    direction: null,
    stopped: null,
    inside: 170,
    outside: 135,
    calls_stack:[],
    door: function (stg, open) {
        open = open || false;
        $('.' + stg + '_left').animate({left: ( open ? -this[stg] : 0 )}, 1000);
        $('.' + stg + '_right').animate({right: ( open ? -this[stg] : 0 )}, 1000, function () {
            if (open)
                $('._doors').addClass('_doors_opened');
            else {
                if ($('._doors').hasClass('_doors_opened')) {
                    $('.inside').effect("shake", {direction: "up", times: 20, distance: 3}, 500);
                }
                $('._doors').removeClass('_doors_opened');
            }


        });
    },
    call_ajax: function (post) {
        $.ajax({
            url: '/',
            method: "POST",
            data: post,
            dataType: "json",
            success: function (resp) {
                if (resp.ok) {
                    if (resp.set_data) {
                        data['floor'] = resp.set_data.floor;
                        data['direction'] = resp.set_data.direction;
                        data['stopped'] = resp.set_data.stopped;
                        for(flr in resp.set_data.calls_stack){
                            data.calls_stack[flr] = resp.set_data.calls_stack[flr];
                            $('.in_called_'+resp.set_data.calls_stack[flr]).addClass('ylw_crl');
                        }
                    }

                }
            },
            error: function (data) {

            }
        });
    },
    check_floor: function () {

        $('.display_text').text(data.floor);

        if ($('.setting').attr('data-position')=='outside') {
            if (data.floor == $('.ex_floor').attr('data-floor') && data.stopped) {
                data.door('outside', true);
                $('.out_called').removeClass('bg_ylw');
            }else {
                data.door('outside', false);
            }
        } else {
            if(data.direction === null){
                $('.arrow_up').css('display','none');
                $('.arrow_down').css('display','none');
            }else if( data.direction ){
                $('.arrow_up').css('display','block');
                $('.arrow_down').css('display','none');
            }
            else{
                $('.arrow_down').css('display','block');
                $('.arrow_up').css('display','none');

            }
            if(data.stopped){
                $('.ex_floor').attr('data-floor',data.floor).text(data.floor);
                data.door('inside', true);
            }else {
                data.door('inside', false);
            }
        }
        if(data.stopped){
            $('.in_called_'+data.floor).removeClass('ylw_crl');
        }
    }
};


$(document).ready(function () {

    $(document).on('click', '._doors_opened', function () {
        if ($(this).parent().hasClass('outside')) {
            $('.outside').css('display', 'none');
            $('.inside').css('display', 'block');
            $('.inside_left').css('left', -data.inside);
            $('.inside_right').css('right', -data.inside);
            $('.setting').attr('data-position', 'inside');
        } else {
            $('.inside').css('display', 'none').children('._doors').addClass('_doors_opened');
            $('.outside').css('display', 'block');
            $('.outside_left').css('left', -data.outside);
            $('.outside_right').css('right', -data.outside);
            $('.setting').attr('data-position', 'outside');
        }
    });

    $(document).on('click', '.call_panel', function () {
        $(this).children('.called').addClass('bg_ylw');
        if (data.floor == $('.ex_floor').attr('data-floor') && data.stopped)
            data.door('outside', true);
        data.call_ajax({method: 'to_floor', value: $('.ex_floor').attr('data-floor')});
    });

    $(document).on('click', '._in_call', function () {
        if ($(this).attr('data-floor') === '-') {
            document.getElementById('ply').play();
            return;
        }
        $(this).addClass('ylw_crl');
        if(data.floor == $(this).attr('data-floor') && data.stopped){
            setTimeout(function () {
                $(this).removeClass('ylw_crl');
            }, 1000);
        }
        // data.door('inside', false);
        data.call_ajax({method: 'to_floor', value: $(this).attr('data-floor')});
        // else {
        //     data.door('inside', false);
        // }
    });


    setInterval(function () {
        data.call_ajax({method: 'get_info'});
        data.check_floor();
    }, 1000);

    setInterval(function () {
        if(data.calls_stack.length)
            data.call_ajax({method: 'start'});
    }, 5000);
});

