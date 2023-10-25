import {
  apiCall,
  displayProfile,
  friendsList,
  viewProfile,
  getKey,
  takeToProfile,
} from "./helpers.js";

$(() => {
  $("#profile").html(displayProfile($.cookie("account")));
  const account = JSON.parse($.cookie("account"));
  console.log(account);
  if (account["data"]["friends"]) {
    apiCall({
      type: "get_friends",
      api_key: account["data"][0].api_key,
    })
      .then((data) => $("#friendsList").html(friendsList(data["data"])))
      .then(() => {
        $(".friends").on("click", function (event) {
          takeToProfile(this);
        });
      });
  }
});
