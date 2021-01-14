<?php

namespace App\Observers;

use App\Category;
use App\CategoryHierarchy;

class CategoryObserver
{
    /**
     * Handle the category "created" event.
     *
     * @param  \App\Category  $category
     * @return void
     */
    public function created(Category $category)
    {
        $ascendantIds = CategoryHierarchy::where('child_id', $category->parent_id)->pluck('parent_id')->toArray();
        $ascendantIds[] = $category->parent_id;
        $rows = [];
        foreach ($ascendantIds as $parentId) {
            $rows[] = ['parent_id' => $parentId, 'child_id' => $category->id];
        }
        CategoryHierarchy::insert($rows);
    }

    /**
     * Handle the category "updated" event.
     *
     * @param  \App\Category  $category
     * @return void
     */
    public function updated(Category $category)
    {
        //
    }

    /**
     * Handle the category "deleted" event.
     *
     * @param  \App\Category  $category
     * @return void
     */
    public function deleted(Category $category)
    {
        //
    }

    /**
     * Handle the category "restored" event.
     *
     * @param  \App\Category  $category
     * @return void
     */
    public function restored(Category $category)
    {
        //
    }

    /**
     * Handle the category "force deleted" event.
     *
     * @param  \App\Category  $category
     * @return void
     */
    public function forceDeleted(Category $category)
    {
        //
    }
}
