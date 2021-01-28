jQuery(document).ready(function() {
 $('a[rel*=askdelete]').on('click',function(e) {
    e.preventDefault();
        if ($('.boxy-wrapper').length > 0)
            return false;
                
    var myRow = $(this).parent().parent(), 
        myID = myRow.data('id'),
        myDelUrl = $(this).attr('href') + '&confirm=yes';
        
    Boxy.confirm('Delete this item?', function() {
            $.get(myDelUrl, function(data){
                myRow.hide();
            });
    }, {title: 'Please confirm:'});
    return false;
  });
  // date picker
  $('#expire').datepick({
      minDate: +1,
      showAnim: '',
  });   
});