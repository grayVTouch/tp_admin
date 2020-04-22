<?php
/**
 * Created by PhpStorm.
 * User: grayVTouch
 * Date: 2019/7/30
 * Time: 11:34
 */

namespace app\im\model;


class ArticleContentModel extends Model
{
    protected $table = 'cq_article_content';

    public static function updateByArticleId(int $article_id , string $content)
    {
        return self::where('article_id' , $article_id)
            ->update([
                'content' => $content
            ]);
    }
}