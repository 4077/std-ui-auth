<div class="{__NODE_ID__}" instance="{__INSTANCE__}">

    <div class="center_wrapper">
        <div class="center_container">

            <div class="errors_wrapper hidden">
                <div class="errors_container">
                    <div class="errors">
                        Неправильный логин или пароль
                    </div>
                </div>
            </div>

            <div class="form">
                <form action="{FORM_SUBMIT_ROUTE}" method="POST">
                    <input type="hidden" name="redirect" value="{REDIRECT}">
                    <div>
                        <input type="text" name="login" placeholder="Логин">
                    </div>
                    <div class="pass_input">
                        <input type="password" name="pass" placeholder="Пароль">
                    </div>

                    <div class="center_wrapper">
                        <div class="center_container">
                            <div class="submit_button" hover="hover">Войти</div>
                        </div>
                    </div>

                </form>
            </div>

            {*<div class="center_wrapper">*}
            {*<div class="center_container">*}
            {*{RESTORE_ACCESS_BUTTON}*}
            {*</div>*}
            {*</div>*}

        </div>
    </div>

</div>
