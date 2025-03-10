# Japonizm テーマの翻訳ガイド

このドキュメントでは、Japonizmテーマの翻訳ファイルの更新方法について説明します。

## 翻訳ファイルの概要

Japonizmテーマは、以下の翻訳ファイルを使用しています：

- `languages/japonizm.pot` - 翻訳テンプレートファイル
- `languages/ja.po` - 日本語翻訳ファイル（テキスト形式）
- `languages/ja.mo` - 日本語翻訳ファイル（バイナリ形式）

## 翻訳ファイルの更新方法

### 1. POファイルの編集

POファイルは、テキストエディタで直接編集することもできますが、[Poedit](https://poedit.net/)などの専用ツールを使用することをお勧めします。

1. Poeditを開き、`languages/ja.po`ファイルを開きます。
2. 翻訳を編集します。
3. 保存すると、自動的に`.mo`ファイルも生成されます。

### 2. コマンドラインでの更新

WordPressのWP-CLIを使用して翻訳ファイルを更新することもできます：

```bash
# POファイルからMOファイルを生成
wp i18n make-mo languages/ja.po languages/
```

または、GNU gettext toolsを使用する場合：

```bash
msgfmt -o languages/ja.mo languages/ja.po
```

### 3. PHPスクリプトでの更新

このテーマには、PHPを使用してPOファイルからMOファイルを生成するスクリプト`generate-mo.php`が含まれています。WordPress環境内で以下のコマンドを実行してください：

```bash
php generate-mo.php
```

## 新しい翻訳文字列の追加

テーマに新しいテキストを追加する場合は、以下の関数を使用して翻訳可能にしてください：

```php
// 翻訳テキストを出力
_e( 'テキスト', 'japonizm' );

// 翻訳テキストを返す
$text = __( 'テキスト', 'japonizm' );

// HTMLエスケープして翻訳テキストを出力
esc_html_e( 'テキスト', 'japonizm' );

// HTMLエスケープして翻訳テキストを返す
$text = esc_html__( 'テキスト', 'japonizm' );
```

## 翻訳テンプレート（POT）ファイルの更新

テーマに新しいテキストを追加した後、POTファイルを更新する必要があります。WP-CLIを使用して以下のコマンドを実行してください：

```bash
wp i18n make-pot . languages/japonizm.pot --domain=japonizm
```

POTファイルを更新した後、各言語のPOファイルを更新してください。

## 注意事項

- テーマ全体で一貫して`japonizm`テキストドメインを使用してください。
- 翻訳関数を使用する際は、常にテキストドメインを指定してください。
- JavaScriptファイル内での翻訳には、WordPress標準の翻訳関数を使用してください。

## 参考リンク

- [WordPress Codex: 国際化](https://wpdocs.osdn.jp/%E5%9B%BD%E9%9A%9B%E5%8C%96)
- [WordPress Developer Resources: Internationalization](https://developer.wordpress.org/themes/functionality/internationalization/)
- [Poedit](https://poedit.net/) 