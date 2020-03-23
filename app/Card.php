<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Card extends Model {
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'image',
        'brand',
        'limit',
        'annual_fee'
    ];

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public static function existsByName($cardName) {
        return Card::where('name', '=', $cardName)->count();
    }

    public static function existsBySlug($cardSlug) {
        return Card::where('slug', '=', $cardSlug)->count();
    }

    public static function listCards($nameFilter) {
        $queryCards = Card::query();

        $queryCards->join('categories', 'categories.id', '=', 'cards.category_id');

        if ($nameFilter) {
            $queryCards->where('cards.name', '=', $nameFilter);
        }

        $queryCards->orderBy('cards.name');

        return $queryCards->paginate(10, ['cards.name', 'cards.brand', 'categories.name as category']);
    }

    public static function showCard($id) {
        return Card::select('cards.name',
                            'cards.image',
                            'cards.brand',
                            'categories.name as category',
                            'cards.limit',
                            'cards.annual_fee',
                            'cards.created_at',
                            'cards.updated_at')
                     ->join('categories', 'categories.id', 'cards.category_id')
                     ->where('cards.id', '=', $id)
                     ->get();
    }
}
