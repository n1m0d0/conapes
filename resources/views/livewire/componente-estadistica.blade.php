<div>
   <div class="flex gird grid-cols-12 col-span-1 md:col-span-12 gap-4">
      <div class="col-span-1 md:col-span-4 p-2">
         <canvas id="estado" width="300" height="300" data="{{ $estado }}"></canvas>
      </div>
      <div class="col-span-1 md:col-span-4">
         {{ $cartera }}
         <canvas id="cartera" width="300" height="300" data="{{ $estado }}"></canvas>
      </div>
      <div class="col-span-1 md:col-span-4">
      </div>
   </div>
</div>