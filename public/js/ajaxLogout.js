$('#btn_logout').on('click', function () {
    let SITEURL = window.location.origin;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        url: '/logout',
        type: 'POST',
        cache: false,
        success: function (data) {
            window.location.href = SITEURL;
        },
        error: function () {
            alert('Something went wrong!');
        },
    });
});
