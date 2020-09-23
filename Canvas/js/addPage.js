let pageNumber = document.getElementById("page-number");
let pagelists = document.getElementsByClassName("page-list");
let pages = document.getElementById("pages");
let add_page_button = document.getElementById("add-page");
let pagesChild01 = document.getElementById("pages-child-01");
let theCanvas = document.getElementById("myCanvas");
let firstPage = document.getElementById("page-1");
let pageID = 0;
var pageMap = new Map();
pageMap.set("currentPage", 0);
pageMap.set("previousPage", 0);

firstPage.id = "" + pageID;
pageID = pageID + 1;
firstPage.innerHTML = "page - " + pageID;
firstPage.onclick = function () {
    pagelists = document.getElementsByClassName("page-list");
    let temp = pageMap.get("currentPage");
    pageMap.set("currentPage", parseInt(this.id));
    pageMap.set("previousPage", temp);
    let img = new Image();
    img.src = pagelists[0].data;
    img.onload = function () {
        theCanvas.getContext("2d").drawImage(img, 0, 0);
    }
}

pageNumber.onclick = function () {
    if (pages.style.visibility === "visible") {
        pages.style.visibility = "hidden";
    } else {
        pages.style.visibility = "visible";
    }
}

add_page_button.onclick = function () {
    let newPage = document.createElement("div");
    // let deleteButton = document.createElement("button");
    // let pp = document.createElement("p");
    newPage.className = "page-list";
    pagesChild01.appendChild(newPage);
    newPage.id = "" + pageID;
    pageID = pageID + 1;
    //
    // newPage.appendChild(pp);
    // newPage.appendChild(deleteButton);
    // deleteButton.innerHTML="-";

    let temp = pageMap.get("currentPage");
    pageMap.set("currentPage", parseInt(newPage.id));
    pageMap.set("previousPage", temp);

    pagelists = document.getElementsByClassName("page-list");
    pagelists[pageMap.get("previousPage")].data = theCanvas.toDataURL();
    initialFill();
    newPage.innerHTML = "page - " + pageID;
    newPage.data = theCanvas.toDataURL();

    newPage.onclick = function () {
        let temp = pageMap.get("currentPage");
        pageMap.set("currentPage", parseInt(newPage.id));
        pageMap.set("previousPage", temp);
        let img = new Image();
        img.src = pagelists[parseInt(newPage.id)].data;
        img.onload = function () {
            theCanvas.getContext("2d").drawImage(img, 0, 0);
        }
    }
    //
    // deleteButton.onclick = function () {
    //     pagesChild01.removeChild(newPage);
    //     pageMap.set("currentPage", pageMap.get("previousPage"));
    //     updateCanvas(pageMap.get("currentPage"));
    //     console.log("##############");
    //     console.log(pageMap);
    //     let img = new Image();
    //     img.src = pagelists[pageMap.get("currentPage")].data;
    //     img.onload = function () {
    //         theCanvas.getContext("2d").drawImage(img, 0, 0);
    //     }
    // }
}
