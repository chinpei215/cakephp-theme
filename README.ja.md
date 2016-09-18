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

**app/Config/bootstrap.php** ファイルの中でプラグインを有効化してください。

```php
CakePlugin::load('Theme', ['bootstrap' => true]);
```

テーマをコントローラに反映させるために `bootstrap` オプションには真を指定してください。
Theme プラグインの bootstrap には、テーマが常に有効になるための設定が含まれています。

通常、テーマを有効にする場合には コントローラ中で `$theme` プロパティにテーマ名を設定しますが、
その方法では、コントローラがインスタンス化される前に発生したエラーにはテーマが反映されません。

プラグインを読み込んだ後、以下のコマンドを実行して Cake3 テーマをインストールしてください。
**app/View/Themed** ディレクトリにテーマがコピーされます。

```sh
cake theme install Cake3
```

現在は Cake3 テーマのみをサポートしています。
