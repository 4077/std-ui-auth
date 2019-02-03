<div id="std_auth_restore">

    <div class="center_wrapper">
        <div class="center_container">

            <div class="errors hidden"></div>

            <!-- request_key_outdated -->
            <div class="errors">
                <div class="error">Код восстановления просрочен, <span class="retry" hover="hover" route="/restore/">запросите новый</span></div>
            </div>
            <!-- / -->

            <!-- request_key_wrong -->
            <div class="errors">
                <div class="error">Неверный ключ восстановления, <span class="retry" hover="hover" route="/restore/">запросите новый</span></div>
            </div>
            <!-- / -->

            <!-- request_key_form -->
            <div class="request_key_form">

                <div class="instruction">Укажите e-mail, на который зарегистрирован аккаунт</div>
                <div class="instruction mt5">На него будет выслана ссылка для восстановления</div>
                <input type="text" name="email">

                <div class="center_wrapper">
                    <div class="center_container">
                        <div class="submit_button" hover="hover">Выслать</div>
                    </div>
                </div>

            </div>

            <div class="request_key_sent_info hidden tac">
                <div>Письмо отправлено.</div>
                <div class="mt5">Если в течени нескольких минут Вы его не получили, попробуйте <span class="retry" hover="hover">еще раз</span>.</div>
            </div>
            <!-- / -->

            <!-- set_new_pass_form -->
            <div class="set_new_pass_form">
                <form action="/form_submit/" method="POST">

                    <input type="hidden" name="location" value="/cp/">
                    <input type="hidden" name="restore_key" value="{RESTORE_KEY}">
                    <input type="text" name="email" value="{EMAIL}" class="hidden">

                    <table>
                        <tr>
                            <td class="caption">e-mail</td>
                            <td>{set_new_pass_form.EMAIL}</td>
                        </tr>
                        <tr>
                            <td class="caption">Новый пароль</td>
                            <td><input type="password" name="pass"></td>
                        </tr>
                        <tr>
                            <td class="caption">Новый пароль еще раз</td>
                            <td><input type="password" name="pass2"></td>
                        </tr>
                    </table>

                    <div class="center_wrapper">
                        <div class="center_container">
                            <div class="submit_button" hover="hover">Сменить пароль</div>
                        </div>
                    </div>

                </form>
            </div>
            <!-- / -->

        </div>
    </div>

</div>