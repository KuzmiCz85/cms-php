import { page } from "../page/page.js"

const request = async (action, data = {}) => {
  const res = await fetch(action, {
    method: "POST",
    body: JSON.stringify(data)
  })
  return res.text()
};

// Perform button action
const callAction = async (elem) => {

  if (elem.dataset.action === "add_page") {
    const pagesList = document.querySelector(".g-pages")
    pagesList.outerHTML = await request("cms/pages/add")
  }

  if (elem.dataset.action === "delete_target") {
    const pageId = document.querySelector(".page").dataset.pageId
    const target = document.querySelector(`[data-name="${elem.dataset.targetName}"]`)
    const parent = document.querySelector(`.${elem.dataset.targetParent}`)

    if (elem.dataset.targetType === "block") {
      const targetId = target.dataset.id
      parent.outerHTML = await request("cms/delete-block", {
        id: targetId,
        page: pageId
      })
      // Reload lost services
      btn()
      page()
    }

    if (elem.dataset.targetType === "page") {
      await request("cms/delete-page", {
        id: pageId
      })

      window.location.href = "cms/pages"
    }
  }
};

export const btn = () => {
  const btns = document.querySelectorAll(".btn")

  if (!btns.length > 0) return

  btns.forEach(btn => btn.addEventListener("click", event => {
    event.preventDefault()

    callAction(btn)
  }))
};

btn();
