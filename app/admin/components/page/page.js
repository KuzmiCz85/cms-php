// Object for storing page props
const pageProps = { data: {} }

// Store value of element (must have id) to object
const storeValue = (elem, obj) => {
  if (!elem.id) return

  obj[elem.id] = elem.value

  console.log(obj)
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

// Service for page props
const propsService = (section) => {
  // Store page id on init
  const pageId = section.dataset.pageId

  if (pageId) pageProps['id'] = pageId

  // Inputs service
  const propsInputs = section.querySelectorAll("input")

  if (propsInputs.length === 0) return

  propsInputs.forEach(input => {

    // Store input value on init
    storeValue(input, pageProps.data)
    console.log(pageProps)

    // Store new value on change
    input.addEventListener("change", event => storeValue(input, pageProps.data))
  });

  // Blocks service
  const blocks = section.querySelectorAll(".block")

  if (blocks.length === 0) return

  // Create new property for blocks
  pageProps['blocks'] = []

  blocks.forEach((block, i) => {

    // Store existing block on init
    pageProps.blocks.push(`block-${i}`)

    console.log(pageProps)
  });

  const saveBtn = document.getElementById("saveBtn")

  if (saveBtn) saveBtn.addEventListener("click", saveBtnSubmit)
};

const page = () => {
  const pageSection = document.querySelector(".page")

  if (!pageSection) return

  propsService(pageSection)
};

export default page();
