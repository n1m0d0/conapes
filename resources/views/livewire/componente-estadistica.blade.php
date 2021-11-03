<div>
   <div class="flex gird grid-cols-12 col-span-1 md:col-span-12 gap-4 justify-center">
      <div class="col-span-1 md:col-span-6 p-2 items-center">
         <canvas id="estado" width="400" height="400" data="{{ $estado }}"></canvas>
      </div>
      <div class="col-span-1 md:col-span-6">
         <canvas id="cartera" width="400" height="400" data="{{ $cartera }}"></canvas>
      </div>
   </div>
   @section('scripts')

   @endsection
</div>