# CakePHPへのコアレイヤーパターンの適用

## バージョンアップで困らないためにすること
- CakePHPのファイルを軽量にする。
- アプリケーション独自の実行プログラムは別にしておく

## コアレイヤーパターンは上記にマッチ
- 新原 雅司 さんが提案しているアプリケーションアーキテクチャパターンの一つ
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
