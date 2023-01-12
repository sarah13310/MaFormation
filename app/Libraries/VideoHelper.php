<?php

namespace App\Libraries;

class VideoHelper
{
    function getVideos()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('media');
        $builder->where('type', '1');
        $query   = $builder->get();
        $videos = $query->getResultArray();
        return [
            'builder' => $builder,
            'videos' => $videos,
        ];
    }

    function getTitleAllVideos()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('media');
        $builder->where('type', '1');
        $query   = $builder->get();
        $videos = $query->getResultArray();
        return $videos;
    }

    function isExist($url)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('media');
        $builder->where('url', $url);
        $query   = $builder->get();
        $items = $query->getResultArray();
        return (count($items) == 0) ? false : true;
    }

}
