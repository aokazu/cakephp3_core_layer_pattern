<?php

namespace CakeCms\User\Core\Model;

/**
 * Class User
 * @package CakeCms\User\Core\Model
 */
final class User
{
    private int $id;
    private string $email;
    private string $password;
    private string $created;
    private string $modified;

    /**
     * User constructor.
     * @param int $id
     * @param string $email
     * @param string $password
     * @param string $created
     * @param string $modified
     */
    public function __construct(int $id, string $email, string $password, string $created, string $modified)
    {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
        $this->created = $created;
        $this->modified = $modified;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
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
