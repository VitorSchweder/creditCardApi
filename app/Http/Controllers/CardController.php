<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Str;
use App\Helpers\Helper;
use File;
use App\Card;
use App\Category;

class CardController extends Controller {
    public function index(Request $request) {
        $nameFilter = $request->name ?? null;

        $cards = Card::listCards($nameFilter);

        if ($cards->count() == 0) {
            return response()->json(["message" => "Cards not found!"], 404);
        }

        return response()->json($cards, 200);
    }

    public function store(Request $request) {
        $validator = self::makeValidation($request);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $name = $request->get('name');
        $slug = Str::slug($name, '-');

        /**
         * Check if exists a card by name
         */
        if (Card::existsByName($name)) {
            return response()->json(["There is already a card with that name!"], 400);
        }

        /**
         * Check if exists a card by slug
         */
        if (Card::existsBySlug($slug)) {
            return response()->json(["There is already a card with that slug!"], 400);
        }

        /**
         * Upload image
         */
        $imageFile = $request->file('image');
        $imageName = uniqid(date('HisYmd')).'.'.$imageFile->extension();
        $imageFile->move(public_path('/'), $imageName);

        $card = new Card([
            'name' => $name,
            'slug' => $slug,
            'image' => $imageName,
            'brand' => $request->get('brand'),
            'limit' => Helper::removeMoneyCaracter($request->get('limit')),
            'annual_fee' => Helper::removeMoneyCaracter($request->get('annual_fee'))
        ]);

        $category = Category::find($request->get('category'));
        if (is_null($category)) {
            return response()->json(["message" => "Category not found!"], 404);
        }

        $card->category()->associate($category);

        $card->save();

        return response()->json($card, 201);
    }

    public function show($id) {
        $card = Card::showCard($id);

        if ($card->count() == 0) {
            return response()->json(["message" => "Card not found!"], 404);
        }

        return response()->json($card, 200);
    }

    public function update(Request $request, $id) {
        $card = Card::find($id);

        if (is_null($card)) {
            return response()->json(["message" => "Card not found!"], 404);
        }

        $validator = self::makeValidation($request);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $name = $request->get('name');
        $slug = Str::slug($name, '-');

        /**
         * Check if exists a card by name
         */
        if (Card::existsByName($name)) {
            return response()->json(["There is already a card with that name!"], 400);
        }

        /**
         * Check if exists a card by slug
         */
        if (Card::existsBySlug($slug)) {
            return response()->json(["There is already a card with that slug!"], 400);
        }

        /**
         * Remove previous image
         */
        File::delete(public_path($card->image));

        /**
         * Upload image
         */
        $imageFile = $request->file('image');
        $imageName = uniqid(date('HisYmd')).'.'.$imageFile->extension();
        $imageFile->move(public_path('/'), $imageName);

        $card->name = $name;
        $card->slug = $slug;
        $card->image = $imageName;
        $card->brand = $request->get('brand');

        if ($request->get('limit')) {
            $card->limit = Helper::removeMoneyCaracter($request->get('limit'));
        }

        if ($request->get('annual_fee')) {
            $card->annual_fee = Helper::removeMoneyCaracter($request->get('annual_fee'));
        }

        $category = Category::find($request->get('category'));
        if (is_null($category)) {
            return response()->json(["message" => "Category not found!"], 404);
        }

        $card->category()->associate($category);

        $card->save();

        return response()->json($card, 200);
    }

    public function delete(Request $request, $id) {
        $card = Card::find($id);

        if (is_null($card)) {
            return response()->json(["message" => "Card not found!"], 404);
        }

        /**
         * Remove image
         */
        File::delete(public_path($card->image));

        if ($request->get('force')) {
            $card->forceDelete();
        } else {
            $card->delete();
        }

        return response()->json(["message" => "Card deleted"], 200);
    }

    private static function makeValidation(Request $request) {
        $rules = [
            'name' => 'required|max:80',
            'image' => 'required',
            'brand' => 'required',
            'category' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        return $validator;
    }
}
