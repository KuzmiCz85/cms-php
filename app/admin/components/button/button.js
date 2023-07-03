import { page } from "../page/page.js"

// Perform button action
const callAction = async (dataset) => {

  if (dataset.action === "cms/pages/add") {
    const res = await fetch(action, {
      method: "POST",
    })
    /* .then(res => res.text())
    .then(data => console.log(data)) */

    const pagesList = document.querySelector(".g-pages")
    pagesList.outerHTML = await res.text()
  }

  if (dataset.action === "delete_target") {
    const pageId = document.querySelector(".page").dataset.pageId
    const target = document.querySelector(`[data-name="${dataset.targetName}"]`)
    const targetId = target.dataset.id
    const parent = document.querySelector(`.${dataset.targetParent}`)

    if (dataset.targetType === "block") {
      const res = await fetch("cms/delete-block", {
        method: "POST",
        body: JSON.stringify({
          id: targetId,
          page: pageId
        })
      })
      /* .then(res => res.text())
      .then(data => console.log(data)) */

      parent.outerHTML = await res.text()
      // Reload lost services
      btn()
      page()
    }
  }
}

export const btn = () => {
  const btns = document.querySelectorAll(".btn")

  if (!btns.length > 0) return

  btns.forEach(btn => btn.addEventListener("click", event => {
    event.preventDefault()

    if (btn.dataset.action)
      callAction(btn.dataset)
  }))
};

btn();
