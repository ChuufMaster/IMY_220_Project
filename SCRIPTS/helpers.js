import { apiURL } from "./configs.js";

export const apiCall = (data) => {
  return new Promise((resolve, reject) => {
    $.ajax({
      url: apiURL,
      type: "POST",
      data: data,
    }).done((response) => {
      resolve(response);
    });
  });
};

export const getKey = () => {
  const query = window.location.search;
  const params = Qs.parse(query, { ignoreQueryPrefix: true });
  const apiKey = params.api_key;
  return apiKey;
};

export const displayArticle = (data) => {
  console.log(data);
  let output = ` `;
  data.forEach((article) => {
    const { image_name, title, author, description, article_id, body, date } =
      article;
    output += `
        <div class="col-6">
        <div class="p-1 card h-100 fancy">
        <span class="top-key"></span>
        <span class="text">
                <div class="row g-0">
                    <div class="col-4">
                        <div class="image-container">
                            <img src="../../gallery/${image_name}" alt="Article Image" class="img-fluid">
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="card-body">
                            <h5 class="card-title">${title}</h5>
                            <h6 class="card-subtitle"> - ${author}</h6>
                            <p class="card-text">${description}</p>
                            <a class="fancy" data-bs-toggle="collapse" href="#body${article_id}" role="button" aria-expand="false" aria-controls="body${article_id}">
                                <span class="top-key"></span>
                                <span class="text">FULL ARTICLE</span>
                                <span class="bottom-key-1"></span>
                                <span class="bottom-key-2"></span>
                            </a>
                            <div class="collapse" id="body${article_id}">
                                <div class="card card-body">
                                    ${body}
                                </div>
                            </div>
                            <p class="card-text"><small class="text-muted">${date}</small></p>
                        </div>
                    </div>
                </div>
            </span>
            <span class="bottom-key-1"></span>
            <span class="bottom-key-2"></span>
        </div>
    </div>
        `;
  });
  return output;
};

export const friendsList = (data) => {
    let output = ` `;
    console.log(data);
    data.forEach((friend) => {
      const { first_name, last_name, job, birthday, email } = friend;
      output += `
              <a href="#" class="list-group-item list-group-item-action">
              <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1">${first_name} ${last_name}</h5>
                <small>${birthday}</small>
              </div>
              <p class="mb-1">${job}</p>
              <small>${email}</small>
            </a>
              `;
    });
    return output;
  };