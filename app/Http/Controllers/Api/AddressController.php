<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\AddressRequest;
use App\Models\Address;
use App\Models\Country;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function saveAddress(AddressRequest $request) : JsonResponse
    {
        if(!Auth::check()) {
            return $this->sendError('User not authorised.', ['error' => 'Unauthorised access'], 401);
        }

        $user = Auth::user();

        $addresses = Address::where('user_id', $user->id)->get();

        $type = !$request->has('type') ? 'billing' : $request->get('type');

        $address = $addresses->filter(function ($item) use ($type) {
            return $item->type->value == $type;
        })->first();

        if($request->filled('country')) {
            $country = Country::where('id', $request->get('country'))->first();

            if(!$country) {
                return $this->sendError('Country code '.$request->get('country').' does not exist!', [], 404);
            }
        }

        $data = $request->all();

        $data['user_id'] = $user->id;

        if($address) {
            $address->update($data);
            $address->save();

            return $this->sendResponse($data, 'Address updated!');
        }

        Address::create($data);

        return $this->sendResponse($data, 'Address created!');
    }
}
