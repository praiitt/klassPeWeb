function login_with_facebook() {
//console.log("HH");
var type = document.getElementById('type').checked;
    firebase
            .auth()
            .signInWithPopup(facebookProvider)
            .then((result) => {
                /** @type {firebase.auth.OAuthCredential} */
                var credential = result.credential;

                // The signed-in user info.
                var user = result.user;
                var userdata = user.providerData[0];
//                console.log(user);
//                console.log(credential);
                $.ajax({
                    url: 'web_facebook_login',
                    data: {displayName: userdata['displayName'], email: userdata['email'], password: userdata['password'], photoURL: userdata['photoURL'], type: type},
                    type: 'post',
                    dataType: 'json',

                    success: function (data) {
//                        alert(data);
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
                            alert("Something went wrong here");
                        }

                    },
                    error: function (error) {
                        alert("Error occured");
                    }
                })


                // This gives you a Facebook Access Token. You can use it to access the Facebook API.
                var accessToken = credential.accessToken;

                // ...
            })
            .catch((error) => {
                // Handle Errors here.
                var errorCode = error.code;
                var errorMessage = error.message;
                // The email of the user's account used.
                var email = error.email;
                // The firebase.auth.AuthCredential type that was used.
                var credential = error.credential;
                $('#facebook_msg_ms').html(error);
                console.log(error);
                alert(error);

                // setTimeout(function () {
                // $('#facebook_msg').fadeOut('slow');
                // }, 3000);
                // ...
            });

}