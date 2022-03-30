//prepare elements for later use
var header = document.querySelector("header");
var navbar = header.querySelector("#navbar");
var cart = header.querySelector("#cart");

//get the header a background color when scrolling down
window.onscroll = function (e) {
  if (window.scrollY >= 19) {
    header.style.backgroundColor = "#000000ad";
  } else {
    header.style.backgroundColor = "unset";
  }
};
