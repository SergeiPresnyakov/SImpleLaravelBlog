<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use stdClass;
use Illuminate\Support\Carbon;

/**
 * Class DiggingDeeperController
 * Для упражнений с коллекциями
 */
class DiggingDeeperController extends Controller
{
    public function collections()
    {
        $result = [];

        /**
         * @var Illuminate\Database\Eloquent\Collection $eloquentCollection
         */
        $eloquentCollection = BlogPost::withTrashed()->get();

        //dd(__METHOD__, $eloquentCollection, $eloquentCollection->toArray());

        /** 
         * @var Illuminate\Support\Collection $collection
         */
        $collection = collect($eloquentCollection->toArray());

        /* dd(
            __METHOD__,
            get_class($eloquentCollection),
            get_class($collection),
            $collection
        ); */

        /* $result['first'] = $collection->first();
        $result['last'] = $collection->last(); */

        $result['where']['data'] = $collection
            ->where('category_id', 10)
            ->values()
            ->keyBy('id');

        /* $result['where']['count'] = $result['where']['data']->count();
        $result['where']['isEmpty'] = $result['where']['data']->isEmpty();
        $result['where']['isNotEmpty'] = $result['where']['data']->isNotEmpty(); */

        $result['where_first'] = $collection->firstWhere('id', '>', 50);

        $result['map']['all'] = $collection->map(function(array $item) {
            $newItem = new stdClass();
            $newItem->item_id = $item['id'];
            $newItem->item_name = $item['title'];
            $newItem->exists = is_null($item['deleted_at']);

            return $newItem;
        });

        dd($result);

        /** 
         * Работает также как и map, но в отличие от него
         * не возвращает изменённый объект, а изменяет текущую коллекцию 
         */
        $collection->transform(function(array $item) {
            $newItem = new stdClass();
            $newItem->item_id = $item['id'];
            $newItem->item_name = $item['title'];
            $newItem->exists = is_null($item['deleted_at']);
            $newItem->created_at = Carbon::parse($item['created_at']);

            return $newItem;
        });

        /* Создаём несколько объектов
        для проверки метода prepend */
        $newObject_1 = new stdClass();
        $newObject_1->id = 9999;

        $newObject_2 = new stdClass();
        $newObject_2->id = 7777;

        // установить элемент в начало коллекции
        $newObjectFirst = $collection->prepend($newObject_1)->first();

        // установить элемент в конец коллекции
        $newObjectLast = $collection->push($newObject_2)->last();

        // вынуть элемент
        $pulledObject = $collection->pull(1);

        dd(compact(
            'collection',
            'newObjectFirst',
            'newObjectLast',
            'pulledObject'
        ));

        $filtered = $collection->filter(function($item) {
            $byDay = $item->created_at->isFriday();
            $byDate = $item->created_at->day == 13;

            $result = $byDay && $byDate;

            return $result;
        });

        $sortedSimpleCollection = collect([3, 5, 2, 6, 1, 6, 7, 1, 3])->sort();
        $sortedAscCollection = $collection->sortBy('created_at');
        $sortedDescCollection = $collection->sortByDesc('item_id');

        dd(compact(
            'sortedSimpleCollection',
            'sortedAscCollection',
            'sortedDescCollection'
        ));
        
    }   
}