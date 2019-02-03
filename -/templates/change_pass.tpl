<div id="std_auth_change_pass">

    <div class="center_wrapper">
        <div class="center_container">

            <div class="errors hidden"></div>

            <div class="form">
                <form action="/form_submit/" method="POST">

                    <input type="hidden" name="location" value="/cp/">

                    <table>
                        <tr>
                            <td class="caption">Текущий пароль</td>
                            <td><input type="password" name="current_pass"></td>
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
                            <div class="submit_button" hover="hover">Сменить</div>
                        </div>
                    </div>

                </form>
            </div>

        </div>
    </div>

</div>