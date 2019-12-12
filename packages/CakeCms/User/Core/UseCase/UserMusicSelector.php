<?php

namespace CakeCms\User\Core\UseCase;

use CakeCms\User\Core\Model\Music;
use CakeCms\User\Core\Model\User;
use CakeCms\User\Core\Port\UserMusicPort;

final class UserMusicSelector
{
    private UserMusicPort $port;

    /**
     * @param UserMusicPort $port
     */
    public function __construct(UserMusicPort $port)
    {
        $this->port = $port;
    }

    public function run(int $userId): ?Music
    {
        $user = $this->port->findUser($userId);
        $music_id = $this->choice_music($user);
        return $this->port->findMusic($music_id);
    }

    /**
     * ユーザー情報（好きなジャンルとか）と時間などの組み合わせで音楽を探す。
     * 今回はテスト用に現在時間だけで音楽IDを決める
     * @param User $user
     * @return int
     */
    private function choice_music(User $user): int
    {
        //$user 今回は利用しない。
        $jpn_time = time() + 9 * (60 * 60);//日本時間
        switch (true) {
            case date('H', $jpn_time) > 4 && date('H', $jpn_time) < 10:
                $result = 1;
                break;
            case  date('H', $jpn_time) >= 10 && date('H', $jpn_time) < 17:
                $result = 2;
                break;
            default:
                $result = 3;
                break;
        }
        return $result;
    }

}
