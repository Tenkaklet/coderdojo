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

import modal from "./components/modalOpen.js";
import header from "./components/header.js";
new modal();
new header();
