const checkbox = () => {
  const boxes = document.querySelectorAll(".checkbox");

  // Return if boxes doesn't exist
  if (!boxes) return

  boxes.forEach(box => {
    const input = box.querySelector("input")

    input.addEventListener("click", event => {
      const inputVal = input.getAttribute("value")

      if (inputVal === "0") input.setAttribute("value", "1")
      else input.setAttribute("value", "0")
    })
  })
};

export default checkbox();
