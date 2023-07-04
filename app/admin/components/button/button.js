import { page } from "../page/page.js"

const request = async (action, data = {}) => {
  const res = await fetch(action, {
    method: "POST",
    body: JSON.stringify(data)
  })
  return res.text()
};

// Perform button action
const callAction = async (btnDataset) => {

  if (btnDataset.action === "add_page") {
    const pagesList = document.querySelector(".g-pages")
    pagesList.outerHTML = await request("cms/pages/add")
  }

  if (btnDataset.action === "delete_target") {
    const pageId = document.querySelector(".page").dataset.pageId
    const target = document.querySelector(`[data-name="${btnDataset.targetName}"]`)
    if (target) targetId = target.dataset.id
    const parent = document.querySelector(`.${btnDataset.targetParent}`)

    if (btnDataset.targetType === "block") {
      parent.outerHTML = await request("cms/delete-block", {
        id: targetId,
        page: pageId
      })
      // Reload lost services
      btn()
      page()
    }

    if (btnDataset.targetType === "page") {
      console.log(await request("cms/delete-page", {
        id: pageId
      }))
      window.location.replace("cms/pages")
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
