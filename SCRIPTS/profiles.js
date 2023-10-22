import { apiCall } from "./helpers.js";

const activity = apiCall({
  type: "get_activity",
}).then((data) => {
  console.log(data); 
});

//console.log(activity);
