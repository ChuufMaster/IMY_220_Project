import { apiCall } from "./helpers.js";

$(() => {
  $("#login_submit").on("click", function () {
    const email = $("#email").val();
    const password = $("#password").val();

    $.ajax({
      type: "POST",
      url: "./PHP/API.php",
      data: {
        type: "login",
        email: email,
        password: password,
      },
      success: function (data) {
        //console.log(data);
        window.location.href = `./PHP/PAGES/activity.php?api_key=${data.data.api_key}`;
      },
      error: function (errorMessage) {
        alert(errorMessage.responseJSON.data.message);
      },
    });
  });

  $("#sign_up").on("click", function () {
    if (
      $("#first_name_div").hasClass("sign-up") &&
      $("#last_name_div").hasClass("sign-up")
    ) {
      $("#first_name_div").removeClass("sign-up");
      $("#last_name_div").removeClass("sign-up");
      $("#first_name").attr("required", true);
      $("#last_name").attr("required", true);
      $("#type").val("sign_up");
    } else {
      if (document.getElementById("login_form").checkValidity()) {
        const email = $("#email").val();
        const password = $("#password").val();
        const first_name = $("#first_name").val();
        const last_name = $("#last_name").val();

        console.log(email, password, first_name, last_name);
        $.ajax({
          type: "POST",
          url: "./PHP/API.php",
          data: {
            type: "sign_up",
            email: email,
            password: password,
            first_name: first_name,
            last_name: last_name,
          },
          success: function (data) {
            console.log(data);
            window.location.href = `./PHP/PAGES/activity.php?api_key=${data.data.api_key}`;
          },
          error: function (errorMessage) {
            alert(errorMessage.responseJSON.data.message);
          },
        });
      }
    }
  });
});
