var std_auth_change_pass = {

    form_rebind: function (data)
    {
        var context = $("#std_auth_change_pass");
        $(context).data(data);

        //

        $(".form input", context).rebind("keypress", function (e)
        {
            if (e.keyCode == 13)
                std_auth_change_pass.form_submit();
        });

        $(".submit_button", context).rebind("click", function ()
        {
            std_auth_change_pass.form_submit();
        });
    },

    form_submit: function ()
    {
        var context = $("#std_auth_change_pass");
        var form = $(".form", context);
        var data = $(context).data();

        //

        $(".errors", context).html("").hide();

        request(data.path, {
            current_pass: form.find("input[name='current_pass']").val(),
            pass1: form.find("input[name='pass']").val(),
            pass2: form.find("input[name='pass2']").val()
        });
    },

    form_real_submit: function ()
    {
        $("#std_auth_change_pass form").submit();
    },

    error: function (data)
    {
        var context = $("#std_auth_change_pass");

        //

        $('<div class="error">' + data.message + '</div>').appendTo(".errors", context);
        $(".errors", context).show();
    }
}