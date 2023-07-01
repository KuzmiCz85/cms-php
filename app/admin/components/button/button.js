// Perform button action
const callAction = async (action) => {
  if (action === "cms/pages/add") {
    const res = await fetch(action, {
      method: "POST",
    })
    /* .then(res => res.text())
    .then(data => console.log(data)) */

    const pagesList = document.querySelector(".g-pages")
    pagesList.outerHTML = await res.text()
  }
}

const btnInit = () => {
  const btns = document.querySelectorAll(".btn")

  if (!btns.length > 0) return

  btns.forEach(btn => btn.addEventListener("click", event => {
    event.preventDefault()

    if (btn.dataset.action) {
      callAction(btn.dataset.action)
    }
  }))
};

btnInit();
