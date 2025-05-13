<?php

if (!function_exists('getYoutubeEmbedUrl')) {
    /**
     * Convert any YouTube URL to an embed URL
     *
     * @param string $url
     * @return string
     */
    function getYoutubeEmbedUrl($url) {
        // If it's already an embed URL, return it
        if (str_contains($url, 'youtube.com/embed/')) {
            return $url;
        }
        
        // Extract video ID from various YouTube URL formats
        $videoId = null;
        
        // Standard youtube.com URL
        if (preg_match('/youtube\.com\/watch\?v=([^&\s]+)/', $url, $matches)) {
            $videoId = $matches[1];
        }
        // Short youtu.be URL
        elseif (preg_match('/youtu\.be\/([^&\s?]+)/', $url, $matches)) {
            $videoId = $matches[1];
        }
        // YouTube embed URL
        elseif (preg_match('/youtube\.com\/embed\/([^&\s]+)/', $url, $matches)) {
            $videoId = $matches[1];
        }
        
        // If we found a video ID, return the embed URL
        if ($videoId) {
            return 'https://www.youtube.com/embed/' . $videoId;
        }
        
        // If we couldn't extract a video ID, return the original URL
        return $url;
    }
}
