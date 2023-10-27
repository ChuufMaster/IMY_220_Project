import { apiCall, getKey, displayArticle, addList, addToList} from "./helpers.js";

const activity = apiCall(
    {
        type: "get_activity",
        api_key: getKey()
    }
)
.then((data) => {
    $("#activityFeed").html(displayArticle(data["data"]));
}).then(
    addToList()
)