# CakePHPへコアレイヤーパターンの適用

2019/11/30に開催された「大改修！PHPレガシーコードビフォーアフター」イベントで新原雅司氏の「コアレイヤーパターン」の発表を聴き大変感銘を受けました。
その復習も兼ねて実際のプラグラムを作成し文書にまとめてみました。


## バージョンアップで困らないためにしておきたいこと
- CakePHPのファイルを軽量にする。
- アプリケーション独自の実行プログラムは別にしておく。

## コアレイヤーパターン
- 上記を正に実現させる手段として有効。
- 新原雅司氏が提案しているアプリケーションアーキテクチャパターンの一つ
- 詳しくは以下のURLを参照してください。
- https://blog.shin1x1.com/entry/independent-core-layer-pattern
- https://speakerdeck.com/shin1x1/fortee-meets-independent-core-layer-pattern


## コアレイヤーパターンを恐れずに簡単に言いうと
- 変換プラグにCakeのモデルをセットしコアプログラムに差し込んで処理をするということ。


### 例）ユーザーに最適な音楽を抽出する

CakePHP側のUsersコントローラーに書き加えた例です。

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
- コアレイヤーパターンを適用すると何がやりたいかパッと見てわかるプログラムになります。
- UserMusicSelectorはCakePHPとは切り離されているので、CakePHPのバージョンアップがあっても影響を受けません。
- しかしながらUserMusicAdapter は CakePHPとコアレイヤーの橋渡し部分なのでバージョンアップの影響を受けます。

## UserMusicAdapter

その名の通り CakepPHPと Coreプログラムを橋渡しする変換アダプターとなります。
基本的には CakepPHP のモデルをセットして処理後に Core側のモデルオブジェクトに変換して結果を渡す処理になります。


```php
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

## UserMusicSelector

Coreプログラムとなります。CakepPHPからは完全に分離した処理となっています。
もしバージョンアップがあったとしても、全く影響を受けません。


```php
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
```

## Coreプログラムのテスト

CakePHPの影響は全く受けない PHPUnit テストも可能になります。

```php
use PHPUnit\Framework\TestCase;

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

```

## 今回のソースコード

- GitHubにソースコードをアップしました。
- https://github.com/aokazu/cakephp3_core_layer_pattern

## 環境構築方法

Dockerの利用が初めてなので、もっと簡単にできるのだとは思いますが現状では以下の通りです。

1. WEB側はCakePHPをインストール後に src をGitHubから取得して入れ替え
```sh
git clone https://github.com/aokazu/cakephp3_core_layer_pattern.git
```
2. src と同じ階層に packages を配置
3. config/app.php を上書き
4. DBサーバーはDockerから取得して起動  
```sh
docker pull aokikazuyuki/clp_db
docker start clp_db
```
5. CakePHPのルートフォルダに移動してWEBサーバー起動  
```sh
./bin/cake server
```
6. 動作確認 URL にアクセス（http://localhost:8765/Users/selectMusic/1）


## まとめ

クラス定義やファイルの読み込みが多数発生しますのでディレクトリ構造をよく理解していない間は動かすのに苦労しました。
実際の現場に適用するには時間がものすごく係ると思いますが、出来るところからコツコツと積み上げて行くしか無いですね。
