<div>
   <div id="container" style="width: 700px; height: 400px;" data="{{ $propuestas }}"></div>
   {{ $propuestas }}
   @section('scripts')
   <script>
      var ctx = document.getElementById('container');
      var estadistica = JSON.parse(ctx.getAttribute('data'));
      
      anychart.onDocumentLoad(function () {
    // create an instance of a pie chart
    console.log(estadistica);
    let Values=[];
    
    var chart = anychart.pie();
    estadistica.forEach(element => {
      let Valores=[];
      if(element.estado == 1)
      {
         Valores.push("REGISTRADO");
      }
      if(element.estado == 2)
      {
         Valores.push("REVISION");
      }
      if(element.estado == 3)
      {
         Valores.push("APROBADO");
      }
      if(element.estado == 4)
      {
         Valores.push("REPROBADO");
      }
      if(element.estado == 5)
      {
         Valores.push("INACTIVO");
      }
      Valores.push(element.total);
      Values.push(Valores);
 });
 console.log(Values);
    // set the data
    /*chart.data([
      ["Chocolate", 5],
      ["Rhubarb compote", 2],
      ["Crêpe Suzette", 2],
      ["American blueberry", 2],
      ["Buttermilk", 1]
    ]);*/
    chart.Values;
    // set chart title
    chart.title("Estado");
    // set the container element 
    chart.container("container");
    // initiate chart display
    chart.draw();
  });
   </script>
   @endsection
</div>