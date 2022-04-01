import productData from "./productData.js";
import stepper from "./stepper.js";
class modalOpen extends (productData, stepper) {
  constructor() {
    super();
    let modalBackground = document.querySelector("#modalBackground");
    let cartOpen = document.querySelectorAll("[modal-cart-open]");
    let cartClose = document.querySelectorAll("[modal-cart-close]");

    let navbarOpen = document.querySelectorAll("[modal-navbar-open]");
    let navbarClose = document.querySelectorAll("[modal-navbar-close]");

    let itemViewerOpen = document.querySelectorAll("[modal-itemViewer-open]");
    let itemViewerClose = document.querySelectorAll("[modal-itemViewer-close]");

    //cart
    cartOpen.forEach((element) => {
      element.addEventListener("click", (event) => {
        ModalBckground("open", "cart");
        if (window.matchMedia("(max-width: 500px)").matches) {
          //display the navbar on fullscreen
          anime.remove("#cart");
          anime({
            targets: "#cart",
            width: "100%",
            duration: 1000,
          });
        } else {
          //display navbar as default
          anime.remove("#cart");
          anime({
            targets: "#cart",
            width: "400px",
            duration: 1000,
          });
        }
      });
    });

    cartClose.forEach((element) => {
      element.addEventListener("click", (event) => {
        ModalBckground("close", "cart");
        anime.remove("#navbar");
        anime({
          targets: "#cart",
          width: "0px",
          duration: 1000,
        });
      });
    });

    //navbar
    navbarOpen.forEach((element) => {
      element.addEventListener("click", (event) => {
        ModalBckground("open", "navbar");

        if (window.matchMedia("(max-width: 500px)").matches) {
          //display the navbar on fullscreen
          anime.remove("#navbar");
          anime({
            targets: "#navbar",
            width: "100%",
            duration: 1000,
          });
        } else {
          //display navbar as default
          anime.remove();
          anime({
            targets: "#navbar",
            width: "400px",
            duration: 1000,
          });
        }
      });
    });

    navbarClose.forEach((element) => {
      element.addEventListener("click", (event) => {
        ModalBckground("close", "navbar");
        anime.remove("#navbar");
        anime({
          targets: "#navbar",
          width: "0px",
          duration: 1000,
        });
      });
    });

    //itemViewer
    itemViewerOpen.forEach((element) => {
      element.addEventListener("click", (event) => {
        let productId = element.getAttribute("data-product-id");
        new stepper();
        new productData(productId);
        ModalBckground("open", "itemViewer");

        if (window.matchMedia("(max-width: 650px)").matches) {
          //display the navbar on fullscreen
          anime.remove("#itemViewer");
          anime({
            targets: "#itemViewer",
            bottom: 0,
          });
        } else {
          //display navbar as default
          anime.remove("#itemViewer");
          anime({
            targets: "#itemViewer",
            top: "50%",
          });
        }
      });
    });

    itemViewerClose.forEach((element) => {
      element.addEventListener("click", (event) => {
        ModalBckground("close", "itemViewer");
        anime.remove();
        anime({
          targets: "#itemViewer",
          bottom: "-100%",
          top: "150%",
        });
      });
    });

    //-----------modal Opener-------------//
    //create background that will be displayed when a menu opens
    function ModalBckground(action, type) {
      if (action == "open") {
        modalBackground.style.display = "block";
      }
      if (action == "close") {
        modalBackground.style.display = "none";
      }
    }
  }
}

export default modalOpen;
