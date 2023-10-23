import { apiCall, getKey, displayArticle } from "./helpers.js";

const activity = apiCall(
    {
        type: "get_activity"
    }
)
.then((data) => {
    $("#activityFeed").html(displayArticle(data["data"]));
})