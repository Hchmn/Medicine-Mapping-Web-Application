$(document).ready(function(){
  // scrolling
  var fixmeTop = $('.sidemenu').offset().top;

  $(window).scroll(function() {                  // assign scroll event listener

    var currentScroll = $(window).scrollTop(); // get current position

    if (currentScroll >= fixmeTop) {           // apply position: fixed if you
        $('.sidemenu').css({                      // scroll to that element or below it
            position: 'fixed',
            top: '0',
            left: '0'
        });

        $('#tempSpace').removeClass('d-none'); // prevent table for resizing
    } else {                                   // apply position: static
        $('.sidemenu').css({                      // if you scroll above it
            position: 'static'
        });
        $('.sidemenu').addClass('col-3');
        $('#tempSpace').addClass('d-none');
    }

  });
});
