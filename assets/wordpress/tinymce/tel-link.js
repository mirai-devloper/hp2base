(function (tinymce) {
  tinymce.create('tinymce.plugins.tel_link', {
    init: function (ed, url) {
      ed.addButton('button_tel_link', {
        title: '電話番号リンク',
        image: url + '/assets/wordpress/tinymce/tel-link.png',
        cmd: 'button_tel_link_cmd'
      });
      ed.addCommand('button_tel_link_cmd', function () {
        var selected_text = ed.selection.getContent();
        var return_text = '';
        return_text = '<a href="">' + selected_text + '</a>';
        ed.execCommand('mceInsertContent', 0, return_text);
      });
    },
    createControl: function (n, cm) {
      return null;
    }
  });
  tinymce.PluginManager.add('tel_link_plugin', tinymce.plugins.tel_link);
})(window.tinymce);