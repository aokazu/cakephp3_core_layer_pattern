<?php

namespace CakeCms\User\Application\Adapter;


use App\Model\Table\MusicsTable;
use App\Model\Table\UsersTable;
use CakeCms\User\Core\Exception\NotFoundException;
use CakeCms\User\Core\Model\Music;
use CakeCms\User\Core\Model\User;
use CakeCms\User\Core\Port\UserMusicPort;

$core_dir = dirname(__FILE__).'/../../Core';
require_once($core_dir.'/Model/Music.php');
require_once($core_dir.'/Model/User.php');
require_once($core_dir.'/Port/UserMusicPort.php');


final class UserMusicAdapter implements UserMusicPort
{
    private UsersTable $Users;
    private MusicsTable $Musics;

    /**
     * @param UsersTable $users
     * @param MusicsTable $musics
     */
    public function __construct(UsersTable $users, MusicsTable $musics)
    {
        $this->Users = $users;
        $this->Musics = $musics;
    }

    public function findMusic(int $id): ?Music
    {
        $entity = $this->Musics->get($id);
        if (!$entity) {
            throw new NotFoundException('音楽が未登録です。');
        }
        return new Music($entity->id, $entity->title, $entity->category, $entity->created, $entity->modified);
    }

    public function findUser(int $id): ?User
    {
        $entity = $this->Users->get($id);
        if (!$entity) {
            throw new NotFoundException('ユーザーが未登録です。');
        }
        return new User($entity->id, $entity->email, $entity->password, $entity->created, $entity->modified);
    }

}
