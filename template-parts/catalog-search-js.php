<script>
function lengthSearch() {
  var form = document.csForm;

  // スタイリストのフォーム取得
  var formStylist = form.elements['stylist[]'];
  var stylistLength = typeof formStylist === 'undefined' ? false : formStylist.length;

  // レングスのフォーム取得
  var formLength = form.elements['length[]'];
  var lengLength = typeof formLength === 'undefined' ? false : formLength.length;

  // タグ
  var formTag = form.elements['catalog_tag[]'];
  var tagLength = typeof formTag === 'undefined' ? false : formTag.length;

  // スタイリストの格納
  var stylist = [];
  if( stylistLength !== false ) {
    for( var j = 0; j < stylistLength; j++ ) {
      if( formStylist[j].checked ) {
        stylist.push(formStylist[j].value);
      }
    }
  }

  // レングスの格納
  var length = [];
  if( lengLength !== false ) {
    for( var i = 0; i < lengLength; i++ ) {
      if( formLength[i].checked ) {
        length.push(formLength[i].value);
      }
    }
  }

  var tag = [];
  if( tagLength !== false ) {
    for( var r = 0; r < tagLength; r++ ) {
      if( formTag[r].checked ) {
        tag.push(formTag[r].value);
      }
    }
  }

  // Array Join
  var lengthStr = length.join(',');
  var stylistStr = stylist.join(',');
  var tagStr = tag.join(',');

  return {
    "leng" : lengthStr,
    "stylist" : stylistStr,
    "tag" : tagStr
  };
}

jQuery(document).ready(function($) {
  // カタログのURL
  var urls = '<?= esc_url(get_post_type_archive_link('catalog')); ?>';

  // クエリー
  var lengthVars = '<?= get_query_var("length"); ?>';
  var stylistVars = '<?= get_query_var("stylist"); ?>';
  var tagVars = '<?= get_query_var("catalog_tag"); ?>';

  // レングスの記号除去
  var lengRep = lengthVars.replace(/[!"#$%&'()\*\+\-\.\/:;<=>?@\[\\\]^_`{|}~]/g, '');
  var lengSplit = lengRep.split(',');

  // スタイリストの記号除去
  var stylistRep = stylistVars.replace(/[!"#$%&'()\*\+\.\/:;<=>?@\[\\\]^`{|}~]/g, '');
  var stylistSplit = stylistRep.split(',');

  var tagRep = tagVars.replace(/[!"#$'()\*\+\.\/:;<=>?@\[\\\]^`{|}~]/g, '');
  var tagSplit = tagRep.split(',');

  var form = document.csForm;

  // スタイリスト
  var formStylist = form.elements['stylist[]'];
  var stylistLength = typeof formStylist === 'undefined' ? false : formStylist.length;

  // レングス
  var formLength = form.elements['length[]'];
  var lengLength = typeof formLength === 'undefined' ? false : formLength.length;

  // タグ
  var formTag = form.elements['catalog_tag[]'];
  var tagLength = typeof formTag === 'undefined' ? false : formTag.length;

  // スタイリストのチェック
  if( stylistLength !== false ) {
    for( var i = 0; i < stylistLength; i++ ) {
      for( var j = 0; j < stylistSplit.length; j++ ) {
        if( formStylist[i].value == stylistSplit[j] ) {
          formStylist[i].checked = true;
        }
      }
    }
  }

  // レングスのチェック
  if( lengLength !== false ) {
    for( var i = 0; i < lengLength; i++ ) {
      for( var j = 0; j < lengSplit.length; j++ ) {
        if( formLength[i].value == lengSplit[j] ) {
          formLength[i].checked = true;
        }
      }
    }
  }

  // タグのチェック
  if( tagLength !== false ) {
    for( var i = 0; i < tagLength; i++ ) {
      for( var j = 0; j < tagSplit.length; j++ ) {
        if( formTag[i].value == tagSplit[j] ) {
          formTag[i].checked = true;
        }
      }
    }
  }

  $('#tagAll').on('change', function() {
    if( $(this).prop('checked') ) {
      for( var i = 1; i < tagLength; i++ ) {
        formTag[i].checked = false;
      }
    }
  });
  $('#searchTagCheckbox :checkbox').on('change', function() {
    var par = $(this).parent();
    var index = par.index();
    if( index !== 0 ) {
      if( formTag[index].checked ) {
        formTag[0].checked = false;
      }
    }
  });

  $('#ls').on('click', function(e) {
    e.preventDefault();
    var search = lengthSearch();

    if( search ) {
      var s = search.stylist || null;
      var l = search.leng || null;
      var t = search.tag || null;

      var check = [
        [(s && !l && !t), '/search/s/'+s],
        [(!s && l && !t), '/search/l/'+l],
        [(!s && !l && t), '/search/t/'+t],
        [(s && l && !t), '/search/s/'+s+'/l/'+l],
        [(s && !l && t), '/search/s/'+s+'/t/'+t],
        [(!s && l && t), '/search/l/'+l+'/t/'+t],
        [(s && l && t), '/search/s/'+s+'/l/'+l+'/t/'+t],
        [(!s && !l && !t), '']
      ];

      for( var i = 0; i < check.length; i++ ) {
        if( check[i][0] ) {
          window.location.href = urls + check[i][1];
        }
      }
    }
  });

  if( ! Helper.isMobile() ) {
    $('#catalogSearchBox').hide();
  }
  $('#catalogSearchToggle').on('click', function() {
    var csw = $('#catalogSearchBox');
    if( csw.hasClass('open') ) {
      csw.removeClass('open');
    } else {
      csw.addClass('open');
    }
    if( ! Helper.isMobile() ) {
      if( csw.hasClass('open') ) {
        csw.stop().slideDown('fast');
      } else {
        csw.stop().slideUp('fast');
      }
    }

    var tgl = $(this).find('.toggle');
    if( tgl.hasClass('fa-toggle-down') ) {
      tgl.removeClass('fa-toggle-down');
      tgl.addClass('fa-toggle-up');
    } else {
      tgl.removeClass('fa-toggle-up');
      tgl.addClass('fa-toggle-down');
    }
  });
});
</script>