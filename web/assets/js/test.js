function deleteProduct(id){
  $.ajax({
    url: '/products/'+ id +'/delete.json',
    method: 'DELETE',
  }).done(function(data){
    console.log(data.success);
    $('tr#product-'+id).remove();
    $('.panel.panel-success').show({
      duration: 3000, complete: function() {
        $(this).hide();
      }
    });
    $('.panel.panel-success p').text(data.success);
  });
}
