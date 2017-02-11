
tinymce.init({
  selector: '.mce',
  height: 300,
  plugins: [
    'advlist autolink lists link charmap print preview',
    'searchreplace visualblocks code fullscreen',
    'insertdatetime table contextmenu paste code',
    'textcolor'
  ],
  toolbar: 'undo redo | fontselect styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link | forecolor backcolor',
  content_css: [
    '//fast.fonts.net/cssapi/e6dc9b99-64fe-4292-ad98-6974f93cd2a2.css',
    'assets/stylesheets/mce.css'
  ],
  file_browser_callback : 'myFileBrowser'
});

