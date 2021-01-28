jQuery(document).ready(function () {
    var myLogin = {
        // main form
        mainform: $(this).find('form'),
        // init function 
        init: function () {
            var myButton = this.mainform.find('#button'),
                myLoader = this.mainform.find('#loader');

            myButton.on('click', function (e) {
                e.preventDefault();
                if (myLogin.validate.call()) {
                    myLoader.fadeIn(50);
                    myButton.attr('disabled', true);
                    myLogin.login.call();
                }
            })
        },
        // validate
        validate: function () {
            var myData = myLogin.mainform,
                myUsername = myData.find('#username').val(),
                myPassword = myData.find('#password').val();
            if (myUsername === '' || myPassword === '') {
                return false;
            }
            return true;
        },
        // select text
        selectText: function (div) {
            $(div).focus().select();
        },
        // send
        login: function () {
            var myData = myLogin.mainform,
                myAction = myData.attr('action'),
                myButton = myData.find('#button'),
                myUsername = myData.find('#username'),
                myPassword = myData.find('#password'),
                myLoader = myData.find('#loader');
            $.ajax({
                type: 'post',
                url: myAction,
                data: {
                    username: myUsername.val(),
                    password: myPassword.val(),
                },
                dataType: 'json',
                beforeSend: function () {
                },
                success: function (response) {
                    myLoader.fadeOut(50);
                    myButton.attr('disabled', false);
                    myUsername.val('').focus();
                    myPassword.val('');
                    if (response.success === true) {
                        window.location = response.redir;
                    }
                },
                error: function (data) {
                    alert('something goes wrong... reloading');
                    window.location.reload();
                }
            });
        }
    };
    // run
    myLogin.init();
});