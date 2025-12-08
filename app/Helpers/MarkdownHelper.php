<?php

namespace App\Helpers;

class MarkdownHelper
{
    /**
     * Convert YouTube URL to embed URL
     */
    public static function convertYouTubeUrl($url)
    {
        if (empty($url)) {
            return $url;
        }

        // Extract video ID from various YouTube URL formats
        $patterns = [
            '/youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/',  // Regular watch URL
            '/youtu\.be\/([a-zA-Z0-9_-]+)/',              // Short URL
            '/youtube\.com\/embed\/([a-zA-Z0-9_-]+)/',     // Already embed
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url, $matches)) {
                return 'https://www.youtube.com/embed/' . $matches[1];
            }
        }

        // If not a YouTube URL, return as is
        return $url;
    }

    /**
     * Convert markdown to HTML
     */
    public static function parse($markdown)
    {
        if (empty($markdown)) {
            return '';
        }

        $html = $markdown;

        // Escape HTML to prevent XSS
        // $html = htmlspecialchars($html, ENT_QUOTES, 'UTF-8');

        // Code blocks (must be before inline code)
        $html = preg_replace('/```([^`]+)```/s', '<pre><code>$1</code></pre>', $html);
        
        // Inline code (must be after code blocks)
        $html = preg_replace('/`([^`]+)`/', '<code>$1</code>', $html);

        // Headers (must be at start of line)
        $html = preg_replace('/^### (.+)$/m', '<h3>$1</h3>', $html);
        $html = preg_replace('/^## (.+)$/m', '<h2>$1</h2>', $html);
        $html = preg_replace('/^# (.+)$/m', '<h1>$1</h1>', $html);

        // Bold (** or __)
        $html = preg_replace('/\*\*(.+?)\*\*/', '<strong>$1</strong>', $html);
        $html = preg_replace('/__(.+?)__/', '<strong>$1</strong>', $html);

        // Italic (* or _) - but not ** or __
        $html = preg_replace('/(?<!\*)\*(?!\*)(.+?)(?<!\*)\*(?!\*)/', '<em>$1</em>', $html);
        $html = preg_replace('/(?<!_)_(?!_)(.+?)(?<!_)_(?!_)/', '<em>$1</em>', $html);

        // Links
        $html = preg_replace('/\[([^\]]+)\]\(([^\)]+)\)/', '<a href="$2" target="_blank" rel="noopener">$1</a>', $html);

        // Images
        $html = preg_replace('/!\[([^\]]*)\]\(([^\)]+)\)/', '<img src="$2" alt="$1" class="max-w-full h-auto rounded-lg" />', $html);

        // Unordered lists
        $html = preg_replace_callback('/^[\-\*\+] (.+)$/m', function($matches) {
            return '<li>' . $matches[1] . '</li>';
        }, $html);
        
        // Wrap consecutive <li> in <ul>
        $html = preg_replace('/(<li>.*<\/li>\n?)+/s', '<ul>$0</ul>', $html);

        // Ordered lists
        $html = preg_replace_callback('/^\d+\. (.+)$/m', function($matches) {
            return '<li>' . $matches[1] . '</li>';
        }, $html);
        
        // Wrap consecutive <li> in <ol> (for ordered lists)
        $html = preg_replace('/(<li>.*<\/li>\n?)+/s', '<ol>$0</ol>', $html);

        // Blockquotes
        $html = preg_replace('/^&gt; (.+)$/m', '<blockquote>$1</blockquote>', $html);
        $html = preg_replace('/^> (.+)$/m', '<blockquote>$1</blockquote>', $html);

        // Horizontal rules
        $html = preg_replace('/^(-{3,}|\*{3,}|_{3,})$/m', '<hr />', $html);

        // Line breaks (2 spaces at end of line or double newline)
        $html = preg_replace('/  \n/', '<br>', $html);
        $html = nl2br($html);

        return $html;
    }
}
