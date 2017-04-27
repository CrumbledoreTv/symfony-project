$.ajax({
  url: '/products.json',
  method: 'GET',
}).done(function(data){
  console.log(data);
});
