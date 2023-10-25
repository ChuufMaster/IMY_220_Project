import {
  apiCall,
  getKey,
  displayArticle,
  friendsList,
  viewProfile,
  takeToProfile,
} from "./helpers.js";

$(() => {
  const friends = apiCall({
    type: "get_friendsArticles",
    api_key: getKey(),
  })
    .then((data) => {
      $("#friendsArticles").html(displayArticle(data["data"]));
    })
    .then(() => {
      apiCall({
        type: "get_friends",
        api_key: getKey(),
      })
        .then((friends) => {
          $("#friendsList").html(friendsList(friends["data"]));
        })
        .then(() => {
          $("#add_friend").on("click", function () {
            //const friendName = $(this).closest("input").val();
            const friendName = $("#friendName").val();
            console.log(friendName);
            apiCall({
              type: "add_friend",
              friendName: friendName,
              api_key: getKey(),
            }).then((data) => {
              console.log(data);
            });
          });
          $(".friends").on("click", function (event) {
            takeToProfile(this);
          });
        });
    });
});
