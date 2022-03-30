class header {
  constructor() {
    var header = document.querySelector("header");
    //get the header a background color when scrolling down
    window.onscroll = function (e) {
      if (window.scrollY >= 19) {
        header.style.backgroundColor = "#000000ad";
      } else {
        header.style.backgroundColor = "unset";
      }
    };
  }
}
export default header;
