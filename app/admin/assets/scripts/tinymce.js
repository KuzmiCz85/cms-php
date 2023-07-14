import 'https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js';

const initEditor = (elem, callback) => {
  tinymce.init({
    selector: elem,
    setup: function(editor) {
      if (callback) {
        editor.on("change undo redo", function() {
          const primeElem = tinymce.activeEditor.targetElm
          callback(tinymce.activeEditor.getContent(), primeElem);
        })
      }
    },
    entities: '160,nbsp',
    entity_encoding: 'named',
    /* plugins: [
      'a11ychecker','advlist','advcode','advtable','autolink','checklist','export',
      'lists','link','image','charmap','preview','anchor','searchreplace','visualblocks',
      'powerpaste','fullscreen','formatpainter','insertdatetime','media','table','help','wordcount'
    ],

    toolbar: 'undo redo | formatpainter casechange blocks | bold italic backcolor | ' +
      'alignleft aligncenter alignright alignjustify | ' +
      'bullist numlist checklist outdent indent | removeformat | a11ycheck code table help' */
  })
}

export { initEditor }
