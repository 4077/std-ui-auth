var std_auth_restore = {

    rebind: function (data)
    {
        var context = $("#std_auth_restore");
        $(context).data(data);

        //

        var request_key_form = $(".request_key_form", context);

        $("input", request_key_form).rebind("keypress", function (e)
        {
            if (e.keyCode == 13)
            {
                std_auth_restore.request_key_form_submit(request_key_form);
            }
        });

        $(".submit_button", request_key_form).rebind("click", function ()
        {
            std_auth_restore.request_key_form_submit(request_key_form);
        });

        //

        var set_new_pass_form = $(".set_new_pass_form", context);

        $("input", set_new_pass_form).rebind("keypress", function (e)
        {
            if (e.keyCode == 13)
            {
                std_auth_restore.set_new_pass_form_submit(set_new_pass_form);
            }
        });

        $(".submit_button", set_new_pass_form).rebind("click", function ()
        {
            std_auth_restore.set_new_pass_form_submit(set_new_pass_form);
        });
    },

    request_key_form_submit: function (form)
    {
        var context = $("#std_auth_restore");
        var data = $(context).data();

        //

        $(".errors", context).html("").hide();

        request(data.request_key_path, {
            email: form.find("input[name='email']").val()
        });
    },

    set_new_pass_form_submit: function (form)
    {
        var context = $("#std_auth_restore");
        var data = $(context).data();

        //

        $(".errors", context).html("").hide();

        request(data.set_new_pass_path, {
            restore_key: form.find("input[name='restore_key']").val(),
            pass1: form.find("input[name='pass']").val(),
            pass2: form.find("input[name='pass2']").val()
        });
    },

    form_real_submit: function ()
    {
        $(".set_new_pass_form form").submit();
    },

    sent_info: function ()
    {
        var context = $("#std_auth_restore");

        //

        $(".request_key_form", context).hide();
        $(".request_key_sent_info", context).show();
        $(".request_key_sent_info .retry", context)
                .rebind("click", function ()
                        {
                            $(".request_key_form", context).show();
                            $(".request_key_sent_info", context).hide();
                        });
    },

    error: function (data)
    {
        var context = $("#std_auth_restore");

        //

        $('<div class="error">' + data.message + '</div>').appendTo(".errors", context);
        $(".errors", context).show();
    }
}