<?php 
namespace App\Traits;

trait PrintMetas {



    public function StoreMetas($request, $id){

            $finishn = explode(",", $request->finishings);

        return [
            'product_id' => decrypt($id),
            'name' => $request->name,
            'finishings' => json_encode($finishn)
        ];
    }
}