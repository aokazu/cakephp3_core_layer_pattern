<?php

namespace CakeCms\User\Core\Test\UseCase;

use CakeCms\User\Core\Model\User;
use CakeCms\User\Core\Model\Music;
use CakeCms\User\Core\Port\UserMusicPort;
use CakeCms\User\Core\UseCase\UserMusicSelector;
use PHPUnit\Framework\TestCase;

$core_dir = dirname(__FILE__).'/../../';
require_once($core_dir.'/Port/UserMusicPort.php');
require_once($core_dir.'/Model/Music.php');
require_once($core_dir.'/Model/User.php');
require_once($core_dir.'/UseCase/UserMusicSelector.php');

final class UserMusicSelectorTest extends TestCase
{
    /**
     * @test
     */
    public function start()
    {
        $adapter = new class implements UserMusicPort {
            public function findUser(int $id): ?User
            {
                return new User(1,'hoge@hoge.com','password','2019/12/11 10:00:00','2019/12/11 10:10:10');
            }

            public function findMusic(int $id): ?Music
            {
                return new Music(1,'朝のボサノバ','ラテン','2019/12/11 10:00:00','2019/12/11 10:10:10');
            }
        };
        $sut = new UserMusicSelector($adapter);
        $music = $sut->run(1);
        $this->assertSame($music->getTitle(), '朝のボサノバ');
    }


}

