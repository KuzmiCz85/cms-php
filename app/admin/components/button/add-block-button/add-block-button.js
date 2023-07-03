import { btn } from "../button.js";
import { page } from "../../page/page.js";

const addBlockBtn = () => {
  const btn = document.querySelector(".add-block-btn")

  if (!btn) return // Btn doesnt exist

  const opener = btn.querySelector(".add-block-btn__opener")
  const list = btn.querySelector(".add-block-btn__blocks")

  // Btn opener - on click get blocks, add to list and show list
  opener.addEventListener("click", async () => {
    // Get blocks and assign to list
    const getBlocks = () => {
      return fetch('cms/get-blocks')
        .then(res => res.text())
    }
    list.innerHTML = await getBlocks() // Fill list

    // Show list of blocks
    if (!list.classList.contains("--js-visible"))
      list.classList.add("--js-visible")

    optService(list.querySelectorAll("li"), list) // Init options service
  })
};

// Options - on click save option value, hide list and send request
const optService = (opts, list) => {
  opts.forEach(opt => {
    const optVal = opt.innerText

    opt.addEventListener("click", async () => { // Save option value
      const pageId = document.querySelector(".page").dataset.pageId
      const blocks = document.querySelector(".g-blocks")
      const block = {
        block: optVal,
        page: pageId
      }

      // Hide blocks list
      list.classList.remove("--js-visible")
      // Send request and refresh blocks
      blocks.outerHTML = await updBlocks(block)
      // Init lost services after blocks refresh
      btn();
      page();
    })
  })
};

// Add selected block and return new blocks
const updBlocks = (block) => {
  return fetch('cms/add-block', {
    method: "POST",
    body: JSON.stringify(block)
  }).then(res => res.text())
};

addBlockBtn();
