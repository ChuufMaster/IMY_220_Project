$(document).ready(() => {
  $("#login_submit").click(() => {
    $("#first_name").removeAttr("required");
    $("#last_name").removeAttr("required");
    $("#type").val("login");

    if (document.getElementById("login_form").checkValidity())
      $("#login_form").submit();
  });

  /*$("#add_article").click(() => {
    if (document.getElementById("add_article_form").checkValidity())
      $("#add_article_form").submit();
  });*/

  $("#sign_up").click(() => {
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
      if (document.getElementById("login_form").checkValidity())
        $("#login_form").submit();
    }
  });
});
