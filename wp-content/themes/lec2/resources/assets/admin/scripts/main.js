var more_application = function() {

    return {
        /**
         * Button id
         */
        button_id : "#btn_more_application",
        applied_content : "#list_applications_content",
        icon_load_more : ".btn-loadmore-icon",
        send_test_email : ".btn-send-test-email",

        /***
         * Init actions of bar's detail
         */
        init : function($){
            if($(more_application.button_id).length > 0){

                $(document).on("click",more_application.button_id, function () {
                    var ajaxUrl = $(this).attr('data-url'),
                        nextPage = $(this).attr('data-next-page'),
                        query = $(this).attr('data-query');

                    $(more_application.icon_load_more).removeClass('hidden');
                    $.ajax({
                        url : ajaxUrl,
                        data : {
                            "action" : "list_applications",
                            "next_page" : nextPage,
                            "query" : query
                        }
                    }).done(function (res) {


                       $.each( res.data.data,function ($key, $value) {
                            $(more_application.applied_content).append($value.custom_data.html);
                        });

                        $(more_application.button_id).attr('data-next-page',res.data.next_page);
                        if(res.data.show_load_more == false){
                            $(more_application.button_id).addClass('hidden');
                        }

                        $(more_application.icon_load_more).addClass('hidden');
                    });

                });
            }

            if($(more_application.send_test_email).length > 0){
                $(document).on("click",more_application.send_test_email, function () {
                    var $this = $(this);
                    $this.parent().find('.spinner').addClass('is-active');
                    $this.attr('disabled',true);

                    var toEmailID = $(this).attr('data-to-email'),
                        subjectID = $(this).attr('data-subject'),
                        messageID = $(this).attr('data-message'),
                        resultID = $(this).attr('data-result'),
                        ajaxUrl = $(this).attr('data-url');

                    var toEmail = $(toEmailID).val(),
                        subject = $(subjectID).val(),
                        message = $(messageID).val();

                    $.ajax({
                        url : ajaxUrl,
                        method: "POST",
                        data : {
                            "action" : "send_test_email",
                            "to_email" :toEmail,
                            "subject" : subject,
                            "message" : message
                        }
                    }).done(function (res) {
                        var html = "<p>"+res.message+"</p>";
                        $.each(res.debug_message,function (k, val) {
                            for(var i=0 ; i< val.length ; i ++){
                                html  += "<p>"+val[i]+"</p>";
                            }
                        });

                        $(resultID).html(html);

                        $(resultID).removeClass('error');
                        $(resultID).removeClass('updated');
                        $(resultID).removeClass('notice-success');
                        $(resultID).removeClass('notice');
                        $(resultID).addClass(res.message_class);

                        $this.parent().find('.spinner').removeClass('is-active');
                        $this.removeAttr('disabled');

                    });
                });
            }
        }
    }
}();


jQuery(document).ready(function($) {
    more_application.init($);
});