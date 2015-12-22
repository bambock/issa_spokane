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


$(document).ready(function() {

    var validateEmail = function(elementValue) {
        var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
        return emailPattern.test(elementValue);
    }
    $("#status").hide();
    
    $('#email').keyup(function() {
    
        var value = $(this).val();
        var valid = validateEmail(value);
    
        if (!valid) {
            $(this).css('color', 'red');
        } else {
            $(this).css('color', '#000');
        }
    });


    $('.contact.sponsors').click(function() {
        $("#subject").val("Sponsorship");
    });
    
    $('.contact.director').click(function() { 
        $("#subject").val("Membership Information");
    });
    
    $('.contact.general').click(function() {
        $("#subject").val("General Questions");
    });
    
    // process the form
    $('form').submit(function(event) {

        // get the form data
        // there are many ways to get this data using jQuery (you can use the class or id also)
        /*var form_data = {
            'name': $('input[name=name]').val(),
            'email': $('input[name=email]').val(),
            'subject': $('select[name=subject]').val(),
            'message': $('textarea[name=message]').val(),
            'g-recaptcha-response': grecaptcha.getResponse()
        };*/
        
        //console.dir(form_data);
        var form_data = $('form').serialize();
        // console.log(form_data)
        //console.dir(fd)
        $("#status").show();
        
        // process the form
        $.ajax({
            url: 'm.php',
            type: 'POST',       // define the type of HTTP verb we want to use (POST for our form)
            data: form_data,    // our data object
            dataType: 'json',   // what type of data do we expect back from the server
            encode: true
        })
        .done(function(data, textStatus, jqXHR) {
            if(data.message == "Message Sent!") {
                $("#name").val("");
                $("#email").val("");
                $("#subject").val("");
                $("#message").val("");
                $("#status").css('color', 'green').html(data.message + " <i class='fa fa-check-square'></i>");
                grecaptcha.reset();    
            } else {
                $("#status").css('color', 'red').html(data.message + " <i class='fa fa-chain-broken'></i>");
                grecaptcha.reset();
            }
        })
        .fail(function(jqXHR, textStatus, errorThrown) {
            $("#status").css('color', 'red').html(errorThrown + " <i class='fa fa-chain-broken'></i>");
            grecaptcha.reset();
            
        })
        .always(function() {
            $("#status").fadeOut(5000);
        });

        // stop the form from submitting the normal way and refreshing the page
        event.preventDefault();
    });

});
