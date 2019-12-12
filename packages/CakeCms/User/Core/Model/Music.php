<?php

namespace CakeCms\User\Core\Model;


/**
 * Class Music
 * @package CakeCms\Music\Core\Model
 */
final class Music
{
    private int $id;
    private string $title;
    private string $category;
    private string $created;
    private string $modified;

    /**
     * Music constructor.
     * @param int $id
     * @param string $title
     * @param string $category
     * @param string $created
     * @param string $modified
     */
    public function __construct(int $id, string $title, string $category, string $created, string $modified)
    {
        $this->id = $id;
        $this->title = $title;
        $this->category = $category;
        $this->created = $created;
        $this->modified = $modified;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getCategory(): string
    {
        return $this->category;
    }


    /**
     * @return string
     */
    public function getCreated(): string
    {
        return $this->created;
    }

    /**
     * @return string
     */
    public function getModified(): string
    {
        return $this->modified;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }



}
