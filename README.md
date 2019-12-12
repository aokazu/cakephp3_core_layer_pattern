# CakePHPへのコアレイヤーパターンの適用

## バージョンアップで困らないためにすること
- CakePHPのファイルを軽量にする。
- アプリケーション独自の実行プログラムは別にしておく

## コアレイヤーパターンは上記にマッチ
- 新原雅司氏が提案しているアプリケーションアーキテクチャパターンの一つ
- 詳しくは以下のURLを参照してください。
- https://blog.shin1x1.com/entry/independent-core-layer-pattern


## コアレイヤーパターンを恐れずに簡単に言いうと
- プラグにモデルをセットし実行プログラムに差し込んで動かす。

### 例）ユーザーに最適な音楽を抽出する

```php
class UsersController extends AppController{

  public function select_music(int $user_id ){

    //ユーザーと音楽モデルをセットしてプラグを作成
    $plug = new UserMusicAdapter(
      $this->User,
      $this->Music,
     );

    //UserMusicSelectorプログラムにプラグを差し込んでRunすると最適な音楽を抽出する。
    $useCase = new UserMusicSelector($plug);
    $data = $useCase->run($user_id);

    //viewに値セット
    $this->set(compact('data'));
  }

}
```
- 何がやりたいかパッと見てわかると思いませんか？
- UserMusicSelectorはCakePHPとは切り離しているので、CakePHPのバージョンアップがあっても影響を受けません。
- ただし UserMusicAdapter は CakePHPとコアレイヤーの橋渡し部分なので、CakePHPのバージョンアップの影響を受けます。

## UserMusicAdapter の実装

その名の通り CakepPHPと Coreプログラムを橋渡しする変換アダプターとなります。
基本的には CakepPHP のモデルをセットして処理後に Core側のモデルオブジェクトに変換して結果を渡す処理になります。


```php
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
```
