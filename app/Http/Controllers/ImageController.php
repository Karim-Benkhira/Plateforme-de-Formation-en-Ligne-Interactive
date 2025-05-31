<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ImageController extends Controller
{
    /**
     * Generate a default course image.
     */
    public function defaultCourse(Request $request)
    {
        $title = $request->get('title', 'Course Content');
        $width = $request->get('width', 400);
        $height = $request->get('height', 225);
        
        // Create SVG content
        $svg = $this->generateCourseSVG($title, $width, $height);
        
        return response($svg)
            ->header('Content-Type', 'image/svg+xml')
            ->header('Cache-Control', 'public, max-age=3600');
    }
    
    /**
     * Generate SVG for course placeholder.
     */
    private function generateCourseSVG($title, $width, $height)
    {
        $title = htmlspecialchars($title);
        
        return <<<SVG
<svg width="{$width}" height="{$height}" viewBox="0 0 {$width} {$height}" fill="none" xmlns="http://www.w3.org/2000/svg">
  <defs>
    <linearGradient id="grad1" x1="0%" y1="0%" x2="100%" y2="100%">
      <stop offset="0%" style="stop-color:#3B82F6;stop-opacity:1" />
      <stop offset="100%" style="stop-color:#8B5CF6;stop-opacity:1" />
    </linearGradient>
  </defs>
  <rect width="{$width}" height="{$height}" fill="url(#grad1)"/>
  <circle cx="{$width/2}" cy="{$height/2 - 20}" r="40" fill="white" fill-opacity="0.2"/>
  <path d="M{$width/2 - 20} {$height/2 - 37}L{$width/2 + 20} {$height/2 - 20}L{$width/2 - 20} {$height/2 - 3}V{$height/2 - 37}Z" fill="white" fill-opacity="0.8"/>
  <text x="{$width/2}" y="{$height/2 + 40}" text-anchor="middle" fill="white" font-family="Arial, sans-serif" font-size="16" font-weight="bold">{$title}</text>
</svg>
SVG;
    }
}
