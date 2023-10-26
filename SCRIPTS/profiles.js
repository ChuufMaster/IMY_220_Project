import { apiURL } from "./configs.js";
import { apiCall, getKey, displayArticle } from "./helpers.js";

let profileJSON;

var edits = {
  birthday: false,
  job: false,
  relationship: false,
};

var picCheck = false;

$(() => {
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
        `<div class="mx-auto my-auto form-group">
                <img src="../../PROFILES/${image_name}" class="card-img-top rounded-circle" alt="Profile Picture" id="profilePic">
                <input name="picture[]" id="picture" type="file" class="form-control d-none" value="${job}" multiple="multiple">
                <button class="btn btn-primary picture">
                    <i class="fa-solid fa-pen"></i>
                </button>
          </div>
          <div class="card-body">
              <h5 class="card-title">${first_name} ${last_name}</h5>
          </div>
          <ul class="list-group list-group-flush">
              <li class="list-group-item"><strong>Contact Information:</strong>
                  ${email}
              </li>
  
              <li class="list-group-item"><strong>Birthday:</strong>
                  <span>${birthday}</span>
                  <input name="birthday" type="date" class="form-control d-none" value="${birthday}">
                  <button class="btn btn-primary editors">
                      <i class="fa-solid fa-pen"></i>
                  </button>
              </li>
              
              <li class="list-group-item"><strong>Relationship Status:</strong>
                  <span>${relationship}</span>
                  <input name="relationship" type="text" class="form-control d-none" value="${relationship}">
                  <button class="btn btn-primary editors">
                      <i class="fa-solid fa-pen"></i>
                  </button>
              </li>
  
              <li class="list-group-item"><strong>Job:</strong>
                  <span>${job}</span>
                  <input name="job" type="text" class="form-control d-none" value="${job}">
                  <button class="btn btn-primary editors">
                      <i class="fa-solid fa-pen"></i>
                  </button>
              </li>
  
          </ul>`
      );
    })
    .then(() => {
      $(".editors").on("click", function () {
        const parent = $(this).closest(".list-group-item");
        let valueInput = parent.find("input");
        valueInput.toggleClass("d-none");
        const value = valueInput.val();
        console.log(value);
        const valName = valueInput.attr("name");
        if (edits[valName]) {
          console.log(valName);
          edits[valName] = false;
          parent.find("span").html(value);
          apiCall({
            type: "update_info",
            api_key: getKey(),
            info_column: valName,
            info_value: value,
          }).then((data) => {
            console.log(data);
          });
        } else {
          edits[valName] = true;
        }

        parent.find("span").toggleClass("d-none");
        $(this).toggleClass("editors").toggleClass("editing");
      });

      $(".picture").on("click", function () {
        const parent = $(this).closest(".form-group");
        let valueInput = parent.find("input");
        valueInput.toggleClass("d-none");

        if (picCheck) {
          picCheck = false;

          
          const picture = $("#picture").get(0).files[0];
          
          const size = $("#picture").get(0).files[0].size / 1024 / 1024;
          if ((size > 0.5)) {
            console.log(size);
            alert('Image too large');
            return false;
          }
          var formData = new FormData();
          formData.append("picture", picture);
          formData.append("api_key", getKey());
          formData.append("type", "update_profile_pic");
          $.ajax({
            type: "POST",
            url: apiURL,
            data: formData,
            contentType: false,
            processData: false,
            cache: false,
            success: function (data) {
              console.log(data);
              $("#profilePic").attr("src", `../../PROFILES/${data.data}`);
            },
          });
        } else {
          picCheck = true;
        }
        //parent.find("span").toggleClass("d-none");
        //$(this).toggleClass("editors").toggleClass("editing");
      });
    })
    .then(
      apiCall({
        type: "get_MyArticles",
        api_key: getKey(),
      }).then((data) => {
        $("#myArticles").html(displayArticle(data["data"]));
      })
    );
});
