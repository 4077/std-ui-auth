// head {
var __nodeId__ = "std_auth__login";
var __nodeNs__ = "std_auth";
// }

(function (__nodeNs__, __nodeId__) {
    $.widget(__nodeNs__ + "." + __nodeId__, {
        options: {},

        _create: function () {
            this.bind();
        },

        _setOption: function (key, value) {
            $.Widget.prototype._setOption.apply(this, arguments);
        },

        bind: function () {
            var widget = this;

            widget.colorChanging();

            $(".form", widget.element).rebind("keypress", function (e) {
                if (e.keyCode == 13) {
                    widget.formSubmit();
                }
            });

            $(".submit_button", widget.element).rebind("click", function () {
                widget.formSubmit();
            });
        },

        formSubmit: function () {
            var widget = this;

            var form = $(".form", widget.element);

            $(".errors_wrapper", widget.element).hide();
            $(".errors", widget.element).html("");

            request(widget.options.paths.login, {
                login: form.find("input[name='login']").val(),
                pass:  form.find("input[name='pass']").val()
            });
        },

        formRealSubmit: function () {
            var widget = this;

            $("form", widget.element).submit();
        },

        addError: function (message) {
            var widget = this;

            $('<div class="error">' + message + '</div>').appendTo(".errors", widget.element);
            $(".errors_wrapper", widget.element).show();
        },

        colorChanging: function () {
            var widget = this;

            var colors = widget.options.bodyColors;
            var colorsCount = colors.length;
            var colorNumber = 0;

            $("body").css({"background-color": colors[colorNumber]});

            setInterval(function () {
                colorNumber++;

                $("body").css({"background-color": colors[colorNumber]});

                if (colorNumber >= colorsCount - 1) {
                    colorNumber = 0;
                }

            }, 20000);
        }
    });
})(__nodeNs__, __nodeId__);
