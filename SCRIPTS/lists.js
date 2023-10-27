import { getLists, apiCall, getKey } from "./helpers.js";

$(() => {
  apiCall({
    type: "get_lists",
    api_key: getKey(),
  }).then((data) => {
    //console.log(getLists(data));
    $("#lists").html(getLists(data));
  });
});
