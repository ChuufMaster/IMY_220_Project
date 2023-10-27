import { apiURL } from "./configs.js";

export const apiCall = (data) => {
  return new Promise((resolve, reject) => {
    $.ajax({
      url: apiURL,
      type: "POST",
      data: JSON.stringify(data),
      //  contentType: "application/json; charset=utf-8",
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
  //const lists = addList();
  //addList().then((lists) => {
  //console.log(lists);
  //var lister = " ";
  /*data.data.forEach((list) => {
    lister += `
         <li>
           <a class="dropdown-item" href="#">${list.name}</a>
         </li>`;
  });
  const lists = `
          <div class="btn-group">
            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              ADD TO LIST
            </button>
            <ul class="dropdown-menu">
             ${lister}
            </ul>
          </div>
        `;*/
  //console.log(lister);
  //lister = lists;

  data.forEach((article) => {
    const {
      image_name,
      title,
      author,
      description,
      article_id,
      body,
      date,
      tags,
    } = article;
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
                                <p class="card-text"><small class="text-muted">${
                                  '<a class="link-primary" href="#"">#' +
                                  tags.tags.join(
                                    '</a>, <a class="link-primary" href="#">#'
                                  ) +
                                  "</a>"
                                }</small></p>
                                <input class="articleID" type="hidden" value="${article_id}">
                                ${(function () {
                                  var lister = "";
                                  article.list.lists.forEach((list) => {
                                    lister += `
                                         <li>
                                           <a class="dropdown-item" href="#">${list.name}</a>
                                           <input type="hidden" value="${list.name}">
                                         </li>`;
                                  });
                                  const lists = `
                                          <div class="btn-group">
                                            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                              ADD TO LIST
                                            </button>
                                            <ul class="dropdown-menu">
                                             ${lister}
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                              <a class="dropdown-item" href="#">Add List</a>
                                              <input type="hidden" value="addList">
                                            </li>
                                            </ul>
                                          </div>
                                        `;
                                  return lists;
                                })()}
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

export const addList = () => {};

export const getLists = (data) => {
  
    //console.log(data);
    //data.data.forEach((list) =>
    let output = '';
    for(const [key, value] of Object.entries(data.data)) {
      //console.log(value);
      output+= `

      <div class="card">
      <h1 class="card-head">
        ${key}
      </h1>
      <div class="row g-3 mx-3 my-3">
      `+value[0].map((article) => {
        const {
          image_name,
          title,
          author,
          description,
          article_id,
          body,
          date,
          tags,
        } = article;
        return `
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
                                    <p class="card-text"><small class="text-muted">${
                                      '<a class="link-primary" href="#"">#' +
                                      tags.tags.join(
                                        '</a>, <a class="link-primary" href="#">#'
                                      ) +
                                      "</a>"
                                    }</small></p>
                                    <input type="hidden" value="${article_id}">
                                </div>
                            </div>
                        </div>
                    </span>
                    <span class="bottom-key-1"></span>
                    <span class="bottom-key-2"></span>
                </div>
            </div>
            
                `;
      }).join('\n')+`</div></div>`;
    };
  return output;
};

export const friendsList = (data) => {
  let output = ` `;
  //  console.log(data);
  data.forEach((friend) => {
    const { first_name, last_name, job, birthday, email } = friend;
    //./account.php?api_key=${getKey()}
    output += `
        <div class="friends">
            <a href="#" class="list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">${first_name} ${last_name}</h5>
                    <small>${birthday}</small>
                </div>
                <p class="mb-1">${job}</p>
                <small>${email}</small>
                <input type="hidden" value="${email}">
            </a>
        </div>
              `;
  });
  return output;
};

export const viewProfile = (email) => {
  return new Promise((resolve, reject) => {
    apiCall({
      type: "get_user_profile",
      email: email,
      api_key: getKey(),
    }).then((data) => {
      //  console.log(data);
      $.cookie(`account${getKey()}`, JSON.stringify(data));
      resolve(data);
    });
  });
};

export const displayProfile = (data) => {
  //  console.log(data);
  data = JSON.parse(data);
  const friends = data["data"]["friends"];
  //  console.log(friends);
  const {
    first_name,
    last_name,
    birthday,
    email,
    job,
    relationship,
    image_name,
    api_key,
  } = data["data"][0];
  let profile = `<div class="mx-auto my-auto">
        <img src="../../PROFILES/${image_name}" class="card-img-top rounded-circle" alt="Profile Picture">
    </div>
    <div class="card-body">
        <h5 class="card-title">${first_name} ${last_name}</h5>
    </div>
    <ul class="list-group list-group-flush">
    ${(function () {
      if (friends) {
        return `<li class="list-group-item"><strong>Birthday:</strong>${birthday}</li>
        <li class="list-group-item"><strong>Contact Information:</strong>${email}</li>
        <li class="list-group-item"><strong>Relationship Status:</strong>${relationship}</li>
        <li class="list-group-item"><strong>Job:</strong>${job}</li>`;
      } else {
        return "";
      }
    })()}
    </ul>`;
  return profile;
};

export const takeToProfile = (me) => {
  let email = $(me).closest(".friends").find("input[type='hidden']").val();

  //  console.log(email);
  viewProfile(email).then(
    (window.location.href = `./account.php?api_key=${getKey()}`)
  );
  //.then((data) => {
  //  $.cookie(`account${getKey()}`, JSON.stringify(data));
  //})
};

export const addToList = () => {
  $(".dropdown-item").on("click", function () {
    //console.log('found');
    const list = $(this).closest('li').find('input').val();
    const article = $(this).closest('.card-body').find('.articleID').val();
    console.log(list, article);
    apiCall(
      {
        type: ''
      }
    )
  });
}
