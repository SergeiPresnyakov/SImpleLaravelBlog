<?php

namespace App\Observers;

use App\Http\Requests\BlogPostUpdateRequest;
use App\Models\BlogPost;
use Illuminate\Support\Carbon;

class BlogPostObserver
{
    /**
     * Отработка перед созданием записи
     * 
     * @param BlogPost $blogPost
     */
    public function creating(BlogPost $blogPost)
    {
        dd(__METHOD__);
       /*  $this->setPublishedAt($blogPost);
        $this->setSlug($blogPost); */
    }

    /**
     * Отработка перед обновлением записи
     * 
     * @param BLogPost $blogPost
     */
    public function updating(BlogPost $blogPost)
    {   
        $this->setPublishedAt($blogPost);
        $this->setSlug($blogPost);
    }

    /**
     * Если дата публикации не установлена и происходит установка флага "Published"
     * то устанавливаем дату публикации на текущую
     * 
     * @param BlogPost $blogPost
     */
    protected function setPublishedAt(BlogPost $blogPost)
    {   
        $isPublishedAtNeeded = empty($blogPost->published_at) && $blogPost->is_published;
        
        if ($isPublishedAtNeeded) {
            $blogPost->published_at = Carbon::now();
        }
    }

    /**
     * Если поле slug пустое, то заполняем его конвертацией заголовка
     * 
     * @param BlogPost $blogPost
     */
    protected function setSlug(BlogPost $blogPost)
    {
        if (empty($blogPost->slug)) {
            $blogPost->slug = str_slug($blogPost->title);
        }
    }

    /**
     * Handle the blog post "deleted" event.
     *
     * @param  \App\Models\BlogPost  $blogPost
     * @return void
     */
    public function deleted(BlogPost $blogPost)
    {
        dd(__METHOD__);
    }

    /**
     * Handle the blog post "restored" event.
     *
     * @param  \App\Models\BlogPost  $blogPost
     * @return void
     */
    public function restored(BlogPost $blogPost)
    {
        dd(__METHOD__);
    }

    /**
     * Handle the blog post "force deleted" event.
     *
     * @param  \App\Models\BlogPost  $blogPost
     * @return void
     */
    public function forceDeleted(BlogPost $blogPost)
    {
        dd(__METHOD__);
    }
}
