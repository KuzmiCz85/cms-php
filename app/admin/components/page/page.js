import { initEditor } from "../../assets/scripts/tinymce.js";

// Object for storing page props
const pageProps = { data: {} }

// Store value of element (must have id) to object
const storeValue = (elem, obj) => {
  if (!elem.id) return

  obj[elem.id] = elem.value
  //console.log(obj)
};

// Save button submit
const saveBtnSubmit = (event) => {
  event.preventDefault()

  fetch('cms/save', {
    method: "POST",
    body: JSON.stringify(pageProps),
  })
  .then(res => res.text())
  .then(data => console.log(data))
};

// Service for page data
const pageService = (page) => {
  // Store page id on init
  const pageId = page.dataset.pageId
  if (pageId) pageProps['id'] = pageId

  // Init service for main page data
  const pageMainProps = page.querySelector(".page__data")
  if (pageMainProps) dataService(pageMainProps)

  // Init service for page blocks
  const pageBlocks = page.querySelector(".g-blocks")
  if (pageBlocks) blocksService(pageBlocks)

  // Init editor with callback for saving content
  const hasEditor = page.querySelector(".editor")
  if (hasEditor) initEditor(".editor", editorService)

  // Init save button
  const saveBtn = document.getElementById("saveBtn")
  if (saveBtn) saveBtn.addEventListener("click", saveBtnSubmit)
};

// Service for main page props
const dataService = (elem) => {
  // Inputs service
  const propsInputs = elem.querySelectorAll("input")

  if (propsInputs.length === 0) return

  propsInputs.forEach(input => {
    // Store input value on init
    storeValue(input, pageProps.data)

    // Store new value on change
    input.addEventListener("change", event => storeValue(input, pageProps.data))
  });
  //console.log(pageProps)
};

// Service for page blocks
const blocksService = (elem) => {
  const blocks = elem.querySelectorAll(".block")

  if (blocks.length === 0) return

  // Create new property for blocks
  pageProps['blocks'] = []

  blocks.forEach(blockElem => {
    const block = { data: {} }
    // Get block id
    if (blockElem.dataset.id) block['id'] = blockElem.dataset.id

    const blockFields = blockElem.querySelectorAll(".field")

    blockFields.forEach(field => {
      const name = field.dataset.fieldName
      const input = field.querySelector("input") || field.querySelector("textarea")
      const val = input.value ? input.value : null

      // Store value on init
      block.data[name] = val

      // For textarea with tinymce
      if (input.type === "textarea" && input.classList.contains("editor")) return

      else {
        // Store classic input value on change
        input.addEventListener("change", event => {
          let valNew = input.value ? input.value : null

          block.data[name] = valNew
          //console.log(block.data)
        })
      }
    })
    // Store existing block on init
    pageProps.blocks.push(block)
  })
  //console.log(pageProps)
};

const editorService = (val, elem) => {
  const blockId = elem.closest(".block").dataset.id
  const name = elem.dataset.fieldName

  //console.log(name)

  pageProps.blocks.forEach(block => {
    if (block.id === blockId) block.data[name] = val
  });
  //console.log(pageProps.blocks)
}

export const page = () => {
  const page = document.querySelector(".page")

  if (!page) return

  pageService(page)
};

page();
