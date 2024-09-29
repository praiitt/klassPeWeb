function login_with_google() {
    var type = document.getElementById('type').checked;
    firebase.auth()
            .signInWithPopup(googleProvider)
            .then((result) => {
                /** @type {firebase.auth.OAuthCredential} */
                var credential = result.credential;
//                console.log(credential);
                // This gives you a Google Access Token. You can use it to access the Google API.
                var token = credential.accessToken;
                // The signed-in user info.
                var user = result.user;
                var userdata = user.providerData[0];
                $(document).ajaxStart(function () {
                    $("#loading").show();
                });

                $(document).ajaxComplete(function () {
                    $("#loading").hide();
                });
                $.ajax({
                    url: "Login_with_google",
                    type: "post",
                    dataType: "json",
                    data: {displayName: userdata['displayName'], email: userdata['email'], password: userdata['password'], uid: userdata['uid'], type: type},
                    success: function (data) {
                        console.log(data);
                        if (data.status == true) {
                            alert("Sucessfully logged");
                            if (data.type == 'tutor') {
                                if (data.tutor == '1') {
                                    location.reload();
                                } else {
                                    window.location.href = 'Tutor_registration';
                                }

                            } else {
                                location.reload();
                            }
                        } else {
//                            alert("Something went wrong here");
                        }

                    },
                    error: function (error) {
                        alert("Error occured");
                    }
                })
                // ...
            }).catch((error) => {
        // Handle Errors here.
        var errorCode = error.code;
        var errorMessage = error.message;
        // The email of the user's account used.
        var email = error.email;
        // The firebase.auth.AuthCredential type that was used.
        var credential = error.credential;
        console.log(error)
        // ...
    });

}