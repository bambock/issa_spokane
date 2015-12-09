// JavaScript File
var slideHeight = 175;
$(".bylaws").each(function() {
    var $this = $(this);
    var $wrap = $this.children(".wrap");
    var defHeight = $wrap.height();
    if (defHeight >= slideHeight) {
        var $readMore = $this.find(".read-more");
        $wrap.css("height", slideHeight + "px");
        $readMore.append("<a href='#'>Click to Read More</a>");
        $readMore.children("a").bind("click", function(event) {
            var curHeight = $wrap.height();
            if (curHeight == slideHeight) {
                $wrap.animate({
                    height: defHeight
                }, "normal");
                $(this).text("Close");
                $wrap.children(".gradient").fadeOut();
            } else {
                $wrap.animate({
                    height: slideHeight
                }, "normal");
                $(this).text("Click to Read More");
                $wrap.children(".gradient").fadeIn();
            }
            return false;
        });
    }
});

var validateEmail = function(elementValue) {
    var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    return emailPattern.test(elementValue);
}

$('#email').keyup(function() {

    var value = $(this).val();
    var valid = validateEmail(value);

    if (!valid) {
        $(this).css('color', 'red');
    } else {
        $(this).css('color', '#000');
    }
});

$(document).ready(function() {

    // process the form
    $('form').submit(function(event) {

        // get the form data
        // there are many ways to get this data using jQuery (you can use the class or id also)
        var form_data = {
            'name'              : $('input[name=name]').val(),
            'email'             : $('input[name=email]').val(),
            'subject'           : $('select[name=subject]').val(),
            'message'           : $('textarea[name=message]').val()
        };
        console.log(form_data)
        // process the form
        $.ajax({
            type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url         : 'm.php', // the url where we want to POST
            data        : form_data, // our data object
            dataType    : 'json', // what type of data do we expect back from the server
            encode          : true
        })
            // using the done promise callback
            .done(function(data) {

                // log data to the console so we can see
                console.log(data); 

                // here we will handle errors and validation messages
            });

        // stop the form from submitting the normal way and refreshing the page
        event.preventDefault();
    });

});
