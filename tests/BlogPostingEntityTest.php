<?php

namespace JDZ\JsonLd\Tests;

use PHPUnit\Framework\TestCase;
use JDZ\JsonLd\BlogPostingEntity;
use JDZ\JsonLd\PersonEntity;
use JDZ\JsonLd\OrganizationEntity;

class BlogPostingEntityTest extends TestCase
{
    public function testMakeBasic(): void
    {
        $post = new BlogPostingEntity();
        $result = $post->make(
            'https://example.com/blog/post',
            'Blog Title',
            'Summary',
            '2024-06-01',
            'https://example.com/image.jpg'
        );

        $this->assertEquals('Blog Title', $post->get('headline'));
        $this->assertEquals('Summary', $post->get('abstract'));
        $this->assertEquals('2024-06-01', $post->get('datePublished'));
        $this->assertEquals('https://example.com/image.jpg', $post->get('image'));
        $this->assertTrue($post->has('mainEntityOfPage'));
        $this->assertFalse($post->has('author'));
        $this->assertFalse($post->has('publisher'));
        $this->assertSame($post, $result);
    }

    public function testMakeWithAuthorAndPublisher(): void
    {
        $post = new BlogPostingEntity();
        $post->make(
            'https://example.com/blog/post',
            'Title',
            'Abstract',
            '2024-06-01',
            'https://example.com/img.jpg',
            'John Doe',
            '2024-06-15',
            'Acme Corp'
        );

        $this->assertTrue($post->has('author'));
        $this->assertTrue($post->has('publisher'));
        $this->assertEquals('2024-06-15', $post->get('dateModified'));
    }

    public function testSetAuthor(): void
    {
        $post = new BlogPostingEntity();
        $author = new PersonEntity();
        $author->make('Jane');

        $result = $post->setAuthor($author);

        $this->assertSame($author, $post->get('author'));
        $this->assertSame($post, $result);
    }

    public function testSetPublisher(): void
    {
        $post = new BlogPostingEntity();
        $publisher = new OrganizationEntity();
        $publisher->make('Org', 'https://org.com', '');

        $result = $post->setPublisher($publisher);

        $this->assertSame($publisher, $post->get('publisher'));
        $this->assertSame($post, $result);
    }
}
