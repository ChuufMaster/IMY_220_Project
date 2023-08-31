$(document).ready(() => {
  $("#login_submit").click(() => {
    if (document.getElementById('login_form').checkValidity()) $("#login_form").submit();
  });

  $("#add_article").click(() => {
    if (document.getElementById('add_article_form').checkValidity())
      $("#add_article_form").submit();
  });
});
