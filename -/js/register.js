var std_auth_register = {

    form_rebind: function (data)
    {
        var context = $("#std_auth_register");
        $(context).data(data);

        //

        $(".form input", context).rebind("keypress", function (e)
        {
            if (e.keyCode == 13)
            {
                std_auth_register.form_submit();
            }
        });

        $(".submit_button", context).rebind("click", function ()
        {
            std_auth_register.form_submit();
        });
    },

    form_submit: function ()
    {
        var context = $("#std_auth_register");
        var form = $(".form", context);
        var data = $(context).data();

        //

        $(".errors", context).html("").hide();

        request(data.path, {
            email: form.find("input[name='email']").val(),
            pass1: form.find("input[name='pass']").val(),
            pass2: form.find("input[name='pass2']").val()
        });
    },

    form_real_submit: function ()
    {
        $("#std_auth_register form").submit();
    },

    error: function (data)
    {
        var context = $("#std_auth_register");

        //

        $('<div class="error">' + data.message + '</div>').appendTo(".errors", context);
        $(".errors", context).show();
    }
}