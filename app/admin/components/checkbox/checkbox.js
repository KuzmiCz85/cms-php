const checkbox = () => {
  const box = document.querySelector(".checkbox");

  // Return if box doesn't exist
  if (!box) return

  const input = box.querySelector("input")

  input.addEventListener("click", event => {
    const inputVal = input.getAttribute("value")

    if (inputVal === "0") input.setAttribute("value", "1")
    else input.setAttribute("value", "0")
  })
};

export default checkbox();
