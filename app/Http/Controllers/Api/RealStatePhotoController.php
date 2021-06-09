<?php

namespace App\Http\Controllers\Api;

use App\Api\ApiMessages;
use App\Http\Controllers\Controller;
use App\Models\RealState;
use App\Models\RealStatePhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RealStatePhotoController extends Controller
{
    private $realStatePhoto;
    public function __construct(RealStatePhoto $realStatePhoto)
    {
        $this->realStatePhoto = $realStatePhoto;
    }

    public function setThumb($photoId, $realStateId){
        try {

            //Verifica se existe thumb para aquele imóvel
            $photo = $this->realStatePhoto
                ->where('real_state_id', $realStateId)
                ->where('is_thumb', true);

            //se existir, atribua falso a foto com a propriedade is_thumb
            if ($photo->count()) {
                $photo->first()->update(['is_thumb' => false]);
            }

            //Atribua verdadeiro a foto is_thumb da nova foto escolhida
            $photo = $this->realStatePhoto->find($photoId);
            $photo->update(['is_thumb' => true]);


            return response()->json([
                'data' => [
                    'msg' => 'Thumb atualizada com sucesso !'
                ]
            ], 200);

        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(),401);
        }
    }


    public function remove($photoId){

        try {

            $photo = $this->realStatePhoto->find($photoId);

            if($photo){
                Storage::disk('public')->delete($photo->photo);
                $photo->delete();
            }


            return response()->json([
                'data' => [
                    'msg' => 'Foto removida com sucesso !'
                ]
            ], 200);

        } catch (\Exception $e) {
            $message = new ApiMessages($e->getMessage());
            return response()->json($message->getMessage(),401);
        }

    }
}
