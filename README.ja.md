[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.txt)

# CakePHP2 Theme プラグイン

Theme プラグインは CakePHP2 の標準の見栄えを CakePHP3 風に変更できる素敵なプラグインです。

他の言語で読む: [English](README.md), **日本語**

## 必須環境

PHP5.3 以上

## インストール

### composer でのインストール

以下のコマンドを実行してください。

```sh
php composer.phar require chinpei215/cakephp-theme
```

### zip でのインストール

任意の [Theme プラグインのリリース](https://github.com/chinpei215/cakephp-theme/releases) (Source code) をダウンロードしてください。
解凍後、 **Theme** という名前での **app/Plugin** ディレクトリに設置してください。

## セットアップ

### プラグインの読込
**app/Config/bootstrap.php** の中でプラグインを有効化してください。

```php
CakePlugin::load('Theme', ['bootstrap' => true]);
```

テーマをコントローラに反映させるために `bootstrap` オプションには真を指定してください。
Theme プラグインの bootstrap には、テーマを常に有効にするための設定が含まれています。

### ThemeAppShell の継承

**app/Console/Commannd/AppShell.php** を変更して `AppShell` を `ThemeAppShell` の派生クラスに変更してください。

```php
App::uses('ThemeAppShell', 'Theme.Console/Command');

class AppShell extends ThemeAppShell {
}
```

### テーマのインストール

以下のコマンドを実行してテーマをインストールしてください。
既定では **app/View/Themed** ディレクトリ配下に Cake3 テーマがコピーされます。

```sh
cake theme install
```

もしも、テーマとしてインストールをするのではなく **app/View** および **app/webroot** を上書きしたい場合は、
**app/Config/bootstrap.php** の中で `Theme.useThemePath` に偽を指定した後に上記のコマンドを実行してください。

```php
Configure::write('Theme.useThemePath', false);
```

### ビューの bake

bake コマンドを実行して必要なビューを作成してください。

```sh
cake bake view Users
```

上述の `Theme.useThemePath` に偽が指定されていない限り、ビューは Themed ディレクトリ配下に作成されます。

## 高度な使用方法

### テーマの無効化

`Theme.useThemePath` が有効になっていると、コントローラの `$theme` プロパティが `null` の場合に、
自動的に Cake3 テーマが設定されるようになります。
特定のコントローラでテーマを無効化したい場合は `$theme` に false を指定してください。

```php
class SomeController extends AppController
{
	public $theme = false;
}
```

### bake するテーマの選択

Theme プラグインをインストールすると、 bake は `Theme.name` で指定されているテーマてビューを作成するようになります。
任意のテーマでビューを作成したい場合は、 `--theme` オプションを指定してください。

```
cake bake view Users --theme default
```

有効な候補からテーマを選択したい場合は、 値を付けずに `--theme` オプションを指定してください。

```sh
cake bake view Users --theme
```
