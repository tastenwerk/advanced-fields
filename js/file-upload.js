jQuery(function($) {


    $('.repeatable-upload-add').click(function() {
      $field = $('.upload-repeatable:last').clone();
      $('input', $field).attr('name', function(index, name) {
        if( name )
            return name.replace(/(\d+)/, function(fullMatch, n) {
              return Number(n) + 1;
            });
        return name;
      });
      $field.insertAfter( $('.upload-repeatable:last') );
      return false;
    });

    $('.custom_upload_file_button').click(function() {
      console.log('CLICKED');
        $parent = $(this).parent();
        tb_show('', 'media-upload.php?type=file&TB_iframe=true');
        window.send_to_editor = function(html) {
            $parent.find('.file-upload-text').html( html );
            $parent.find('.file-title').attr('value', $(html).attr('href') );
            $parent.find('.file-link').attr('value', $(html).html() );
            tb_remove();
        }
        return false;
    });

    $('.remove-upload').click(function(){
      console.log( "HHHHH" );
      $(this).closest('li').remove();
      return false;
    });
     
});