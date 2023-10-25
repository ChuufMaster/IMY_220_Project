import { apiCall, getKey, displayArticle } from "./helpers.js";
import { apiURL } from "./configs.js";

$(() => {
  let tags ={tags: []};
  $("#addTag").on("click", () => {
    var tag = $("#tagInput").val();
    if (tag.trim() !== "") {
      tags.tags.push(tag);
      $("#tagList").append(`<li class="list-group-item">${tag}</li>`);
      $("#tagInput").val("");
      console.log(tags);
    }
  });

  $("#add_article").on("click", () => {
    event.preventDefault();
    const title = $("#title").val().trim();
    const author = $("#author").val().trim();
    const description = $("#description").val().trim();
    const body = $("#body").val().trim();
    const date = $("#date").val();

    const image = $("#image").get(0).files[0];
    var formData = new FormData();
    formData.append("title", title);
    formData.append("author", author);
    formData.append("description", description);
    formData.append("body", body);
    formData.append("date", date);
    formData.append("image", image);
    formData.append("type", "add_article");
    formData.append("api_key", getKey());
    formData.append("tags", JSON.stringify(tags));
    $.ajax({
      type: "POST",
      url: apiURL,
      data: formData,
      contentType: false,
      processData: false,
      cache: false,
      success: function (response) {
        console.log(response);
      },
    });

    
  });
});
