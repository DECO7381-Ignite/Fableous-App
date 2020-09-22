let pageNumber = document.getElementById("page-number");
let pagelists = document.getElementsByClassName("page-list");
let pages = document.getElementById("pages");
let add_page_button = document.getElementById("add-page");
let pagesChild01 = document.getElementById("pages-child-01");
let theCanvas = document.getElementById("myCanvas");
var currentPage = 0;

for (let k in pagelists) {
    pagelists[k].onclick = function () {
        currentPage = k;
        let img = new Image();
        img.src = pagelists[k].data;
        img.onload = function () {
            theCanvas.getContext("2d").drawImage(img, 0, 0);
        }
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
    newPage.className = "page-list";
    pagesChild01.appendChild(newPage);

    pagelists = document.getElementsByClassName("page-list");
    pagelists[pagelists.length - 2].data = theCanvas.toDataURL();

    newPage.onclick = function () {
        currentPage = pagelists.length - 1;
        console.log(currentPage);
        let img = new Image();
        img.src = this.data;
        img.onload = function () {
            theCanvas.getContext("2d").drawImage(img, 0, 0);
        }
    }
    initialFill();
}
