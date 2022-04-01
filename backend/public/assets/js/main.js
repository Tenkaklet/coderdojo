//loading page
function onReady(callback) {
  let intervalID = window.setInterval(checkReady, 500);

  function checkReady() {
    if (document.getElementsByTagName("body")[0] !== undefined) {
      window.clearInterval(intervalID);
      callback.call(this);
    }
  }
}

function show(id, value) {
  document.getElementById(id).style.display = value ? "block" : "none";
}

onReady(function () {
  show("main", true);
  show("loading", false);
});
//end of loading page

//-----------modal Opener-------------//
//create background that will be displayed when a menu opens
function ModalBckground(action, type) {
  if (action == "show") {
    let background = document.createElement("div");
    background.classList.add("ModalBackground");
    if (type == "navbar") {
      background.setAttribute("onclick", "toggleModal('close', 'navbar');");
    }
    if (type == "cart") {
      background.setAttribute("onclick", "toggleModal('close', 'cart');");
    }
    if (type == "itemViewer") {
      background.setAttribute("onclick", "toggleModal('close', 'itemViewer');");
    }
    background.style.cssText =
      "background-color: #000000ad; height: 100%; width: 100%; position: fixed; top: 0; left: 0; z-index: 1;";
    header.prepend(background);
  }
  if (action == "close") {
    let ModalBackground = document.getElementsByClassName("ModalBackground");
    while (ModalBackground.length > 0) {
      ModalBackground[0].parentNode.removeChild(ModalBackground[0]);
    }
  }
}

function toggleModal(action, type, data) {
  if (action == "open") {
    if (type == "navbar") {
      ModalBckground("show", "navbar");
      //check if the width of the screen is less then 500px
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
    } else if (type == "cart") {
      ModalBckground("show", "cart");
      //check if the width of the screen is less then 500px
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
    } else if (type == "itemViewer") {
      stepper();
      productData(data);
      ModalBckground("show", "itemViewer");
      //check if the width of the screen is less then 500px
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
    }
  }
  if (action == "close") {
    if (type == "navbar") {
      ModalBckground("close", "navbar");
      anime.remove("#navbar");
      anime({
        targets: "#navbar",
        width: "0px",
        duration: 1000,
      });
    } else if (type == "cart") {
      ModalBckground("close", "cart");
      anime.remove("#navbar");
      anime({
        targets: "#cart",
        width: "0px",
        duration: 1000,
      });
    } else if (type == "itemViewer") {
      ModalBckground("close", "itemViewer");
      anime.remove();
      anime({
        targets: "#itemViewer",
        bottom: "-100%",
        top: "150%",
      });
    }
  }
}

//end of modal opener

//get products data request
function productData(productId) {
  let formData = new FormData();
  formData.append("productId", productId);
  fetch("actions/productData", {
    method: "POST",
    body: formData,
  }).then((response) => {
    response.text().then((product) => {
      document
        .getElementById("itemViewer")
        .querySelector("#content").innerHTML = product;
    });
  });
}

function stepper() {
  let currentStep = 0;
  const interval = setInterval(function () {
    if (document.getElementsByClassName("stepper")[0] !== undefined) {
      clearInterval(interval);
      var stepsButtons = stepperHeader.querySelectorAll("li");
      var stepperContent = document.getElementById("stepperContent");
      var steps = stepperContent.querySelectorAll(".step");

      if (steps.length == stepsButtons.length) {
        for (var i = 0; i < stepsButtons.length; i++) {
          function updateStep(index) {
            var stepperHeader = document.getElementById("stepperHeader");
            var stepsButton = stepperHeader.querySelectorAll("li")[index];
            stepsButton.addEventListener("click", function () {
              //if you go back steps
              if (index < currentStep) {
                for (var ii = 0; ii < currentStep + 1; ii++) {
                  console.log("ii" + ii);
                  stepperHeader
                    .querySelectorAll("li")
                    [ii].querySelector(".stepButton").style.backgroundColor =
                    "gray";
                  stepperHeader
                    .querySelectorAll("li")
                    [ii].classList.remove("doneStep");
                }
                for (var ii = 0; ii < index; ii++) {
                  stepperHeader
                    .querySelectorAll("li")
                    [ii].querySelector(".stepButton").style.backgroundColor =
                    "var(--main-color)";
                  stepperHeader
                    .querySelectorAll("li")
                    [ii].classList.add("doneStep");
                }
              }

              //if you go forward step
              if (index > currentStep) {
                for (var ii = 0; ii < index; ii++) {
                  console.log("ii" + ii);
                  stepperHeader
                    .querySelectorAll("li")
                    [ii].querySelector(".stepButton").style.backgroundColor =
                    "var(--main-color)";
                  stepperHeader
                    .querySelectorAll("li")
                    [ii].classList.add("doneStep");
                }
              }
              stepsButton.querySelector(".stepButton").style.backgroundColor =
                "var(--main-color)";
              currentStep = index;
              console.log(currentStep);
              moveStep(index);
            });
          }
          updateStep(i);
        }

        function moveStep(stepIndex) {
          var stepperContent = document.getElementById("stepperContent");
          var steps = stepperContent.querySelectorAll(".step");
          steps.forEach((step) => {
            //step.style.transform = `translateX(-${stepIndex}00%)`;
            anime({
              targets: step,
              translateX: `-${stepIndex}00%`,
            });
          });
        }
      }
    }
  }, 100);
}

// function stepper(action, data = 1) {
//   let currentStep = 0;
//   if (action == "moveNext") {
//     currentStep++;
//   } else if (action == "movePrev") {
//     currentStep--;
//   } else if (action == "custom") {
//     currentStep == data;
//   }
//   var stepperContent = document.getElementById("stepperContent");
//   var steps = stepperContent.querySelectorAll(".step");
//   steps.forEach((step) => {
//     //step.style.transform = `translateX(-${stepIndex}00%)`;
//     anime({
//       targets: step,
//       translateX: `-${currentStep}00%`,
//     });
//   });

//   for (var i = 0; i < stepsButtons.length; i++) {

//     function updateStep(index) {
//       var stepperHeader = document.getElementById("stepperHeader");
//       var stepsButton = stepperHeader.querySelectorAll("li")[index];
//       stepsButton.addEventListener("click", function () {
//         //if you go back steps
//         if (index < currentStep) {
//           for (var ii = 0; ii < currentStep + 1; ii++) {
//             stepperHeader
//               .querySelectorAll("li")
//               [ii].querySelector(".stepButton").style.backgroundColor =
//               "gray";
//             stepperHeader
//               .querySelectorAll("li")
//               [ii].classList.remove("doneStep");
//           }
//           for (var ii = 0; ii < index; ii++) {
//             stepperHeader
//               .querySelectorAll("li")
//               [ii].querySelector(".stepButton").style.backgroundColor =
//               "var(--main-color)";
//             stepperHeader
//               .querySelectorAll("li")
//               [ii].classList.add("doneStep");
//           }
//         }

//         //if you go forward step
//         if (index > currentStep) {
//           for (var ii = 0; ii < index; ii++) {
//             console.log("ii" + ii);
//             stepperHeader
//               .querySelectorAll("li")
//               [ii].querySelector(".stepButton").style.backgroundColor =
//               "var(--main-color)";
//             stepperHeader
//               .querySelectorAll("li")
//               [ii].classList.add("doneStep");
//           }
//         }
//         stepsButton.querySelector(".stepButton").style.backgroundColor =
//           "var(--main-color)";
//         currentStep = index;
//         console.log(currentStep);
//         moveStep(index);
//       });
//     }
//     updateStep(i);
//   }
// }
