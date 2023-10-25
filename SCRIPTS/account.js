import {
  apiCall,
  displayProfile,
  friendsList,
  viewProfile,
  getKey,
  takeToProfile,
} from "./helpers.js";

$(() => {
  $("#profile").html(displayProfile($.cookie(`account${getKey()}`)));
  const account = JSON.parse($.cookie(`account${getKey()}`));
  console.log(account);
  if (account["data"]["friends"]) {
    apiCall({
      type: "get_friends",
      api_key: account["data"][0].api_key,
    })
      .then((data) => {
        $("#friendsList").html(friendsList(data["data"]));
      })
      .then(() => {
        $(".friends").on("click", function (event) {
          takeToProfile(this);
        });
      })
    //  .then(() => $.cookie("account", "", { expires: -1 }));
  }
});
