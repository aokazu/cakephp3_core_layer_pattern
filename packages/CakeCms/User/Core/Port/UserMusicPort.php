<?php

namespace CakeCms\User\Core\Port;

use CakeCms\User\Core\Model\Music;
use CakeCms\User\Core\Model\User;

interface UserMusicPort
{
    public function findMusic(int $id): ?Music;

    public function findUser(int $id): ?User;
}
