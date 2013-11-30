<?php
use Kinzal\SSTP\SSTP;

// example http://usada.sakura.vg/contents/sstp.html
class SSTPTest extends PHPUnit_Framework_TestCase
{
  public $sstp;

    public function setUp()
    {
        $this->sstp = new SSTP();
    }

    public function tearDown()
    {
        sleep(5);
    }

    public function test_Charset()
    {
        $this->sstp->message = '
                        SEND SSTP/1.1
                        Sender: カードキャプター
                        Script: \0\s0汝のあるべき姿に戻れ。\e
                        Option: nodescript,notranslate
                        Charset: UTF-8
        ';
        $this->sstp->charset = 'UTF-8';
        $response = $this->sstp->send('127.0.0.1', 9801, 2);

        var_dump($response); echo "\n";
    }

    public function test_NOTIFY10()
    {
        $this->sstp->message = '
            NOTIFY SSTP/1.0
            Sender: さくら
            Event: OnMusicPlay
            Reference0: 元祖高木ブー伝説
            Reference1: 筋肉少女帯
            Charset: Shift_JIS
        ';
        $response = $this->sstp->send('127.0.0.1', 9801, 2);

        var_dump($response); echo "\n";
    }

    public function test_NOTIFY11()
    {
        $this->sstp->message = '
            NOTIFY SSTP/1.1
            Sender: さくら
            Event: OnMusicPlay
            Reference0: 元祖高木ブー伝説
            Reference1: 筋肉少女帯
            IfGhost: なる,ゆうか
            Script: \h\s0‥‥\w8\w8高木ブーだね。\u\s0‥‥\e
            IfGhost: さくら,うにゅう
            Script: \h\s0‥‥\w8\w8高木ブーだね。\u\s0‥‥\w8\w8むう。\e
            Charset: Shift_JIS
        ';
        $response = $this->sstp->send('127.0.0.1', 9801, 2);

        var_dump($response); echo "\n";
    }

    public function test_SEND11()
    {
        $this->sstp->message = '
            SEND SSTP/1.1
            Sender: カードキャプター
            Script: \h\s0汝のあるべき姿に戻れ。\e
            Option: nodescript,notranslate
            Charset: Shift_JIS
        ';
        $response = $this->sstp->send('127.0.0.1', 9801, 2);

        var_dump($response); echo "\n";
    }

    public function test_SEND12()
    {
        $this->sstp->message = '
            SEND SSTP/1.2
            Sender: カードキャプター
            Script: \h\s0どんな感じ？\n\n\q0[#temp0][まあまあ]\q1[#temp1][今ひとつ]\z
            Entry: #temp0,\h\s0ふーん。\e
            Entry: #temp1,\h\s0酒に逃げるなヨ！\e
            Charset: Shift_JIS
        ';
        $response = $this->sstp->send('127.0.0.1', 9801, 2);

        var_dump($response); echo "\n";
    }

    // ssp is stopping on mac.
    // public function test_SEND13()
    // {
    //     $this->sstp->message = '
    //         SEND SSTP/1.3
    //         Sender: カードキャプター
    //         HWnd: 1024
    //         Script: \h\s0どんな感じ？\n\n\q0[#temp0][まあまあ]\q1[#temp1][今ひとつ]\z
    //         Entry: #temp0,\m[1025,0,0]\h\s0ふーん。\m[1025,0,1]\e
    //         Entry: #temp1,\m[1025,1,0]\h\s0酒に逃げるなヨ！\m[1025,1,1]\e
    //         Charset: Shift_JIS
    //     ';
    //     $response = $this->sstp->send('127.0.0.1', 9801, 2);
    //
    //     var_dump($response); echo "\n";
    // }

    public function test_SEND14()
    {
        $this->sstp->message = '
            SEND SSTP/1.4
            Sender: カードキャプター
            IfGhost: さくら,うにゅう
            Script: \h\s0さくらだー。\w8\n\n%j[#mainblock]
            IfGhost: せりこ,まるちい
            Script: \h\s0せりこだー。\w8\n\n%j[#mainblock]
            IfGhost: さくら,ケロ
            Script: \u\s0わいのはモダン焼きにしてや～。\w8\h\s0はいはい。\e
            Entry: #mainblock,\s7寝言は寝てから言えっ！\w8\u\s0落ち着けっ！\e
            Charset: Shift_JIS
        ';
        $response = $this->sstp->send('127.0.0.1', 9801, 2);

        var_dump($response); echo "\n";
    }

    public function test_EXECUTE10()
    {
        $this->sstp->message = '
            EXECUTE SSTP/1.0
            Sender: サンプルプログラム
            Command: GetName
            Charset: Shift_JIS
        ';
        $response = $this->sstp->send('127.0.0.1', 9801, 2);

        var_dump($response); echo "\n";
    }

    public function test_EXECUTE11()
    {
        $this->sstp->message = '
            EXECUTE SSTP/1.1
            Sender: カードキャプター
            Command: SetCookie[visitcount,1]
            Charset: Shift_JIS
        ';
        $response = $this->sstp->send('127.0.0.1', 9801, 2);

        var_dump($response); echo "\n";

        $this->sstp->message = '
            EXECUTE SSTP/1.1
            Sender: カードキャプター
            Command: GetCookie[visitcount]
            Charset: Shift_JIS
        ';
        $response = $this->sstp->send('127.0.0.1', 9801, 2);

        var_dump($response); echo "\n";
    }

    public function test_EXECUTE12()
    {
        $this->sstp->message = '
            EXECUTE SSTP/1.2
            Sender: カードキャプター
            Command: GetVersion
            Charset: Shift_JIS
        ';
        $response = $this->sstp->send('127.0.0.1', 9801, 2);

        var_dump($response); echo "\n";
    }

    public function test_EXECUTE13()
    {
        $this->sstp->message = '
            EXECUTE SSTP/1.3
            Sender: カードキャプター
            Command: Quiet
            Charset: Shift_JIS
        ';
        $response = $this->sstp->send('127.0.0.1', 9801, 2);

        var_dump($response); echo "\n";
    }

    public function test_GIVE11()
    {
        $this->sstp->message = '
            GIVE SSTP/1.1
            Sender: カードキャプター
            Document: こんにちはさくらです。闇の力を秘めし鍵よ真の姿を我の前に示せレリーズ。汝のあるべき姿に戻れクロウカード。
            Charset: Shift_JIS
        ';
        $response = $this->sstp->send('127.0.0.1', 9801, 2);

        var_dump($response); echo "\n";
    }

    public function test_COMMUNICATE11()
    {
        $this->sstp->message = '
            COMMUNICATE SSTP/1.1
            Sender: カードキャプター
            Sentence: 今日は寒いなー。
            Option: substitute
            Charset: Shift_JIS
        ';
        $response = $this->sstp->send('127.0.0.1', 9801, 2);

        var_dump($response); echo "\n";
    }

    public function test_COMMUNICATE12()
    {
        $this->sstp->message = '
            COMMUNICATE SSTP/1.2
            Sender: 双葉
            HWnd: 0
            Sentence: \0\s0どうも。\e
            Surface: 0,10
            Reference0: N/A
            Charset: Shift_JIS
        ';
        $response = $this->sstp->send('127.0.0.1', 9801, 2);

        var_dump($response); echo "\n";
    }

}
