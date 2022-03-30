class productData {
  constructor(productId) {
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
}

export default productData;
