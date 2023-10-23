import { apiCall, getKey, displayArticle } from "./helpers.js";

let profileJSON;

const profile = apiCall({
  type: "get_profile",
  api_key: getKey(),
})
  .then((data) => {
    console.log(data);
    profileJSON = data.data[0];
    const {
      first_name,
      last_name,
      birthday,
      email,
      job,
      relationship,
      image_name,
    } = data["data"][0];
    $("#profile").html(
      `<div class="mx-auto my-auto">
        <img src="../../gallery/${image_name}" class="card-img-top rounded-circle" alt="Profile Picture">
    </div>
    <div class="card-body">
        <h5 class="card-title">${first_name} ${last_name}</h5>
    </div>
    <ul class="list-group list-group-flush">
        <li class="list-group-item"><strong>Birthday:</strong>${birthday}</li>
        <li class="list-group-item"><strong>Contact Information:</strong>${email}</li>
        <li class="list-group-item"><strong>Relationship Status:</strong>${relationship}</li>
        <li class="list-group-item"><strong>Job:</strong>${job}</li>
    </ul>`
    );
  })
  .then(
    apiCall({
      type: "get_MyArticles",
      api_key: getKey(),
    }).then((data) => {
      $("#myArticles").html(displayArticle(data["data"]));
    })
  );
