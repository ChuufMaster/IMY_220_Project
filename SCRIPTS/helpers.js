/*export const config = () => {
  return new Promise((resolve, reject) => {
    $.getJSON("config.json", (json) => {
      resolve(json);
    });
  });
};*/

import { apiURL } from "./configs.js";

export const apiCall = (data) => {
  return new Promise((resolve, reject) => {
    $.ajax({
      url: apiURL,
      type: "POST",
      data: data,
    }).then((data) => {
      resolve(data);
    });
  });
};
