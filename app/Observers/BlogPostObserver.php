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
        $this->setPublishedAt($blogPost);
        $this->setSlug($blogPost);
        $this->setHtml($blogPost);
        $this->setUser($blogPost);
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
     * Установка значения полю content_html относительно поля content_raw
     * 
     * @param BlogPost $blogPost
     */
    protected function setHtml(BlogPost $blogPost)
    {
        if ($blogPost->isDirty('content_raw')) {
            // TODO: Тут должна быть генерация markdown -> HTML
            $blogPost->content_html = $blogPost->content_raw;
        }
    }

    /**
     * Если не указан user_id, то устанавливаем пользователя по-умолчанию
     * 
     * @param BlogPost $blogPost
     */
    protected function setUser(BlogPost $blogPost)
    {
        $blogPost->user_id = auth()->id() ?? BlogPost::UNKNOWN_USER;
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
     * @param App\Models\BlogPost $blogPost
     */
    public function deleting(BlogPost $blogPost)
    {
        //dd(__METHOD__, $blogPost);
        //return false;
    }

    /**
     * Handle the blog post "deleted" event.
     *
     * @param  \App\Models\BlogPost  $blogPost
     * @return void
     */
    public function deleted(BlogPost $blogPost)
    {
        //dd(__METHOD__);
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
