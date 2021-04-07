<?php namespace ZN\Security;

use Secure;

class SecureTest extends \PHPUnit\Framework\TestCase
{
    public function testData()
    {
        $this->assertEquals
        (
            '&#60;&#63;php echo &quot;This is&quot;; &#63;&#62; &lt;b&gt;example code!&lt;/b&gt;', 
            Secure::data('<?php echo "This is"; ?> <b>example code!</b>')
                ->phpTagEncode()
                ->htmlEncode()
                ->get()
        );
    }
}