<?php

namespace JDZ\JsonLd\Tests;

use PHPUnit\Framework\TestCase;
use JDZ\JsonLd\ArticleEntity;
use JDZ\JsonLd\PersonEntity;
use JDZ\JsonLd\OrganizationEntity;
use JDZ\JsonLd\WebPageEntity;

class ArticleEntityTest extends TestCase
{
    public function testMake(): void
    {
        $article = new ArticleEntity();
        $result = $article->make('https://example.com/article', 'My Article', 'Abstract text', '2024-01-15');

        $this->assertEquals('My Article', $article->get('headline'));
        $this->assertEquals('Abstract text', $article->get('abstract'));
        $this->assertEquals('2024-01-15', $article->get('datePublished'));
        $this->assertTrue($article->has('mainEntityOfPage'));
        $this->assertSame($article, $result);
    }

    public function testSetAuthor(): void
    {
        $article = new ArticleEntity();
        $article->make('https://example.com', 'Title', 'Abstract', '2024-01-01');

        $author = new PersonEntity();
        $author->make('Jane Doe');
        $article->setAuthor($author);

        $this->assertSame($author, $article->get('author'));
    }

    public function testSetPublisher(): void
    {
        $article = new ArticleEntity();
        $article->make('https://example.com', 'Title', 'Abstract', '2024-01-01');

        $publisher = new OrganizationEntity();
        $publisher->make('Acme Corp', 'https://acme.com', '');
        $article->setPublisher($publisher);

        $this->assertSame($publisher, $article->get('publisher'));
    }

    public function testSetMainEntityOfPage(): void
    {
        $article = new ArticleEntity();

        $page = new WebPageEntity();
        $page->make('https://example.com');
        $article->setMainEntityOfPage($page);

        $this->assertSame($page, $article->get('mainEntityOfPage'));
    }
}
